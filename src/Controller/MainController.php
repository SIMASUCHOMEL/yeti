<?php

namespace App\Controller;

use App\Entity\Zkouska;
use App\Form\ZkouskaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(PersistenceManagerRegistry $doctrine): Response
    {
        $data = $doctrine->getRepository(Zkouska::class)->findAll();
        #ziska posledni z db ===> random(1, tady)
        $GetLastNumber = $doctrine->getRepository(Zkouska::class)->findOneBy([], ['id' => 'desc']);
        return $this->render('main/index.html.twig', [
            'list' => $data,
            'last' => $GetLastNumber
        ]);
    }



    #[Route("/create", name:"create")]
    public function create(Request $request, PersistenceManagerRegistry $doctrine) {
        $zkouska = new Zkouska();
        $form = $this->createForm(ZkouskaType::class, $zkouska);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($zkouska);
            $em->flush();

            $this->addFlash('notice','Successsufull!!');

            return $this->redirectToRoute('main');
        }
        return $this->render('main/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route("/update/{id}", name:"update")]
    public function update(Request $request, $id,PersistenceManagerRegistry $doctrine){
        
        $zkouska = $doctrine->getRepository(Zkouska::class)->find($id);
        $form = $this->createForm(ZkouskaType::class, $zkouska);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($zkouska);
            $em->flush();

            $this->addFlash('notice','Successsufull!!');

            return $this->redirectToRoute('main');
        }
        return $this->render('main/update.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route("/delete/{id}", name:"delete")]
    public function delete($id,PersistenceManagerRegistry $doctrine){
        $data = $doctrine->getRepository(Zkouska::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($data);
        $em->flush();

        $this->addFlash('notice','Successsufull!!');

        return $this->redirectToRoute('main');

    }


    #[Route("/info/{id}", name:"info")]
    public function info($id, PersistenceManagerRegistry $doctrine): Response
    {
        $data = $doctrine->getRepository(Zkouska::class)->find($id);
        return $this->render('main/info.html.twig', [
            'list' => $data
        ]);
    }

}
