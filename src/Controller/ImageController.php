<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Tricks;
use App\Form\ImagesType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class ImageController
 * @package App\Controller
 */
class ImageController extends AbstractController
{
    /**
     * @param Tricks|null $trick
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/image/{id}/delete-default", name="delete-default-image")
     * @isGranted("ROLE_USER", message="Vous devez vous connectés pour modifier cette section")
     */
    public function deleteDefaultImage(Tricks $trick = null, Request $request, ObjectManager $manager)
    {
        if($trick->getDefaultImage() !== 'home_img.jpg') {
            unlink($this->getParameter('images_directory') . '/' . $trick->getDefaultImage());
            $trick->setDefaultImage('home_img.jpg');
            $manager->persist($trick);
            $manager->flush();
        }

        return $this->redirectToRoute('trick_edit', ['id' => $trick->getId()]);
    }

    /**
     * @param Image $image
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/image/{id}/modify", name="modify-image")
     * @isGranted("ROLE_USER", message="Vous devez vous connectés pour modifier cette section")
     */
    public function modifyImage(Image $image, ObjectManager $manager)
    {
        $filename = $_FILES['file']['name'];

        $location = $this->getParameter('images_directory').'/'.$filename;

        unlink($this->getParameter('images_directory') . '/' . $image->getUrl());
        $image->setUrl($filename);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
            $manager->flush();
            $this->addFlash('success', 'Image modifiée avec succès !');

            return $this->redirectToRoute('trick_edit', ['id' => $image->getTrick()->getId()]);
        }

    }

    /**
     * @param Image $image
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/image/{id}/delete", name="delete-an-image")
     * @isGranted("ROLE_USER", message="Vous devez vous connectés pour modifier cette section")
     */
    public function deleteAnImage(Image $image, ObjectManager $manager)
    {
        $idTrick = $image->getTrick()->getId();

        unlink($this->getParameter('images_directory').'/'.$image->getUrl());

        $manager->remove($image);
        $manager->flush();

        return $this->redirectToRoute('trick_edit', ['id' => $idTrick]);
    }

}
