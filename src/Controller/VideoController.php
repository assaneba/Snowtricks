<?php

namespace App\Controller;

use App\Entity\Video;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class VideoController extends AbstractController
{
    /**
     * @param Video $video
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/video/{id}/delete", name="delete-video")
     * @isGranted("ROLE_USER", message="Vous devez vous connectés pour modifier cette section")
     */
    public function deleteVideo(Video $video, ObjectManager $manager)
    {
        $idTrick = $video->getTrick()->getId();

        $manager->remove($video);
        $manager->flush();

        return $this->redirectToRoute('trick_edit', ['id' => $idTrick]);
    }


    /**
     * @param Video $video
     * @param ObjectManager $manager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     * @Route("/video/{id}/modify", name="modify-video")
     * @isGranted("ROLE_USER", message="Vous devez vous connectés pour modifier cette section")
     */
    public function modifyVideo(Video $video, ObjectManager $manager, Request $request)
    {
        $newVideoEmbed = $request->get('newVideo');
        if (!empty($newVideoEmbed)) {
            $video->setEmbed($newVideoEmbed);
            $manager->flush();
        }
        else {
            throw new \Exception('Impossible de modifier la video !');
        }

        return $this->redirectToRoute('trick_edit', ['id' => $video->getTrick()->getId()]);
    }
}
