<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SurveyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SurveyController extends AbstractController
{
    #[Route('/profile/survey', name: 'survey')]
    public function index(SurveyRepository $surveyRepository): Response
    {
        return $this->render(
            'admin/survey/index.html.twig',
            ["surveys" => $surveyRepository->findBy(["user" => $this->getUser()], ["createdAt" => "DESC"])]
        );
    }

    #[Route('/profile/survey_beta', name: 'survey_beta')]
    public function beta(SurveyRepository $surveyRepository): Response
    {
        return $this->render(
            'admin/survey/indexV2.html.twig',
            ["surveys" => $surveyRepository->findBy([], ["createdAt" => "DESC"])]
        );
    }
}
