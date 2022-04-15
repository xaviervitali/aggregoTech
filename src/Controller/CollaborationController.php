<?php

namespace App\Controller;

use App\Entity\Collaboration;
use App\Form\CollaborationType;
use App\Repository\CollaborationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/collaboration')]
class CollaborationController extends AbstractController
{
    #[Route('/', name: 'collaboration_index', methods: ['GET'])]
    public function index(CollaborationRepository $collaborationRepository): Response
    {
        return $this->render('collaboration/index.html.twig', [
            'collaborations' => $collaborationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'collaboration_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $collaboration = new Collaboration();
        $form = $this->createForm(CollaborationType::class, $collaboration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($collaboration);
            $entityManager->flush();

            return $this->redirectToRoute('collaboration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collaboration/new.html.twig', [
            'collaboration' => $collaboration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'collaboration_show', methods: ['GET'])]
    public function show(Collaboration $collaboration): Response
    {
        return $this->render('collaboration/show.html.twig', [
            'collaboration' => $collaboration,
        ]);
    }

    #[Route('/{id}/edit', name: 'collaboration_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Collaboration $collaboration, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CollaborationType::class, $collaboration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('collaboration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('collaboration/edit.html.twig', [
            'collaboration' => $collaboration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'collaboration_delete', methods: ['POST'])]
    public function delete(Request $request, Collaboration $collaboration, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $collaboration->getId(), $request->request->get('_token'))) {
            $entityManager->remove($collaboration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collaboration_index', [], Response::HTTP_SEE_OTHER);
    }
}
