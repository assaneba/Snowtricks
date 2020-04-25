<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\GroupOfTricks;
use App\Entity\Image;
use App\Entity\Tricks;
use App\Form\CommentType;
use App\Form\GroupType;
use App\Form\ImagesType;
use App\Form\TrickEditType;
use App\Form\TrickType;
use App\Repository\CommentRepository;
use App\Service\UploadFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @Route("/trick/group-add", name="group_add")
     * @Route("/trick/{id}/group-edit", name="group_modify")
     * @isGranted("ROLE_ADMIN", message="Vous devez être admin pour modifier cette section ! ")
     */
    public function addGroup(Request $request, ObjectManager $manager, GroupOfTricks $group = null)
    {
        if (!$group) {
            $group = new GroupOfTricks();
        }
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {
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
     * @Route("/trick/{slug}/view", name="trick_show")
     */
    public function showTrick($slug, ObjectManager $manager, Request $request, CommentRepository $commentRepository)
    {
        $trick = $manager->getRepository(Tricks::class)->findOneBySlug($slug);

        if (!$trick) {
            return $this->redirectToRoute('error_page');
        }

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        //Pagination of comments
        $totalComments = $commentRepository->totalComments();
        $page = $request->query->get('page');

        if ($page < 1 || $page > $totalComments) {
            $page = 1;
        }
        $paginatedComments = $commentRepository->paginate($page, $limit = 2);
        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($paginatedComments) / $limit),
            'routeName' => 'trick_show',
            'slug' => $slug
        );

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setCreatedAt(new \DateTime());
            $comment->setPublished(true);
            $comment->setTrick($trick);
            $comment->setUser($this->getUser());

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'commentForm' => $commentForm->createView(),
            'comments'  => $paginatedComments,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/trick/add", name="trick_add")
     * @isGranted("ROLE_USER", message="Vous devez vous connecter pour ajouter un Trick !")
     */
    public function addTrick(ObjectManager $manager, Request $request, UploadFile $uploadFile)
    {
        $trick = new Tricks();
        $imagesCollect = new ArrayCollection();
        $videoCollect = new ArrayCollection();
        $groupCollect = new ArrayCollection();

        foreach ($trick->getVideos() as $video) {
            $videoCollect->add($video);
        }
        foreach ($trick->getGroupOfTricks() as $group) {
            $groupCollect->add($group);
        }

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        $files = $request->files->get('trick', 'images');

        if ($form->isSubmitted() AND $form->isValid()) {
            $defaultImage = $uploadFile->upload($form['defaultImage']->getData());
            $trick->setDefaultImage($defaultImage);
            // Create the slug
            $slug = str_replace(' ', '-', strtolower($trick->getName()));
            $trick->setSlug($slug);

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

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        return $this->render('trick/add.html.twig', [
            'formTrick' => $form->createView(),
        ]);
    }

    /**
     * @Route("/trick/{id}/edit", name="trick_edit")
     * @isGranted("ROLE_USER", message="Vous devez être connecté pour modifier cette section ! ")
     */
    public function editTrick(Tricks $tricks = null, Request $request, ObjectManager $manager, UploadFile $uploadFile)
    {
        if(!$tricks) {
            return $this->redirectToRoute('error_page');
        }

        $imagesCollect = new ArrayCollection();
        $videoCollect = new ArrayCollection();

        foreach ($tricks->getVideos() as $video) {
            $videoCollect->add($video);
        }

        foreach ($tricks->getImages() as $image) {
            $imagesCollect->add($image);
        }

        $form = $this->createForm(TrickEditType::class, $tricks);
        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {
            // Vérifier si une image par défaut a été soumise et supprimer l'ancienne
            if ($form['defaultImage']->getData()) {
                $newDefaultImage = $uploadFile->upload($form['defaultImage']->getData());
                $previousImage = $tricks->getDefaultImage();

                if ($previousImage != 'home_img.jpg') {
                    unlink($this->getParameter('images_directory').'/'.$previousImage);
                }

                $tricks->setDefaultImage($newDefaultImage);
            }

            $manager->persist($tricks);
            $manager->flush();
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $tricks,
            'form' => $form->createView(),
        ]);
    }

}
