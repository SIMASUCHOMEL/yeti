<?php

namespace App\Controller;

use App\Entity\Zkouska;
use App\Form\ZkouskaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class MainController extends AbstractController

{
    #[Route('/', name:"main")]
    public function main(PersistenceManagerRegistry $doctrine): Response
    {
        $best = $doctrine->getRepository(Zkouska::class)->findBy([], ['hodnoceni' => 'desc'], 10);
        #ziska posledni z db ===> random(1, tady)
        $GetLastNumber = $doctrine->getRepository(Zkouska::class)->findOneBy([], ['id' => 'desc']);


        return $this->render('main/best.html.twig',[
            'list_best' => $best,
            'last' => $GetLastNumber

        ]);
    }


    #[Route('/all', name: 'all')]
    public function all(PersistenceManagerRegistry $doctrine): Response
    {
        $data = $doctrine->getRepository(Zkouska::class)->findAll();

        return $this->render('main/all.html.twig', [
            'list' => $data
        ]);
    }



    #[Route("/create", name:"create")]
    public function create(Request $request, PersistenceManagerRegistry $doctrine, SluggerInterface $slugger ) :Response
    {
        $zkouska = new Zkouska();
        $form = $this->createForm(ZkouskaType::class, $zkouska);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $img = $form->get('img')->getData();
            if ($img){            
                $origoImg = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                $safeImg = $slugger->slug($origoImg);
                $newImg = $safeImg.'-'.uniqid().'.'.$img->guessExtension();
                try {
                    $img->move(
                        $this->getParameter('images_directory'),
                        $newImg
                    );

             } catch(FileException $e){
             
            }
            $zkouska->setImg($newImg);
            }
            $em = $doctrine->getManager();
            $em->persist($zkouska);
            $em->flush();

            $this->addFlash('notice','Úspěšně vytvořen!!');

            return $this->redirectToRoute('main');
        }
        return $this->render('main/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route("/update/{id}", name:"update")]
    public function update(Request $request, $id,PersistenceManagerRegistry $doctrine, SluggerInterface $slugger) :Response
    {
        
        $zkouska = $doctrine->getRepository(Zkouska::class)->find($id);
        $form = $this->createForm(ZkouskaType::class, $zkouska);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $img = $form->get('img')->getData();
            if ($img){            
                $origoImg = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                $safeImg = $slugger->slug($origoImg);
                $newImg = $safeImg.'-'.uniqid().'.'.$img->guessExtension();
                try {
                    $img->move(
                        $this->getParameter('images_directory'),
                        $newImg
                    );

             } catch(FileException $e){
             
            }
            $zkouska->setImg($newImg);
            }

            $em = $doctrine->getManager();
            $em->persist($zkouska);
            $em->flush();

            $this->addFlash('notice','Úspěšně změněn!!');

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

        $this->addFlash('notice','Úspěšně smazán!!');

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
