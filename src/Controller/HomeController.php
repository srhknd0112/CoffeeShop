<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/accueil', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        $tendances = [];

        foreach (ProduitController::PRODUITS as $produit) {
            if ($produit['meilleure_vente']) {
                $tendances[] = $produit;
            }
        }

        return $this->render('home/index.html.twig', [
            'produits' => $tendances,
        ]);
    }
}