<?php

namespace App\Controller;

use App\Entity\GroupOfTricks;
use App\Entity\Tricks;
use App\Repository\TricksRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @param TricksRepository $tricksRepository
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Route("/", name="home")
     */
    public function index(TricksRepository $tricksRepository, Request $request)
    {
        $totalTricks = $tricksRepository->totalTricks();
        $page = $request->query->get('page');

        if ($page < 1 || $page > $totalTricks) {
            $page = 1;
        }

        $paginatedTricks = $tricksRepository->paginate($page, $limit = 9);
        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($paginatedTricks) / $limit),
            'routeName' => 'home',
            'slug' => null,
        );

        return $this->render('home/index.html.twig', [
            'tricks' => $paginatedTricks,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @return Response
     * @Route("/not-found", name="error_page")
     */
    public function errorPage()
    {
        return $this->render('error404.html.twig', [
            'controller_name' => 'annuaire Snowtricks',
        ]);
    }
}
