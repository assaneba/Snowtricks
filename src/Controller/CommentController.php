<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CommentController extends AbstractController
{
    /**
     * @Route("/manage-comments", name="manage-comments")
     * @isGranted("ROLE_ADMIN", message="Vous devez être admin pour accèder à cette section")
     */
    public function manComments(CommentRepository $commentRepository)
    {
        $comments = $commentRepository->unpublished();

        return $this->render('comment/manage-comments.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/{id}/delete-com", name="delete-com")
     * @isGranted("ROLE_ADMIN", message="Vous devez être admin pour accèder à cette section")
     */
    public function delComments(Comment $comment, ObjectManager $manager)
    {
        if ($comment) {
            $manager->remove($comment);
            $manager->flush();
        }

        return $this->redirectToRoute('manage-comments');
    }

    /**
     * @Route("/{id}/validate-comments", name="validate-comments")
     * @isGranted("ROLE_ADMIN", message="Vous devez être admin pour accèder à cette section")
     */
    public function valComments(Comment $comment, ObjectManager $manager)
    {
        if ($comment) {
            $comment->setPublished(true);
            $manager->flush();
        }

        return $this->redirectToRoute('manage-comments');
    }
}
