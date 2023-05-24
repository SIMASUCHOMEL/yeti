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
    #[Route('/kdo', name: 'kdo')]
    public function index(PersistenceManagerRegistry $doctrine): Response
    {
            $user = $this->getUser();
            $userId = $user->getId();
            $repo = $doctrine->getRepository(User::class)->find($userId);
            $frajer = $repo->getFrajer();
            $smradoch = $repo->getSmradoch();
            $chytrak = $repo->getChytrak();
            $slusnak = $repo->getSlusnak();

            if ($frajer > $smradoch && $frajer > $chytrak && $frajer > $slusnak){
                $repository = $doctrine->getRepository(Zkouska::class)->findBy(['frajer' => true]);
                    $random = $repository[array_rand($repository)];
                    if ($random) {
                        $randomId = $random->getId();
                    return $this->redirectToRoute('explore', ['id' => $randomId]);
                    }else{
                        return $this->redirectToRoute('/explore');
                    }

            }elseif ($smradoch > $frajer && $smradoch > $chytrak && $smradoch > $slusnak){
                $repository = $doctrine->getRepository(Zkouska::class)->findBy(['smradoch' => true]);
                    $random = $repository[array_rand($repository)];
                    if ($random) {
                        $randomId = $random->getId();
                    return $this->redirectToRoute('explore', ['id' => $randomId]);
                    }else{
                        return $this->redirectToRoute('/explore');
                    }

            }elseif ($chytrak > $frajer && $chytrak > $smradoch && $chytrak > $slusnak){
                $repository = $doctrine->getRepository(Zkouska::class)->findBy(['chytrak' => true]);
                    $random = $repository[array_rand($repository)];
                    if ($random) {
                        $randomId = $random->getId();
                    return $this->redirectToRoute('explore', ['id' => $randomId]);
                    }else{
                        return $this->redirectToRoute('/explore');
                    }

            }elseif ($slusnak > $frajer && $slusnak > $smradoch && $slusnak > $chytrak){
                $repository = $doctrine->getRepository(Zkouska::class)->findBy(['slusnak' => true]);
                    $random = $repository[array_rand($repository)];
                    if ($random) {
                        $randomId = $random->getId();
                    return $this->redirectToRoute('explore', ['id' => $randomId]);
                    }else{
                        return $this->redirectToRoute('ex');
                    }

            }else{
                return $this->redirectToRoute('ex');
            };



    }
}
