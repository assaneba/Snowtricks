<?php

namespace App\Controller;

use App\Entity\GroupOfTricks;
use App\Entity\Image;
use App\Entity\Tricks;
use App\Form\GroupType;
use App\Form\ImagesType;
use App\Form\TrickType;
use App\Service\UploadFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use function dump;
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
    public function addTrick(ObjectManager $manager, Request $request, UploadFile $uploadFile)
    {
        $trick = new Tricks();

        $videoCollect = new ArrayCollection();

        foreach ($trick->getVideos() as $video) {
            $video->setEmbed('test1');
            $videoCollect->add($video);
        }

        $imagesCollect = new ArrayCollection();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        $files = $request->files->get('trick', 'images');

        if($form->isSubmitted() AND $form->isValid())
        {
            dump($trick->getVideos());
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

            //$manager->persist($trick);
            //$manager->flush();

            //return $this->redirectToRoute('trick_show', ['name' => $trick->getName()]);
        }

        return $this->render('trick/add.html.twig', [
            'formTrick' => $form->createView(),
            //'id' => null
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
            'trick' => $tricks,
        ]);
    }

    /**
     * @Route("/trick/edit/{name}", name="trick_edit")
     */
    public function editTrick(Tricks $tricks)
    {
        if(!$tricks) {
            return $this->redirectToRoute('error_page');
        }


        return $this->render('trick/edit.html.twig', [
            'trick' => $tricks,
        ]);
    }

}
