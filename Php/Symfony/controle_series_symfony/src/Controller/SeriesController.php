<?php

namespace App\Controller;

use App\Dto\SeriesCreateFormInput;
use App\Entity\Series;
use App\Form\SeriesType;
use App\Repository\SeriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SeriesController extends AbstractController
{
    public function __construct(
        private SeriesRepository $seriesRepository,
        private EntityManagerInterface $entityManager,
    ) {
        
    }

    #[Route('/series', name: 'app_series', methods: ['GET'])]
    public function seriesList(): Response
    {
        $seriesList = $this->seriesRepository->findAll();

        return $this->render('series/index.html.twig', [
            'seriesList' => $seriesList,
        ]);
    }

    #[Route('/series/create', name: 'app_series_form', methods: ['GET'])]
    public function addSeriesForm(): Response
    {
        $seriesForm = $this->createForm(SeriesType::class, new SeriesCreateFormInput());
        return $this->render('series/form.html.twig', compact('seriesForm'));
    }

    #[Route('/series/create', name: 'app_add_series', methods: ['POST'])]
    public function addSeries(Request $request): Response
    {
        $input = new SeriesCreateFormInput();
        $seriesForm = $this->createForm(SeriesType::class, $input)
            ->handleRequest($request);

        if (!$seriesForm->isValid()) {
            return $this->render('series/form.html.twig', compact('seriesForm'));
        }

        $series = new Series($input->seriesName);
        for ($i=0; $i < ; $i++) { 
            # code...
        }
        
        $this->addFlash(
            'success', 
            "Série \"{$input->getName()}\" adicionada com sucesso");

        $this->seriesRepository->add($input, true);
        return new RedirectResponse('/series');
    }

    #[Route(
        '/series/delete/{id}', 
        name: 'app_delete_series', 
        methods: ['DELETE'],
        requirements: ['id' => '[0-9]+'])]
    public function deleteSeries(int $id): Response
    {
        $this->seriesRepository->removeById($id);
        $this->addFlash('success', 'Série removida com sucesso');

        return new RedirectResponse(url: '/series');
    }

    #[Route('/series/edit/{series}', name: 'app_edit_series_form', methods:['GET'])]
    public function editSeriesForm(Series $series): Response
    {
        $seriesForm = $this->createForm(SeriesType::class, $series, ['is_edit' => true]);
        return $this->render('series/form.html.twig', compact('seriesForm', 'series'));
    }

    #[Route('series/edit/{series}', name:'app_store_series_changes', methods:['PATCH'])]
    public function storeSeriesChanges(Series $series, Request $request): Response
    {
        $seriesForm = $this->createForm(SeriesType::class, $series, ['is_edit' => true]);
        $seriesForm->handleRequest($request);

        if (!$seriesForm->isValid()) {
            return $this->render('series/form.html.twig', compact('seriesForm', 'series'));
        }
        
        $this->addFlash('success', "Série \"{$series->getName()}\" editada com sucesso");
        $this->entityManager->flush();

        return new RedirectResponse('/series');
    }
}
