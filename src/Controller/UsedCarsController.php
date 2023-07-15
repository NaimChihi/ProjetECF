<?php

/*namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsedCarsController extends AbstractController
{
    #[Route('/cars', name: 'app_cars')]
    public function index(): Response
    {
        return $this->render('used_cars/index.html.twig', [
            'controller_name' => 'UsedCarsController',
        ]);
    }
}*/



namespace App\Controller;

use App\Entity\Cars;
use App\Repository\CarsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsedCarsController extends AbstractController
{
    private CarsRepository $carsRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(CarsRepository $carsRepository, EntityManagerInterface $entityManager)
    {
        $this->carsRepository = $carsRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/cars', name: 'app_cars')]
    public function index(): Response
    {
        $cars = $this->carsRepository->findAll();

        return $this->render('used_cars/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    #[Route('/cars/filter', name: 'app_cars_filter', methods: ['POST'])]
    public function filterCars(Request $request): Response
    {
        // Récupérer les valeurs des filtres depuis la requête
        $brand = $request->request->get('brand');
        $price = $request->request->get('price');
        $year = $request->request->get('year');
        $km = $request->request->get('km');

        // Construire les critères de filtrage
        $criteria = [
            'Brand' => $brand,
            'price' => $price,
            'year' => $year,
            'km' => $km,
        ];

        // Filtrer les voitures en fonction des critères
        $filteredCars = $this->carsRepository->findByCriteria($criteria);

        // Retourner les résultats au format JSON
        return $this->json($filteredCars);
    }
}

