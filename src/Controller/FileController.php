<?php

namespace App\Controller;

use App\Entity\FileUpload;
use App\Form\FileUploadType;
use App\Form\VichFileType;
use App\Repository\FileCategoryRepository;
use App\Repository\FileRepository;
use App\Repository\FileUploadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FileController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }
    /**
     * @Route("/profile/file", name="file_index")
     */
    public function index(FileUploadRepository $fr, Request $request, EntityManagerInterface $em): Response
    {
        $files = $fr->findBy([], ["updatedAt" => 'DESC']);

        $commonFiles = array_filter(
            $files,
            function ($f) {
                return in_array('ROLE_ADMIN', $f->getUser()->getRoles()) || in_array('ROLE_RH', $f->getUser()->getRoles());
            }
        );


        $userFiles = array_filter(
            $files,
            function ($f) {
                /**
                 * @var FileUpload $f
                 */
                return  $f->getUser() === $this->getUser();
            }
        );



        $form = $this->createForm(FileUploadType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $user = $this->getUser();
            $task->setUser($user);
            $task->setDescription($task->getDescription() ?? "Pas de description ...");

            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute("file_index");
        }

        return $this->render('admin/file/index.html.twig', [
            'form' => $form->createView(), 'adminFiles' => $commonFiles, 'userFiles' => $userFiles
        ]);
    }

    /**
     * @Route("/profile/file/new", name="file_new")
     */
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(FileUploadType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** 
             * @var FileUpload $task
             */
            $task = $form->getData();
            $user = $this->getUser();
            $task->setUser($user);


            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute("file_index");
        }

        return $this->render("admin/file/new.html.twig", [
            "form" => $form->createView()
        ]);

        return $this->render('admin/file/new.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/profile/file/delete/{id<\d+>}", name="file_delete")
     */
    public function delete(FileUpload $fileUpload, EntityManagerInterface $em)
    {
        $em->remove($fileUpload);
        $em->flush();

        return $this->redirectToRoute('file_index');
    }
}
