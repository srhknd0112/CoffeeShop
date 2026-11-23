<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProduitController extends AbstractController
{
    public const PRODUITS = [
        ['nom' => 'Espresso Intense', 'prix' => 12.5, 'note' => 4.5, 'famille' => 'Arabica', 'pays' => 'Colombie', 'meilleure_vente' => true, 'marque' => 'Lavazza', 'categorie' => 'Grains', 'image' => 'cafe1.jpg'],
        ['nom' => 'Moka Doux', 'prix' => 14.0, 'note' => 4.8, 'famille' => 'Arabica', 'pays' => 'Ethiopie', 'meilleure_vente' => true, 'marque' => 'Illy', 'categorie' => 'Moulu', 'image' => 'cafe2.jpg'],
        ['nom' => 'Mélange Maison', 'prix' => 10.9, 'note' => 4.2, 'famille' => 'Robusta', 'pays' => 'Brésil', 'meilleure_vente' => true, 'marque' => 'Malongo', 'categorie' => 'Capsules', 'image' => 'cafe3.jpg'],
        ];

    #[Route('/produit', name: 'app_produit', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => self::PRODUITS,
        ]);
    }
}