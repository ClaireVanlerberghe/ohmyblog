<?php

namespace App\Controller;

use App\Repository\CategorieRepository;

use App\Repository\RecetteRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(UtilisateurRepository $utilisateurRepository, CategorieRepository $categorieRepository, RecetteRepository $recetteRepository): Response
    {
        $utilisateur = $utilisateurRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'utilisateur' => $utilisateur,
            'categories' => $categorieRepository->findAll(),
            'recettes' => $recetteRepository->findAll(),
            
            
            
        ]);

        
    }
}
