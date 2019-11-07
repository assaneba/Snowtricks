<?php

namespace App\Controller;

use App\Entity\GroupOfTricks;
use App\Entity\Image;
use App\Entity\Tricks;
use App\Form\GroupType;
use App\Form\ImageType;
use App\Form\TrickType;
use App\Service\UploadFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    public function addTrick(ObjectManager $manager, Request $request, UploadFile $fileX)
    {
        $trick = new Tricks();

        $videoCollect = new ArrayCollection();

        foreach ($trick->getVideos() as $video) {
            $videoCollect->add($video);
        }

        $imagesCollect = new ArrayCollection();

      /*  foreach($trick->getImages() as $anImage) {
            //$file2 = $files['images'][$index]['file'];
            $newNameFile = $file->upload($anImage);
            //$imagesCollect->add($newNameFile);
            //dump($illustration);
            //$manager->persist($illustration);
        }*/

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        //$files = $request->files->get('trick', $trick->getImages());
        //$files = new UploadFile('\'%kernel.project_dir%/public/uploads/images\'');
        //$files = $form[$trick->getImages()]->getData();

        $files = $request->files->get('trick', 'images');

        if($form->isSubmitted() AND $form->isValid())
        {
            foreach ($trick->getImages() as $index => $illustration) {
                $index = 1;
                $anImage = $files['images'][$index]['url'];
                dump($anImage);
                $newNameFile = $fileX->upload($anImage);
                $illustration->setUrl($newNameFile);
                //$manager->persist($illustration);
            }
                /*$forUpload = $form[$trick->getImages()]->getData();
                $uploadedImageName = $file->upload($forUpload);
                $image->setUrl($uploadedImageName);*/
                //$imagesCollect->add($uploadedImageName);

            $trick->setCreatedAt(new \DateTime());
            $trick->setLastModifyAt(new \DateTime());

            dump($trick->getImages());

            //$manager->persist($trick);
            //$manager->flush();

            //return $this->redirectToRoute('trick', ['id' => $trick->getIdtricks()]);
        }

        return $this->render('trick/add.html.twig', [
            'formTrick' => $form->createView(),
            //'id' => null
        ]);
    }

}
