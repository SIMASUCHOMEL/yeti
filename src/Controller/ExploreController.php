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
    //funkce na random vybrani YETIHO
    #[Route('/explore', name:'ex')]
    public function explore(PersistenceManagerRegistry $doctrine): Response
    {
    //ziskame vsechny YETI z db
    $random_vse = $doctrine->getRepository(Zkouska::class)->findAll();
    //vybere se z nich 1 random
    $random = $random_vse[array_rand($random_vse)];    
    if ($random) {
        //pokud existuje tak vezmeme jeho Id a zobrazime ho podle nej
        $randomId = $random->getId();
        return $this->redirectToRoute('explore', ['id' => $randomId]);
    }else{
        return $this->redirectToRoute('/explore');
    }
}

    //zobrazeni 1 YETIHO podle jeho Id ->twig
    #[Route('/explore/{id}', name: 'explore')]
    public function index($id,PersistenceManagerRegistry $doctrine): Response
    {
        //ziskame id z cesty a pomoci neho ziskame YETIHO z db a zobrazime ho v twig
        $data = $doctrine->getRepository(Zkouska::class)->find($id);
        return $this->render('explore/index.html.twig', [
            'list' => $data
        ]);
    }

    //funkce na pocitani hodnoceni YETIHO z predchozi funkce a zapisovani vlastnosti do DB User podle vlastnosti YETIHO
    #[Route('hodnoceni/{action}/{id}', name:'action')]
    public function action($action, $id, PersistenceManagerRegistry $doctrine)
    {
    //ziskame YETIHO  z db podle Id
    $repository = $doctrine->getRepository(Zkouska::class)->find($id);
    //zjistime jestli ten urcity YETI ma nasledujici vlastnosti true/false
    $frajer = $repository->isFrajer();
    $smradoch = $repository->isSmradoch();
    $chytrak = $repository->isChytrak();
    $slusnak = $repository->isSlusnak();
    //z cesty zjistime jestli se bude pricitat nebo odcitat
    if ($action === 'plus'){
        //urcitemu YETIMU pricteme k jeho stavajicimu hodnoceni +1 a zapiseme do DB
        $repository->setHodnoceni($repository->getHodnoceni() + 1);
        $em = $doctrine->getManager();  
        $em->persist($repository);
        $em->flush();
        //pokud ma YETI vlastnost frajer tak se do DB USER prihlasenemu user pricte +1 k sloupci frajer
        if ($frajer === true) {
            //ziskame prihlaseneho user a jeho Id
            $user = $this->getUser();
            $userId = $user->getId();
            //ziskame info o nem z Db User
            $repo = $doctrine->getRepository(User::class)->find($userId);
            //pricteme do vlastnosti frajer +1 a zapiseme
            $repo->setFrajer($repo->getFrajer() + 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        //pokud ma YETI vlastnost smradoch tak se do DB USER prihlasenemu user pricte +1 k sloupci smradoch
        if ($smradoch === true) {
            //ziskame prihlaseneho user a jeho Id
            $user = $this->getUser();
            $userId = $user->getId();
            //ziskame info o nem z Db User
            $repo = $doctrine->getRepository(User::class)->find($userId);
            //pricteme do vlastnosti smradoch +1 a zapiseme
            $repo->setSmradoch($repo->getSmradoch() + 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        //pokud ma YETI vlastnost chytrak tak se do DB USER prihlasenemu user pricte +1 k sloupci chytrak
        if ($chytrak === true) {
            //ziskame prihlaseneho user a jeho Id
            $user = $this->getUser();
            $userId = $user->getId();
            //ziskame info o nem z Db User
            $repo = $doctrine->getRepository(User::class)->find($userId);
            //pricteme do vlastnosti chytrak +1 a zapiseme
            $repo->setChytrak($repo->getChytrak() + 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        //pokud ma YETI vlastnost slusnak tak se do DB USER prihlasenemu user pricte +1 k sloupci slusnak
        if ($slusnak === true) {
            //ziskame prihlaseneho user a jeho Id
            $user = $this->getUser();
            $userId = $user->getId();
            //ziskame info o nem z Db User
            $repo = $doctrine->getRepository(User::class)->find($userId);
            //pricteme do vlastnosti slusnak +1 a zapiseme
            $repo->setSlusnak($repo->getSlusnak() + 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        //presmerujeme se na vypocet kdo bude dalsi YETI
        return $this->redirectToRoute('kdo');

//z cesty zjistime jestli se bude pricitat nebo odcitat
    } else if ($action === 'minus') {
        //urcitemu YETIMU pricteme k jeho stavajicimu hodnoceni -1 a zapiseme do DB
        $repository->setHodnoceni($repository->getHodnoceni() - 1);
        $em = $doctrine->getManager();  
        $em->persist($repository);
        $em->flush();
        //pokud ma YETI vlastnost frajer tak se do DB USER prihlasenemu user odecte -1 k sloupci frajer
        if ($frajer === true) {
            //ziskame prihlaseneho user a jeho Id
            $user = $this->getUser();
            $userId = $user->getId();
            //ziskame info o nem z Db User
            $repo = $doctrine->getRepository(User::class)->find($userId);
            //odecteme do vlastnosti frajer -1 a zapiseme
            $repo->setFrajer($repo->getFrajer() - 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        //pokud ma YETI vlastnost smradoch tak se do DB USER prihlasenemu user odecte -1 k sloupci smradoch
        if ($smradoch === true) {
            //ziskame prihlaseneho user a jeho Id
            $user = $this->getUser();
            $userId = $user->getId();
            //ziskame info o nem z Db User
            $repo = $doctrine->getRepository(User::class)->find($userId);
            //odecteme do vlastnosti smradoch -1 a zapiseme
            $repo->setSmradoch($repo->getSmradoch() - 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        //pokud ma YETI vlastnost chytrak tak se do DB USER prihlasenemu user odecte -1 k sloupci chytrak
        if ($chytrak === true) {
            //ziskame prihlaseneho user a jeho Id
            $user = $this->getUser();
            $userId = $user->getId();
            //ziskame info o nem z Db User
            $repo = $doctrine->getRepository(User::class)->find($userId);
            //odecteme do vlastnosti chytrak -1 a zapiseme
            $repo->setChytrak($repo->getChytrak() - 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        //pokud ma YETI vlastnost slusnak tak se do DB USER prihlasenemu user odecte -1 k sloupci slusnak
        if ($slusnak === true) {
            //ziskame prihlaseneho user a jeho Id
            $user = $this->getUser();
            $userId = $user->getId();
            //ziskame info o nem z Db User
            $repo = $doctrine->getRepository(User::class)->find($userId);
            //odecteme do vlastnosti slusnak -1 a zapiseme
            $repo->setSlusnak($repo->getSlusnak() - 1);
            $em = $doctrine->getManager();
            $em->persist($repo);
            $em->flush();
        }
        //presmerujeme se na vypocet kdo bude dalsi YETI
        return $this->redirectToRoute('kdo');

    } else {
        return $this->redirectToRoute('kdo');
    }
}
    //funkce na grafy
    #[Route('/stats', name:'stats')]
    public function stats(ChartBuilderInterface $builder, PersistenceManagerRegistry $doctrine) :Response
{
    //ziskame z db top 10 YETI podle hodnoceni
    $best = $doctrine->getRepository(Zkouska::class)->findBy([], ['hodnoceni' => 'desc'], 10);
    //ziskame jmena z db a pretvorime na array??
    $jmena = [];
    foreach ($best as $graf){
        $jmena[] = $graf->getJmeno();
    }
    //ziskame hodnoceni z db a pretvorime na array??
    $hodnoceni = [];
    foreach ($best as $graf){
        $hodnoceni[] = $graf->getHodnoceni();
    }
    //zadame typ grafu
    $grafik = $builder->createChart(Chart::TYPE_BAR);
    //zapiseme vlastnosti grafu : pozadi, hranice, nadpis, DATA,
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
    //presnejsi nastaveni grafu
    $grafik->setOptions([
        'scales' => [
            'y' => [
                'suggestedMin' => 0,
            ],
        ],
    ]);
    //////////////////////////////////////
    //ziskame vsechny YETI z DB
    $vsichni = $doctrine->getRepository(Zkouska::class)->findAll();
    //ziskame jmena z db a pretvorime na array??
    $names = [];
    foreach ($vsichni as $name){
        $names[] = $name->getJmeno();
    }
    //ziskame datumNarozeni z db a pretvorime na array??
    $veky = [];
    foreach ($vsichni as $datum){
        $vekDatum = $datum->getDatum();
    //zjistime dnesni datum a vypocitame kolik je YETIMU let
    $currentDate = new DateTime();
    $interval = $currentDate->diff($vekDatum);
    $vek = $interval->y;

    $veky[] = $vek;
    }

    //zadame typ grafu
    $grafVek = $builder->createChart(Chart::TYPE_BAR);
    //zapiseme vlastnosti grafu : pozadi, hranice, nadpis, DATA,
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
    //ziskame pristup k DB
    $repository = $doctrine->getRepository(Zkouska::class);
    //spocitat kolik je v DB frajeru|smradochu|chytraku|slusnaku
    $frajer = $repository->count(['frajer'=> true]);
    $smradoch = $repository->count(['smradoch'=> true]);
    $chytrak = $repository->count(['chytrak'=> true]);
    $slusnak = $repository->count(['slusnak'=> true]);
    //najdeme vsechny frajery|smradochy|chytraky|slusnaky
    $getFrajer = $repository->findBy(['frajer'=> true]);
    $getSmradoch = $repository->findBy(['smradoch'=> true]);
    $getChytrak = $repository->findBy(['chytrak'=> true]);
    $getSlusnak = $repository->findBy(['slusnak'=> true]);
    //spocitame kolik maji dohromady hodnoceni vsichni frajeri|smradosi|chytraci|slusnaci
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
    //spocitame kolik ma prumerne 1 od kazde vlastnosti hodnoceni
    $prumerFrajeri = $pocetFrajer / $frajer;
    $prumerSmradosi = $pocetSmradoch / $smradoch;
    $prumerChytraci = $pocetChytrak / $chytrak;
    $prumerSlusnaci = $pocetSlusnak /$slusnak;



    //zadame typ grafu
    $grafKdo = $builder->createChart(Chart::TYPE_RADAR);
    //zapiseme vlastnosti grafu : pozadi, hranice, nadpis, DATA,
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


//////////////////////////////////////////////////

    //zobrazime grafy v twig
    return $this->render('explore/stats.html.twig', [
        'grafik' => $grafik,
        'grafVek'=> $grafVek,
        'grafKdo' => $grafKdo,

    ]);
}

}
