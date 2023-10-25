<?php


namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/comment')]
class CommentController extends AbstractController
{
    #[Route('/', name: 'app_comment', methods: ['GET'])]
    #[IsGranted("IS_AUTHENTICATED_REMEMBERED")]
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CommentRepository $commentRepository, Security $security): Response
    {
        $comment = new Comment();

        // Récupérer l'utilisateur connecté
        $user = $security->getUser();

        // Créer le formulaire en excluant le champ "user"
        $formOptions = [
            'data_class' => Comment::class,
        ];
        unset($formOptions['data_class'], $formOptions['user']);

        $form = $this->createForm(CommentType::class, $comment, $formOptions);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Lié l'utilisateur au commentaire
            $comment->setUser($user);

            $comment->setCreatedAt(new DateTimeImmutable());
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comment_show', methods: ['GET'])]
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        $formOptions = [
            'data_class' => Comment::class,
        ];
        unset($formOptions['data_class'], $formOptions['user']);
        $form = $this->createForm(CommentType::class, $comment, $formOptions);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('app_comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }
}
