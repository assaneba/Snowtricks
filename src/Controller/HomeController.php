<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Repository\TricksRepository;
use Doctrine\Common\Persistence\ObjectManager;
use function dump;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/{page<\d+>?1}", name="home")
     */
    public function index(TricksRepository $tricksRepository, $page, ObjectManager $manager)
    {
        $tricks = $manager->getRepository(Tricks::class);
        //  Query how many rows are there in the Trick table
        $totalTricks = $tricks->createQueryBuilder('t')
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();

        if ($page < 1 || $page > $totalTricks) {
            $page = 1;
        }
        $limit = 3;
        $paginatedTricks = $tricksRepository->paginate($page, $limit);

        $pagination = array(
            'page' => $page,
            'nbPages' => ceil(count($paginatedTricks) / $limit),
            'routeName' => 'home',
            'paramsRoute' => array()
        );

        return $this->render('home/index.html.twig', [
            'tricks' => $paginatedTricks,
            'pagination' => $pagination,
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
