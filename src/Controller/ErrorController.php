<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="error")
     */
    public function index(Request $request): Response
    {
        return $this->render('error/common.html.twig', []);
    }
    /**
     * @Route("/underConstruction", name="underConstruction")
     */
    public  function underConstruction(Request $request): Response
    {
        return $this->render('error/underConstruction.html.twig', []);
    }
}
