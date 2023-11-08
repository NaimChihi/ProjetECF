<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\Cars1Type;
use App\Repository\CarsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/cars')]
class AdminCarsController extends AbstractController
{
    #[Route('/', name: 'app_admin_cars_index', methods: ['GET'])]
    public function index(CarsRepository $carsRepository): Response
    {
        return $this->render('admin_cars/index.html.twig', [
            'cars' => $carsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_cars_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarsRepository $carsRepository): Response
    {
        $car = new Cars();
        $form = $this->createForm(Cars1Type::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carsRepository->save($car, true);

            return $this->redirectToRoute('app_admin_cars_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_cars/new.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_cars_show', methods: ['GET'])]
    public function show(Cars $car): Response
    {
        return $this->render('admin_cars/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_cars_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cars $car, CarsRepository $carsRepository): Response
    {
        $form = $this->createForm(Cars1Type::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carsRepository->save($car, true);

            return $this->redirectToRoute('app_admin_cars_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_cars/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_cars_delete', methods: ['POST'])]
    public function delete(Request $request, Cars $car, CarsRepository $carsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $carsRepository->remove($car, true);
        }

        return $this->redirectToRoute('app_admin_cars_index', [], Response::HTTP_SEE_OTHER);
    }
}