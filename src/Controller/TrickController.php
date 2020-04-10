<?php

namespace App\Controller;

use App\Entity\GroupOfTricks;
use App\Entity\Image;
use App\Entity\Tricks;
use App\Form\GroupType;
use App\Form\ImagesType;
use App\Form\TrickEditType;
use App\Form\TrickType;
use App\Service\UploadFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use function dump;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use function unlink;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick", name="trick")
     */
    public function index()
    {
        return $this->render('trick/index-image.html.twig', [
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
     * @Route("/trick/{name}", name="trick_show")
     */
    public function showTrick(Tricks $tricks = null)
    {
        if(!$tricks) {
            return $this->redirectToRoute('error_page');
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $tricks
        ]);
    }

    /**
     * @Route("/trick/ajout", name="trick_add")
     */
    public function addTrick(ObjectManager $manager, Request $request, UploadFile $uploadFile)
    {
        $trick = new Tricks();

        $videoCollect = new ArrayCollection();

        foreach ($trick->getVideos() as $video) {
            //$video->setEmbed('test1');
            $videoCollect->add($video);
        }

        $imagesCollect = new ArrayCollection();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        $files = $request->files->get('trick', 'images');


        if($form->isSubmitted() AND $form->isValid())
        {
            $defaultImage = $uploadFile->upload($form['defaultImage']->getData());
            $trick->setDefaultImage($defaultImage);

            foreach ($trick->getImages() as $index => $illustration) {
                $index = $index + 1;
                $anImage = $files['images'][$index]['url'];
                $newNameFile = $uploadFile->upload($anImage);
                $illustration->setUrl($newNameFile);
                $imagesCollect->add($illustration);
            }

            $trick->setCreatedAt(new \DateTime());
            $trick->setLastModifyAt(new \DateTime());

            $manager->persist($trick);
            $manager->flush();

            return $this->redirectToRoute('trick_show', ['name' => $trick->getName()]);
        }

        return $this->render('trick/add.html.twig', [
            'formTrick' => $form->createView(),
            //'id' => null
        ]);
    }

    /**
     * @Route("/trick/edit/{id}", name="trick_edit")
     */
    public function editTrick(Tricks $tricks = null, Request $request, ObjectManager $manager, UploadFile $uploadFile)
    {
        if(!$tricks) {
            return $this->redirectToRoute('error_page');
        }

       $videoCollect = new ArrayCollection();
        foreach ($tricks->getVideos() as $video) {
            //$video->setEmbed('test1');
            $videoCollect->add($video);
        }

        $imagesCollect = new ArrayCollection();
        foreach ($tricks->getImages() as $image) {
            $imagesCollect->add($image);
        }

     /*  $tricks->setDefaultImage(
            new File($this->getParameter('images_directory').'/'.$tricks->getDefaultImage())
        );*/

        $form = $this->createForm(TrickEditType::class, $tricks);
        $form->handleRequest($request);

       // $formImage = $this->createForm(ImagesType::class, $image);
       // $formImage->handleRequest($request);

        // dump($tricks->getImages());

        //$files = $request->files->get('trick', 'images');

        if($form->isSubmitted() AND $form->isValid())
        {
            // Vérifier si une image par défaut a été soumise et supprimer l'ancienne
            if($form['defaultImage']->getData())
            {
                $newDefaultImage = $uploadFile->upload($form['defaultImage']->getData());
                $previousImage = $tricks->getDefaultImage();

                if($previousImage != 'home_img.jpg')
                {
                    unlink($this->getParameter('images_directory').'/'.$previousImage);
                }
                $tricks->setDefaultImage($newDefaultImage);

            }

            //dump($form['defaultImage']->getData());

            $manager->persist($tricks);
            $manager->flush();
            //dump($form);
        }

        //$files = $request->files->get('trick', 'images');

        return $this->render('trick/edit.html.twig', [
            'trick' => $tricks,
            'form' => $form->createView(),
        ]);
    }

}
