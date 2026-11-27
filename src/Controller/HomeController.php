<?php

namespace App\Controller;

use App\Repository\SliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/accueil', name: 'app_home', methods: ['GET'])]
    public function index(SliderRepository $sliderRepository): Response
    {
        $tendances = [];

        foreach (ProduitController::PRODUITS as $produit) {
            if ($produit['meilleure_vente']) {
                $tendances[] = $produit;
            }
        }

        $slider = $sliderRepository->findOneBy([]);

        return $this->render('home/index.html.twig', [
            'produits' => $tendances,
            'slider' => $slider,
        ]);
    }
}
