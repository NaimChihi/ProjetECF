<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;




    class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_index')]
    #[IsGranted('ROLE_ADMIN')] // Restreins l'accès
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }




    
    #[Route('/utilisateurs', name: 'utilisateurs')]
    public function usersList (UserRepository $users) {
        return $this->render("admin/users.html.twig", [
            'users' => $users->findAll()
        ]);

    }

    /**
     * Modifier un utilisateur
     */

    #[Route('/utilisateurs/modifier/{id}', name:'modifier_utilisateur')]

    public function editUser(User $user, Request $request, EntityManagerInterface $entityManager):Response
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form ->handleRequest($request);
    
        
        if ($form ->isSubmitted() && $form-> isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
        

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }
            return $this->render('admin/edituser.html.twig', [
                'userForm' => $form->createView()
            ]);
        }
    }


