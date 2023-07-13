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

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Cars;

class UsedCarsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/cars', name: 'app_cars')]
    public function index(): Response
    {
        $repository = $this->entityManager->getRepository(Cars::class);
        $cars = $repository->findAll();

        return $this->render('used_cars/index.html.twig', [
            'cars' => $cars,
        ]);
    }
}


