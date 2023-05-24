<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Zkouska;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use DateTime;


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
    }else{
        return $this->redirectToRoute('/explore');
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

    $frajer = $repository->isFrajer();
    $smradoch = $repository->isSmradoch();
    $chytrak = $repository->isChytrak();
    $slusnak = $repository->isSlusnak();
    if ($action === 'plus'){
        $repository->setHodnoceni($repository->getHodnoceni() + 1);
        $em = $doctrine->getManager();  
        $em->persist($repository);
        $em->flush();
        if ($frajer === true) {
            $user = $this->getUser();
            $userId = $user->getId();
            $repo = $doctrine->getRepository(User::class)->find($userId);
            $repo->setFrajer($repo->getFrajer() + 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        if ($smradoch === true) {
            $user = $this->getUser();
            $userId = $user->getId();
            $repo = $doctrine->getRepository(User::class)->find($userId);
            $repo->setSmradoch($repo->getSmradoch() + 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        if ($chytrak === true) {
            $user = $this->getUser();
            $userId = $user->getId();
            $repo = $doctrine->getRepository(User::class)->find($userId);
            $repo->setChytrak($repo->getChytrak() + 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        if ($slusnak === true) {
            $user = $this->getUser();
            $userId = $user->getId();
            $repo = $doctrine->getRepository(User::class)->find($userId);
            $repo->setSlusnak($repo->getSlusnak() + 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }

        return $this->redirectToRoute('kdo');


    } else if ($action === 'minus') {
        $repository->setHodnoceni($repository->getHodnoceni() - 1);
        $em = $doctrine->getManager();  
        $em->persist($repository);
        $em->flush();

        if ($frajer === true) {
            $user = $this->getUser();
            $userId = $user->getId();
            $repo = $doctrine->getRepository(User::class)->find($userId);
            $repo->setFrajer($repo->getFrajer() - 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        if ($smradoch === true) {
            $user = $this->getUser();
            $userId = $user->getId();
            $repo = $doctrine->getRepository(User::class)->find($userId);
            $repo->setSmradoch($repo->getSmradoch() - 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        if ($chytrak === true) {
            $user = $this->getUser();
            $userId = $user->getId();
            $repo = $doctrine->getRepository(User::class)->find($userId);
            $repo->setChytrak($repo->getChytrak() - 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        if ($slusnak === true) {
            $user = $this->getUser();
            $userId = $user->getId();
            $repo = $doctrine->getRepository(User::class)->find($userId);
            $repo->setSlusnak($repo->getSlusnak() - 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }

        return $this->redirectToRoute('kdo');

    } else {
        return $this->redirectToRoute('kdo');
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
                'backgroundColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                'borderColor' => '	rgb(0,0,0)',
                'borderWidth' => 2,
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
    //////////////////////////////////////
    $vsichni = $doctrine->getRepository(Zkouska::class)->findAll();

    $names = [];
    foreach ($vsichni as $name){
        $names[] = $name->getJmeno();
    }

    $veky = [];
    foreach ($vsichni as $datum){
        $vekDatum = $datum->getDatum();

    $currentDate = new DateTime();
    $interval = $currentDate->diff($vekDatum);
    $vek = $interval->y;

    $veky[] = $vek;
    }


    $grafVek = $builder->createChart(Chart::TYPE_BAR);
    $grafVek->setData([
        'labels' => $names,
        'datasets' => [
            [
                'label' => 'Kdo je nejstarší?',
                'backgroundColor' => [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                    'rgba(255, 205, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(201, 203, 207, 0.6)'
            ],
                'borderColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
            ],
                'borderWidth' => 2,
                'data' => $veky,





            ],
        ],
    ]);
///////////////////////////////////////////////////////////////

    $repository = $doctrine->getRepository(Zkouska::class);
    $frajer = $repository->count(['frajer'=> true]);
    $smradoch = $repository->count(['smradoch'=> true]);
    $chytrak = $repository->count(['chytrak'=> true]);
    $slusnak = $repository->count(['slusnak'=> true]);
    $getFrajer = $repository->findBy(['frajer'=> true]);
    $getSmradoch = $repository->findBy(['smradoch'=> true]);
    $getChytrak = $repository->findBy(['chytrak'=> true]);
    $getSlusnak = $repository->findBy(['slusnak'=> true]);

    $pocetFrajer = 0;
    $pocetSmradoch = 0;
    $pocetChytrak = 0;
    $pocetSlusnak = 0;

    foreach ($getFrajer as $row) {
        $value = $row->getHodnoceni();
        $pocetFrajer += $value;
    }
    foreach ($getSmradoch as $row) {
        $value = $row->getHodnoceni();
        $pocetSmradoch += $value;
    }
    foreach ($getChytrak as $row) {
        $value = $row->getHodnoceni();
        $pocetChytrak += $value;
    }
    foreach ($getSlusnak as $row) {
        $value = $row->getHodnoceni();
        $pocetSlusnak += $value;
    }

    $prumerFrajeri = $pocetFrajer / $frajer;
    $prumerSmradosi = $pocetSmradoch / $smradoch;
    $prumerChytraci = $pocetChytrak / $chytrak;
    $prumerSlusnaci = $pocetSlusnak /$slusnak;




    $grafKdo = $builder->createChart(Chart::TYPE_RADAR);
    $grafKdo->setData([
        'labels' => ['Frajeři', 'Smraďoši', 'Chytráci', 'Slušňáci'],
        'datasets' => [
            [
                'label' => 'Průměrné hodnocení podle vlastností',
                'backgroundColor' => [
                    'rgba(255, 159, 64, 0.7)',


            ],
                'borderColor' => [
                    'rgb(0, 0, 0)',
            ],
                'borderWidth' => 2,
                'data' => [$prumerFrajeri,$prumerSmradosi,$prumerChytraci,$prumerSlusnaci]





            ],
        ],
    ]);

//$user = $this->getUser();
//$username = $user->getUserIdentifier();


//////////////////////////////////////////////////



    return $this->render('explore/stats.html.twig', [
        'grafik' => $grafik,
        'grafVek'=> $grafVek,
        'grafKdo' => $grafKdo,

    ]);
}

}
