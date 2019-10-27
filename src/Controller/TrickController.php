<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Form\TrickType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/trick/ajout", name="trick_add")
     */
    public function addTrick(ObjectManager $manager)
    {
        $trick = new Tricks();

        $form = $this->createForm(TrickType::class, $trick);

        return $this->render('trick/add.html.twig', [
            'formTrick' => $form->createView()
        ]);
    }
}
