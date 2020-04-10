<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Tricks;
use App\Form\ImagesType;
use Doctrine\Common\Persistence\ObjectManager;
use function dump;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function unlink;

class ImageController extends AbstractController
{
    /**
     * @Route("/delete-default/{id}", name="delete-default-image")
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

       /* return $this->render('image/index-image.html.twig', [
            'controller_name' => 'ImageController',
        ]);*/
    }

    /**
     * @Route("/modify-an-image/{idTrick}/{idImage}", name="modify-an-image")
     */
    public function modifyAnImage($idTrick, $idImage, Request $request, ObjectManager $manager)
    {
        //$trick = $manager->find(Tricks::class, $idTrick);
        $image = $manager->find(Image::class, $idImage);
        //dump($trick);
        dump($image->getUrl());

       // $form = $this->createForm(ImagesType::class, $image);
       // $form->handleRequest($request);

        //return $this->redirectToRoute('trick_edit', ['id' => $trick->getId()]);
    }

    /**
     * @Route("/delete-an-image/{id}", name="delete-an-image")
     */
    public function deleteAnImage(Tricks $trick = null, Request $request, ObjectManager $manager)
    {

        dump($trick->getImages());

        /*if($trick->getDefaultImage() != 'home_img.jpg')
        {
            unlink($this->getParameter('images_directory') . '/' . $trick->getDefaultImage());
            $trick->setDefaultImage('home_img.jpg');
            // Mettre les modif de l'image par défaut dans la Base de données
            $manager->persist($trick);
            $manager->flush();
        }*/

        return $this->redirectToRoute('trick_edit', ['id' => $trick->getId()]);

       /* return $this->render('image/index-image.html.twig', [
            'controller_name' => 'ImageController',
        ]);*/
    }


}
