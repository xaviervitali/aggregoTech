<?php

namespace App\Controller;

use App\Entity\CollaborationChoice;
use App\Form\CollaborationChoiceType;
use App\Repository\CollaborationChoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/collaboration/choice')]
class CollaborationChoiceController extends AbstractController
{
    #[Route('/', name: 'collaboration_choice_index', methods: ['GET'])]
    public function index(CollaborationChoiceRepository $collaborationChoiceRepository): Response
    {
        return $this->render('admin/collaboration_choice/index.html.twig', [
            'collaboration_choices' => $collaborationChoiceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'collaboration_choice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CollaborationChoiceRepository $collaborationChoiceRepository): Response
    {
        $collaborationChoice = new CollaborationChoice();
        $form = $this->createForm(CollaborationChoiceType::class, $collaborationChoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($collaborationChoice);
            $entityManager->flush();

            // return $this->redirectToRoute('collaboration_choice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/collaboration_choice/new.html.twig', [
            'collaboration_choice' => $collaborationChoice,
            'form' => $form,
            'collaboration_choices' => $collaborationChoiceRepository->findAll(),

        ]);
    }

    #[Route('/{id}', name: 'collaboration_choice_show', methods: ['GET'])]
    public function show(CollaborationChoice $collaborationChoice): Response
    {
        return $this->render('admin/collaboration_choice/show.html.twig', [
            'collaboration_choice' => $collaborationChoice,
        ]);
    }

    #[Route('/{id}/edit', name: 'collaboration_choice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CollaborationChoice $collaborationChoice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CollaborationChoiceType::class, $collaborationChoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('collaboration_choice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/collaboration_choice/edit.html.twig', [
            'collaboration_choice' => $collaborationChoice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'collaboration_choice_delete', methods: ['POST'])]
    public function delete(Request $request, CollaborationChoice $collaborationChoice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $collaborationChoice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($collaborationChoice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collaboration_choice_index', [], Response::HTTP_SEE_OTHER);
    }
}
