<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SurveyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SurveyController extends AbstractController
{
    #[Route('/profile/survey/{id}', name: 'survey')]
    public function index(SurveyRepository $surveyRepository, User $user): Response
    {
        return $this->render(
            'survey/index.html.twig',
            ["surveys" => $surveyRepository->findBy(["user" => $user], ["createdAt" => "DESC"])]
        );
    }
}
