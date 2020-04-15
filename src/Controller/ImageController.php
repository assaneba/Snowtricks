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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ImageController extends AbstractController
{
    /**
     * @Route("/image/{id}/delete-default", name="delete-default-image")
     * @isGranted("ROLE_USER", message="Vous devez vous connectés pour modifier cette section")
     */
    public function deleteDefaultImage(Tricks $trick = null, Request $request, ObjectManager $manager)
    {
        if($trick->getDefaultImage() != 'home_img.jpg') {
            unlink($this->getParameter('images_directory') . '/' . $trick->getDefaultImage());
            $trick->setDefaultImage('home_img.jpg');
            $manager->persist($trick);
            $manager->flush();
        }

        return $this->redirectToRoute('trick_edit', ['id' => $trick->getId()]);
    }

    /**
     * @Route("/modify-an-image/{idTrick}/{idImage}", name="modify-an-image")
     * @isGranted("ROLE_USER", message="Vous devez vous connectés pour modifier cette section")
     */
    public function modifyAnImage($idTrick, $idImage, Request $request, ObjectManager $manager)
    {

    }

    /**
     * @Route("/delete-an-image/{id}", name="delete-an-image")
     * @isGranted("ROLE_USER", message="Vous devez vous connectés pour modifier cette section")
     */
    public function deleteAnImage(Tricks $trick = null, Request $request, ObjectManager $manager)
    {

    }

}
