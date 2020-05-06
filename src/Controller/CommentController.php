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
     * @param CommentRepository $commentRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/manage-comments", name="manage-comments")
     * @isGranted("ROLE_ADMIN", message="Vous devez être admin pour accèder à cette section")
     */
    public function manageComments(CommentRepository $commentRepository)
    {
        $comments = $commentRepository->getUnpublishedComments();

        return $this->render('comment/manage-comments.html.twig', [
            'comments' => $comments,
        ]);
    }

    /**
     * @param Comment $comment
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("comment/{id}/delete", name="delete-com")
     * @isGranted("ROLE_ADMIN", message="Vous devez être admin pour accèder à cette section")
     */
    public function deleteComment(Comment $comment, ObjectManager $manager)
    {
        if ($comment) {
            $manager->remove($comment);
            $manager->flush();
        }

        return $this->redirectToRoute('manage-comments');
    }

    /**
     * @param Comment $comment
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("comment/{id}/validate", name="validate-comments")
     * @isGranted("ROLE_ADMIN", message="Vous devez être admin pour accèder à cette section")
     */
    public function validateComment(Comment $comment, ObjectManager $manager)
    {
        if ($comment) {
            $comment->setPublished(true);
            $manager->flush();
        }

        return $this->redirectToRoute('manage-comments');
    }
}
