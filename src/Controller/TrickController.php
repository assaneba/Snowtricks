<?php

namespace App\Controller;

use App\Entity\GroupOfTricks;
use App\Entity\Image;
use App\Entity\Tricks;
use App\Form\GroupType;
use App\Form\TrickType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick", name="trick")
     */
    public function index()
    {
        return $this->render('trick/index.html.twig', [
            'controller_name' => 'TrickController',
        ]);
    }

    /**
     * @Route("/trick/ajout-groupe", name="group_add")
     * @Route("/trick/edit-groupe/{id}", name="group_modify")
     */
    public function addGroup(Request $request, ObjectManager $manager, GroupOfTricks $group = null)
    {
        if (!$group)
        {
            $group = new GroupOfTricks();
        }
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            //dump();
            $manager->persist($group);
            $manager->flush();

            return $this->redirectToRoute('group_modify', ['id' => $group->getId()]);
        }

        return $this->render('trick/manage_groups.html.twig', [
            'formGroup' => $form->createView(),
            'editMode' =>  $group->getId() !== null
        ]);
    }

    /**
     * @Route("/trick/ajout", name="trick_add")
     */
    public function addTrick(ObjectManager $manager, Request $request)
    {
        $trick = new Tricks();

        $originalTags = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
//        foreach ($trick->getImages() as $tag) {
//            $originalTags->add($tag);
//        }

        $form = $this->createForm(TrickType::class, $trick);


        /* $images = new Image();
         $images->setUrl('http://placehold.it/300x200');
         $images2 = new Image();
         $images2->setUrl('http://placehold.it/300x200');

         $trick->getImages()->add($images);
         $trick->getImages()->add($images2);*/

        //$trick->addImage($images);

        //$form->handleRequest($request);

        //dump($form->handleRequest($request));

        //if($form->isSubmitted() AND $form->isValid())
       // {
      /*  $group = new GroupOfTricks();
            $trick->setName('Nouveau Trick');
            $trick->setDescription('Content');
            $trick->setDefaultImage('http://placehold.it/300x200');
            $trick->setCreatedAt(new \DateTime());
            $trick->setLastModifyAt(new \DateTime());
            $trick->setGroupOfTricks($group);*/
            //dump($trick);
            //$manager->persist($trick);
            $manager->flush();

            //return $this->redirectToRoute('trick', ['id' => $trick->getIdtricks()]);
        //}


        return $this->render('trick/add.html.twig', [
            'formTrick' => $form->createView()
        ]);
    }

}
