<?php

namespace App\Controller;

use App\Entity\Level;
use App\Form\LevelType;
use App\Repository\LevelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/appreciationlevel')]
class AppreciationLevelController extends AbstractController
{
    #[Route('/', name: 'appreciation_level_index', methods: ['GET', "POST"])]
    public function index(LevelRepository $levelRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $level = new Level();
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($level);
            $entityManager->flush();

            return $this->redirectToRoute('appreciation_level_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/appreciation_level/index.html.twig', [
            'levels' => $levelRepository->findAll(),
            "form" => $form->createView()
        ]);
    }



    #[Route('/{id}', name: 'appreciation_level_show', methods: ['GET'])]
    public function show(Level $level): Response
    {
        return $this->render('admin/appreciation_level/show.html.twig', [
            'level' => $level,
        ]);
    }

    #[Route('/{id}/edit', name: 'appreciation_level_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Level $level, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('appreciation_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/appreciation_level/edit.html.twig', [
            'level' => $level,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'appreciation_level_delete', methods: ['POST'])]
    public function delete(Request $request, Level $level, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $level->getId(), $request->request->get('_token'))) {
            $entityManager->remove($level);
            $entityManager->flush();
        }

        return $this->redirectToRoute('appreciation_level_index', [], Response::HTTP_SEE_OTHER);
    }
}
