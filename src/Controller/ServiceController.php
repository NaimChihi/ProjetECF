<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\Service2Type;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service')]
class ServiceController extends AbstractController
{
    #[Route('/', name: 'app_service', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }

    

    /*#[Route('/{id}', name: 'app_service_show', methods: ['GET'])]
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $service,
        ]);
    }*/
    
    


#[Route('/{id}/{type}', name: 'app_service_show', methods: ['GET'])]
    public function show(Service $service, string $type): Response
    {
        $templateName = 'service/view_service.html.twig';

        // Vérifiez la valeur du paramètre 'type' pour choisir le template approprié
        switch ($type) {
            case 'entretien':
                $templateName = 'service/entretien.html.twig';
                break;
            case 'mecanique':
                $templateName = 'service/mecanique.html.twig';
                break;
            case 'carrosserie':
                $templateName = 'service/carrosserie.html.twig';
                break;
            // Ajoutez d'autres cas pour les différents types de service
            default:
                break;
        }

        return $this->render($templateName, [
            'service' => $service,
        ]);
    }

}