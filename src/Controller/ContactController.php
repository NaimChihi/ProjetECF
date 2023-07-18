<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $address = $form->get('email')->getData();
            $subject = $form ->get('subject') ->getData();
            $content = $form ->get('content') ->getData();

            $email = (new Email())
            ->from($address)
            ->to('admin@admin.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->html($content);

            $mailer->send($email);
            

        }
        
        return $this->render ('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form->createView()

        ]);
    }
}
