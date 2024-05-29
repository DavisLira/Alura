<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SeriesController extends AbstractController
{
    #[Route('/series', name: 'app_series', methods: ['GET'])]
    public function seriesListk(): Response
    {
        $seriesList = [
            'Lost',
            'Greys Anatomy',
            'Loki',
            'Suits',
        ];

        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList,
        ]);
    }
}
