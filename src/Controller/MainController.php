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
    //funkce na top 10 YETI podle hodnoceni
    #[Route('/', name:"main")]
    public function main(PersistenceManagerRegistry $doctrine): Response
    {   //ziskame z db top10 podle hodnoceni
        $best = $doctrine->getRepository(Zkouska::class)->findBy([], ['hodnoceni' => 'desc'], 10);
        //zobrazime v twig
        return $this->render('main/best.html.twig',[
            'list_best' => $best,
        ]);
    }

    //funkce na zobrazeni vsech YETI
    #[Route('/all', name: 'all')]
    public function all(PersistenceManagerRegistry $doctrine): Response
    {
        //ziskame vsechny YETI z db
        $data = $doctrine->getRepository(Zkouska::class)->findAll();
        //zobrazime je v twig
        return $this->render('main/all.html.twig', [
            'list' => $data
        ]);
    }


    //funkce na vytvoreni noveho YETIHO
    #[Route("/create", name:"create")]
    public function create(Request $request, PersistenceManagerRegistry $doctrine, SluggerInterface $slugger ) :Response
    {
        //vytvori se nahled kde pujde vlozit udaje o novem YETIM a rekneme ze budeme pridavat noveho
        $zkouska = new Zkouska();
        //pomoci Form se v twigu vytvori inputy a labely
        $form = $this->createForm(ZkouskaType::class, $zkouska);
        $form->handleRequest($request);
        //potom co se stiskne tlacitko v twig a jsou v inputech zaroven nejake a vhodne hodnoty tak se to zapise do DB
        if($form->isSubmitted() && $form->isValid()){
            //ziskame info o img
            $img = $form->get('img')->getData();
            if ($img){
                //vytvorime originalni nazev pro obrazek aby se neopakovali nazvy v ulozisti aby z toho nebyly problemy
                $origoImg = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                $safeImg = $slugger->slug($origoImg);
                $newImg = $safeImg.'-'.uniqid().'.'.$img->guessExtension();
                //ulozime obrazek na urcene misto
                try {
                    $img->move(
                        $this->getParameter('images_directory'),
                        $newImg
                    );

             } catch(FileException $e){
             
            }
            //zapiseme vse do DB
            $zkouska->setImg($newImg);
            }
            $em = $doctrine->getManager();
            $em->persist($zkouska);
            $em->flush();
            //budeme presmerovani zpet do MAIN a zobrazi se hlaseni
            $this->addFlash('notice','Úspěšně vytvořen!!');

            return $this->redirectToRoute('main');
        }
        //zobrazi se nahled pro vytvoreni
        return $this->render('main/create.html.twig',[
            'form' => $form->createView()
        ]);
    }
    //funkce na upraveni existujiciho YETIHO
    #[Route("/update/{id}", name:"update")]
    public function update(Request $request, $id,PersistenceManagerRegistry $doctrine, SluggerInterface $slugger) :Response
    {
        //ziskame YETIHO podle jeho Id z DB
        $zkouska = $doctrine->getRepository(Zkouska::class)->find($id);
        //vytvorime nahled podle existujiciho YETIHO pomoci form -> uvnitr uz budou inputy vyplneny se starymi daty
        $form = $this->createForm(ZkouskaType::class, $zkouska);
        $form->handleRequest($request);
        //potom co se stiskne tlacitko v twig a jsou v inputech zaroven nejake a vhodne hodnoty tak se to zapise do DB
        if($form->isSubmitted() && $form->isValid()){
            //ziskame info o img
            $img = $form->get('img')->getData();
            if ($img){
                //vytvorime originalni nazev pro obrazek aby se neopakovali nazvy v ulozisti aby z toho nebyly problemy
                $origoImg = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                $safeImg = $slugger->slug($origoImg);
                $newImg = $safeImg.'-'.uniqid().'.'.$img->guessExtension();
                //ulozime obrazek na urcene misto
                try {
                    $img->move(
                        $this->getParameter('images_directory'),
                        $newImg
                    );

             } catch(FileException $e){
             
            }
            //zapiseme vse do DB
            $zkouska->setImg($newImg);
            }

            $em = $doctrine->getManager();
            $em->persist($zkouska);
            $em->flush();
            //budeme presmerovani zpet do MAIN a zobrazi se hlaseni
            $this->addFlash('notice','Úspěšně změněn!!');

            return $this->redirectToRoute('main');
        }
        //zobrazi se nahled pro update
        return $this->render('main/update.html.twig',[
            'form' => $form->createView()
        ]);
    }
    //funkce na odstraneni YETIHO
    #[Route("/delete/{id}", name:"delete")]
    public function delete($id,PersistenceManagerRegistry $doctrine){
        //ziskame YETIHO podle Id a odstranime ho
        $data = $doctrine->getRepository(Zkouska::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($data);
        $em->flush();
        //budeme presmerovani zpet do MAIN a zobrazi se hlaseni
        $this->addFlash('notice','Úspěšně smazán!!');

        return $this->redirectToRoute('main');

    }

    //funkce na zobrazeni podrobnejsich informaci o YETIM
    #[Route("/info/{id}", name:"info")]
    public function info($id, PersistenceManagerRegistry $doctrine): Response
    {
        //ziskame YETIHO z db podle Id a zobrazime ho v twig
        $data = $doctrine->getRepository(Zkouska::class)->find($id);
        return $this->render('main/info.html.twig', [
            'list' => $data
        ]);
    }

}
