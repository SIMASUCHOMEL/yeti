<?php

namespace App\Controller;

use App\Entity\Zkouska;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ExploreController extends AbstractController
{
    #[Route('/explore', name:'ex')]
public function explore(PersistenceManagerRegistry $doctrine): Response
{
    $random_vse = $doctrine->getRepository(Zkouska::class)->findAll();
    $random = $random_vse[array_rand($random_vse)];    
    if ($random) {
        $randomId = $random->getId();
        return $this->redirectToRoute('explore', ['id' => $randomId]);
    }
}


    #[Route('/explore/{id}', name: 'explore')]
    public function index($id,PersistenceManagerRegistry $doctrine): Response
    {
        $data = $doctrine->getRepository(Zkouska::class)->find($id);
        return $this->render('explore/index.html.twig', [
            'list' => $data
        ]);
    }
    #[Route('hodnoceni/{action}/{id}', name:'action')]
    public function action($action, $id, PersistenceManagerRegistry $doctrine)
{
    $repository = $doctrine->getRepository(Zkouska::class)->find($id);
    if ($action === 'plus'){
        $repository->setHodnoceni($repository->getHodnoceni() + 1);
        $em = $doctrine->getManager();  
        $em->persist($repository);
        $em->flush();
        return $this->redirectToRoute('ex');

    } else if ($action === 'minus') {
        $repository->setHodnoceni($repository->getHodnoceni() - 1);
        $em = $doctrine->getManager();  
        $em->persist($repository);
        $em->flush();
        return $this->redirectToRoute('ex');

    } else {
        return $this->redirectToRoute('ex');
    }
}

#[Route('/stats', name:'stats')]
public function stats(ChartBuilderInterface $builder, PersistenceManagerRegistry $doctrine) :Response
{

    $best = $doctrine->getRepository(Zkouska::class)->findBy([], ['hodnoceni' => 'desc'], 10);
    $jmena = [];
    foreach ($best as $graf){
        $jmena[] = $graf->getJmeno();
    }

    $hodnoceni = [];
    foreach ($best as $graf){
        $hodnoceni[] = $graf->getHodnoceni();
    }

    $grafik = $builder->createChart(Chart::TYPE_BAR);

    $grafik->setData([
        'labels' => $jmena,
        'left' => 'Likes',
        'datasets' => [
            [
                'label' => 'TOP 10 HODNOCENí YETI',
                'backgroundColor' => 'rgb(233,150,122)',
                'borderColor' => '	rgb(0,0,0)',
                'data' => $hodnoceni,

            ],
        ],
    ]);
    $grafik->setOptions([
        'scales' => [
            'y' => [
                'suggestedMin' => 0,
            ],
        ],
    ]);




    return $this->render('explore/stats.html.twig', [
        'graf' => $grafik,
    ]);
}

}
