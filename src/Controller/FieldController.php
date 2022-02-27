<?php

namespace App\Controller;

use App\Entity\Field;
use App\Form\FieldType;
use App\Repository\FieldRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FieldController extends AbstractController
{
    /**
     * @Route("/admin/field", name="field_index")
     */
    public function index(FieldRepository $fieldRepository): Response
    {

        return $this->render('field/index.html.twig', [
            'fields' => $fieldRepository->findBy([], ["title"=>"ASC"])
        ]);
    }

        /**
     * @Route("/admin/field/delete/{id<\d+>}", name="field_delete")
     */
    public function delete(Field $field, EntityManagerInterface $em){
        $em->remove($field);
        $em->flush();
        return $this->redirectToRoute('field_index');
    }

    /**
     * @Route("/admin/field/add", name="field_add")
     */
    public function add(EntityManagerInterface $em,  Request $request){
        $form = $this->createForm(FieldType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute("field_index");
    }

     return $this->render("field/edit.html.twig", [
         "form" => $form->createView()
     ]);
    }

        /**
     * @Route("/profil/field/edit/{id<\d+>}", name="field_edit")
     */
    public function edit(Field $field, EntityManagerInterface $em,  Request $request){
        $form = $this->createForm(FieldType::class, $field);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $editCategory = $form->getData();
            $em->persist($editCategory);
            $em->flush();

            return $this->redirectToRoute("field_index");
    }
     return $this->render("field/edit.html.twig", [
         "field" => $field,
         "form" => $form->createView()
     ]);
    }
}
