<?php

namespace App\Controller;

use App\Entity\GroupOfTricks;
use App\Entity\Image;
use App\Entity\Tricks;
use App\Form\GroupType;
use App\Form\TrickType;
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

            return $this->redirectToRoute('group_modify', ['id' => $group->getIdgroup()]);
        }

        return $this->render('trick/manage_groups.html.twig', [
            'formGroup' => $form->createView(),
            'editMode' =>  $group->getIdgroup() !== null
        ]);
    }

    /**
     * @Route("/trick/ajout", name="trick_add")
     */
    public function addTrick(ObjectManager $manager, Request $request)
    {
        $trick = new Tricks();

       /* $images = new Image();
        $images->setUrl('http://placehold.it/300x200');
        $images2 = new Image();
        $images2->setUrl('http://placehold.it/300x200');

        $trick->getImages()->add($images);
        $trick->getImages()->add($images2);*/

        //$trick->addImage($images);

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        dump();

        if($form->isSubmitted() AND $form->isValid())
        {
            $trick->setCreatedAt(new \DateTime());
            $trick->setLastModifyAt(new \DateTime());
            $manager->persist($trick);
            $manager->flush();

            return $this->redirectToRoute('trick', ['id' => $trick->getIdtricks()]);
        }


        return $this->render('trick/add.html.twig', [
            'formTrick' => $form->createView()
        ]);
    }

}
