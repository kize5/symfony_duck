<?php

namespace App\Controller;

use App\Repository\DuckRepository;
use App\Repository\QuackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
//    /**
//     * @Route ("/")
//     */
    public function index(DuckRepository $duckRepository, QuackRepository $quackRepository): Response
    {
        $ducks = $duckRepository->findAll();
        $quacks = $quackRepository->findAll();
        return $this->render('home/home.html.twig', [
            'ducks' => $ducks,
            'quacks' => $quacks,
        ]);
    }
}
