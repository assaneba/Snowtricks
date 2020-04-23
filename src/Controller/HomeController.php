<?php

namespace App\Controller;

use App\Entity\Tricks;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ObjectManager $manager)
    {
        $tricks = $manager->getRepository(Tricks::class)->findAll();

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    /**
     * @Route("/not-found", name="error_page")
     */
    public function errorPage()
    {
        return $this->render('error404.html.twig', [
            'controller_name' => 'annuaire Snowtricks',
        ]);
    }

}
