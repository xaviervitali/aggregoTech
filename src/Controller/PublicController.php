<?php

namespace App\Controller;

use App\Repository\FileUploadRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    #[Route('/', name: 'public')]
    public function index(): Response
    {
        return $this->render('public/index.html.twig');
    }
    /**
     * @Route("/services", name="services")
     */
    public function services(): Response
    {
        return $this->render('public/services.html.twig');
    }

    /**
     * @Route("/equipe", name="equipe")
     */
    public function equipe(UserRepository $userRepository): Response
    {
        return $this->render('public/equipe.html.twig', ["users" => $userRepository->findAll()]);
    }


    /**
     * @Route("/agence", name="agence")
     */
    public function agence(): Response
    {
        return $this->render('public/agence.html.twig');
    }
    /**
     * @Route("/projets", name="projets")
     */
    public function projets(): Response
    {
        return $this->render('public/projets.html.twig');
    }

    /**
     * @Route("/dons", name="dons")
     */
    public function dons(): Response
    {
        return $this->render('public/dons.html.twig');
    }

       /**
     * @Route("/mentionslegales", name="mentionsLegales")
     */
    public function mentionLegales(): Response
    {
        return $this->render('public/mentionsLegales.html.twig');
    }
    /**
     * @Route("/telechargements", name="telechargement")
     */
    public function telechargement(FileUploadRepository $fileUploadRepository): Response
    {
        $files = $fileUploadRepository->findBy([]);
        $files = array_filter($files, function ($file) {
            /**
             * @var FileUpload $file
             */
        return    strtolower( $file->getFileCategory()) == "public";
        });
        
        return $this->render('public/telechargement.html.twig', ["files" => $files]);
    }
}
