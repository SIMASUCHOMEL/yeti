<?php

namespace App\Controller;

use App\Entity\Zkouska;
use App\Form\ZkouskaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;


class ExploreController extends AbstractController
{
    #[Route('/explore/{id}', name: 'explore')]
    public function index($id,PersistenceManagerRegistry $doctrine): Response
    {
        $data = $doctrine->getRepository(Zkouska::class)->find($id);
        return $this->render('explore/index.html.twig', [
            'list' => $data
        ]);
    }
  /*  #[Route('explore/{id}', name:'like')]
    public function next($id, PersistenceManagerRegistry $doctrine)
    {




    }
*/
}