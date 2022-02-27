<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\FieldRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category", name="category_index")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findBy([], ["updatedAt"=>"DESC"]),
            "active"=>"category_index"
        ]);
    }

    /**
     * @Route("/admin/category/edit/{id<\d+>}", name="category_edit")
     */
    public function edit(Category $category, EntityManagerInterface $em,  Request $request){
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $editCategory = $form->getData();
            $em->persist($editCategory);
            $em->flush();

            return $this->redirectToRoute("category_index");
    }
     return $this->render("category/edit.html.twig", [
         "category" => $category,
         "form" => $form->createView()
     ]);
    }

    /**
     * @Route("/admin/category/add", name="category_add")
     */
    public function add(EntityManagerInterface $em,  Request $request){
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute("category_index");
    }
     return $this->render("category/edit.html.twig", [
         "form" => $form->createView()
     ]);
    }
    
    /**
     * @Route("/admin/category/delete/{id<\d+>}", name="category_delete")
     */
    public function delete(Category $category, EntityManagerInterface $em){
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('category_index');
    }
}
