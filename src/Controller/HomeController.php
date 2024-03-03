<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use App\Repository\RecetteRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(UtilisateurRepository $utilisateurRepository, CategorieRepository $categorieRepository, RecetteRepository $recetteRepository): Response
    {
        
        $categories = $categorieRepository->findAll();
        $utilisateur = $utilisateurRepository->findAll();
        $recette = $recetteRepository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'utilisateur' => $utilisateur,
            'categories' => $categories,
            'recettes' => $recette,   
        ]);
    }

    #[Route('/recetteByCategorie/{id}', name: 'app_recetteByCategorie', methods: ['GET'])]
    public function recetteByCategorie($id, RecetteRepository $recetteRepository, CategorieRepository $categorieRepository): Response
    {


        $categories = $categorieRepository->findAll();

        $recetteByCategorie = $recetteRepository->findBy(['categorie' => $id]);

        return $this->render('home/index.html.twig', [
            'recettes' => $recetteByCategorie,
            'categories' => $categories
        ]);
    }

    #[Route('/recetteById/{id}', name: 'app_recetteById', methods: ['GET', 'POST'])]
    public function recetteById($id, RecetteRepository $recetteRepository, CategorieRepository $categorieRepository, CommentaireRepository $commentaireRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $recette = $recetteRepository->find($id);
        $categories = $categorieRepository->findAll();
        $commentaires = $commentaireRepository->findBy(['recette' => $id]);
        $commentaire = new Commentaire();
        $commentaire->setRecette($recette); 
        $commentaire->setUtilisateur($this->getUser()); 
        $commentaire->setDate(new \DateTime());
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commentaire);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_recetteById', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recette/recette.html.twig', [
            'recette' => $recette,
            'commentaires' => $commentaires,
            'commentaire' => $commentaire,
            'form' => $form,
            'categories' => $categories
        ]);
    }
}
