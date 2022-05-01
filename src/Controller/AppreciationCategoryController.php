<?php

namespace App\Controller;

use App\Entity\AppreciationCategory;
use App\Entity\Skill;
use App\Form\AppreciationCategoryType;
use App\Repository\AppreciationCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/appreciationcategory')]
class AppreciationCategoryController extends AbstractController
{
    #[Route('/', name: 'appreciation_category_index', methods: ['GET', "POST"])]
    public function index(AppreciationCategoryRepository $appreciationCategoryRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AppreciationCategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appreciationCategory = new AppreciationCategory();
            $app = $form->getData();
            $appreciationCategory->setTitle($app->getTitle());
            $entityManager->persist($appreciationCategory);
            foreach ($app->getSkills() as $skill) {
                $skill
                    ->setCategory($appreciationCategory);
                $entityManager->persist($skill);
            }
            $entityManager->flush();

            return $this->redirectToRoute('appreciation_category_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin/appreciation_category/index.html.twig', [
            'appreciation_categories' => $appreciationCategoryRepository->findAll(),
            "form" => $form->createView()
        ]);
    }
    #[Route('/{id}', name: 'appreciation_category_show', methods: ['GET'])]
    public function show(AppreciationCategory $appreciationCategory): Response
    {
        return $this->render('admin/appreciation_category/show.html.twig', [
            'appreciation_category' => $appreciationCategory,
        ]);
    }
    #[Route('/skill/{id}', name: 'skill_delete', methods: ['POST'])]

    public function deleteSkill(Skill $skill, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($skill);
        $entityManager->flush();
        return new JsonResponse(["id" => $skill->getId(), "status" => "Ok"]);
    }
    #[Route('/{id<\d+>}/edit', name: 'appreciation_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AppreciationCategory $appreciationCategory, EntityManagerInterface $entityManager, AppreciationCategoryRepository $appreciationCategoryRepository): Response
    {
        $form = $this->createForm(AppreciationCategoryType::class, $appreciationCategory);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formSkills = $form->getData()->getSkills();
            foreach ($formSkills as $skill) {
                $skill->setCategory($appreciationCategory);
                $entityManager->persist($skill);
            };

            $entityManager->flush();

            return $this->redirectToRoute('appreciation_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/appreciation_category/edit.html.twig', [
            'appreciation_category' => $appreciationCategory,
            'form' => $form,
        ]);
    }


    #[Route('/{id<\d+>}', name: 'appreciation_category_delete', methods: ['POST'])]
    public function delete(Request $request, AppreciationCategory $appreciationCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $appreciationCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($appreciationCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('appreciation_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
