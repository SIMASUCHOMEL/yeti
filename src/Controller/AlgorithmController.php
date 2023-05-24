<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Zkouska;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;


class AlgorithmController extends AbstractController
{
    //funkce o rozhodnuti o tom jaky YETI se dalsi zobrazi
    #[Route('/kdo', name: 'kdo')]
    public function index(PersistenceManagerRegistry $doctrine): Response
    {
        //ziskat aktualni user a jeho Id
            $user = $this->getUser();
            $userId = $user->getId();
       //podle $userId ziskat z table User -> sploupce frajer,smradoch,chytrak,slusnak a jejich hodnoty
            $repo = $doctrine->getRepository(User::class)->find($userId);
            $frajer = $repo->getFrajer();
            $smradoch = $repo->getSmradoch();
            $chytrak = $repo->getChytrak();
            $slusnak = $repo->getSlusnak();
      //ziskani random cisla ktere urci jestli se dalsi YETI zobrazi random nebo podle toho jake vlastnosti davate nejvice like
            $rozhodnuti = random_int(1, 10);
      //jestli $rozhodnuti > 4 tak presmerovani na random Yetiho
            if ($rozhodnuti > 4){
                return $this->redirectToRoute('ex');
            }else {
     //zjistime jestli ma User nejoblibenejsi $frajer
                if ($frajer > $smradoch && $frajer > $chytrak && $frajer > $slusnak) {
                    //pokud jo tak se tak najdeme vsechny frajery a vybereme 1 random z nich
                    $repository = $doctrine->getRepository(Zkouska::class)->findBy(['frajer' => true]);
                    $random = $repository[array_rand($repository)];
                    if ($random) {
                        $randomId = $random->getId();
                        //cesta kde se zobrazi
                        return $this->redirectToRoute('explore', ['id' => $randomId]);
                    } else {
                        return $this->redirectToRoute('/explore');
                    }
     //zjistime jestli ma User nejoblibenejsi $smradoch
                } elseif ($smradoch > $frajer && $smradoch > $chytrak && $smradoch > $slusnak) {
                    //pokud jo tak se tak najdeme vsechny smradochy a vybereme 1 random z nich
                    $repository = $doctrine->getRepository(Zkouska::class)->findBy(['smradoch' => true]);
                    $random = $repository[array_rand($repository)];
                    if ($random) {
                        $randomId = $random->getId();
                        //cesta kde se zobrazi
                        return $this->redirectToRoute('explore', ['id' => $randomId]);
                    } else {
                        return $this->redirectToRoute('/explore');
                    }
     //zjistime jestli ma User nejoblibenejsi $chytrak
                } elseif ($chytrak > $frajer && $chytrak > $smradoch && $chytrak > $slusnak) {
                    //pokud jo tak se tak najdeme vsechny chytraky a vybereme 1 random z nich
                    $repository = $doctrine->getRepository(Zkouska::class)->findBy(['chytrak' => true]);
                    $random = $repository[array_rand($repository)];
                    if ($random) {
                        $randomId = $random->getId();
                        //cesta kde se zobrazi
                        return $this->redirectToRoute('explore', ['id' => $randomId]);
                    } else {
                        return $this->redirectToRoute('/explore');
                    }
     //zjistime jestli ma User nejoblibenejsi $slusnak
                } elseif ($slusnak > $frajer && $slusnak > $smradoch && $slusnak > $chytrak) {
                    //pokud jo tak se tak najdeme vsechny slusnaky a vybereme 1 random z nich
                    $repository = $doctrine->getRepository(Zkouska::class)->findBy(['slusnak' => true]);
                    $random = $repository[array_rand($repository)];
                    if ($random) {
                        $randomId = $random->getId();
                        //cesta kde se zobrazi
                        return $this->redirectToRoute('explore', ['id' => $randomId]);
                    } else {
                        return $this->redirectToRoute('ex');
                    }
     //jestli je neco nerozhodne tak se vybere nahodny YETI
                } else {
                    return $this->redirectToRoute('ex');
                }
            }


    }
}
