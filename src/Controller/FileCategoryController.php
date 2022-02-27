<?php

namespace App\Controller;

use App\Entity\FileCategory;
use App\Form\FileCategoryType;
use App\Repository\FileCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/file/category')]
class FileCategoryController extends AbstractController
{
    #[Route('/admin/categories', name: 'file_category_index', methods: ['GET'])]
    public function index(FileCategoryRepository $fileCategoryRepository): Response
    {
        return $this->render('file_category/index.html.twig', [
            'file_categories' => $fileCategoryRepository->findAll(),
        ]);
    }

    #[Route('/admin/category/new', name: 'file_category_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $fileCategory = new FileCategory();
        $form = $this->createForm(FileCategoryType::class, $fileCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fileCategory);
            $entityManager->flush();

            return $this->redirectToRoute('file_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file_category/new.html.twig', [
            'file_category' => $fileCategory,
            'form' => $form,
        ]);
    }

    #[Route('/admin/category/{id}', name: 'file_category_show', methods: ['GET'])]
    public function show(FileCategory $fileCategory): Response
    {
        return $this->render('file_category/show.html.twig', [
            'file_category' => $fileCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'file_category_edit', methods: ['GET','POST'])]
    public function edit(Request $request, FileCategory $fileCategory): Response
    {
        $form = $this->createForm(FileCategoryType::class, $fileCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('file_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file_category/edit.html.twig', [
            'file_category' => $fileCategory,
            'form' => $form,
        ]);
    }

    #[Route('/admin/category/delete/{id}', name: 'file_category_delete', methods: ['POST'])]
    public function delete(Request $request, FileCategory $fileCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fileCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fileCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('file_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
