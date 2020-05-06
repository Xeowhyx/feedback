<?php

namespace App\Controller;

use App\Repository\BugRepository;
use App\Repository\EvolutionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {


    /**
     * @return Response
     * @Route("/", name="home")
     */
    public function index (EvolutionRepository $evolutionRepository, BugRepository $bugRepository): Response
    {
        $evolutions = $evolutionRepository->findLatestEvolution();
        $bugs = $bugRepository->findLatestBug();
        return $this->render('home/home.html.twig', [
            'evolutions' => $evolutions,
            'bugs' => $bugs
        ]);
    }

}