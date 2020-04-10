<?php

namespace App\Controller;

use App\Entity\Tricks;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function unlink;

class ImageController extends AbstractController
{
    /**
     * @Route("/imageDelete/{id}", name="delete-default-image")
     */
    public function deleteDefaultImage(Tricks $trick = null, Request $request, ObjectManager $manager)
    {

        //dump($trick);

        if($trick->getDefaultImage() != 'home_img.jpg')
        {
            unlink($this->getParameter('images_directory') . '/' . $trick->getDefaultImage());
            $trick->setDefaultImage('home_img.jpg');
            // Mettre les modif de l'image par défaut dans la Base de données
            $manager->persist($trick);
            $manager->flush();
        }

        return $this->redirectToRoute('trick_edit', ['id' => $trick->getId()]);

       /* return $this->render('image/delete-default-image.html.twig', [
            'controller_name' => 'ImageController',
        ]);*/
    }
}
