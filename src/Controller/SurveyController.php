<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Field;
use App\Entity\Survey;
use App\Entity\User;
use App\Form\SurveyType;
use App\Repository\CategoryRepository;
use App\Repository\FieldRepository;
use App\Repository\SurveyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SurveyController extends AbstractController
{
    /**
     * @Route("/profile/survey/new", name="survey_add")
     */
    public function add( Request $request, EntityManagerInterface $em, CategoryRepository $repo, SerializerInterface $serializer, FieldRepository $fr, CategoryRepository $cr): Response
    {
        $form = $this->createForm(SurveyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $survey = $request->request->get('survey');
            
            for($i = 0; $i<count($survey['fields']); $i++){
                $s = new Survey;

                $s->setCategory($cr->findBy(['id'=>$survey['categories']],[],1,0)[0])
                ->setField($fr->findBy(['id'=>$survey['fields'][$i]],[],1,0)[0])
                ->setAnswer($survey['answer'][$i])
                ->setUser($this->getUser())
                ;
                $em->persist($s);
                $em->flush();
            
            }
            $this->addFlash('success', 'Activité : ' . $cr->findBy(['id'=>$survey['categories']],[],1,0)[0]->getTitle() .' enregistrée');
        }
        $categories = $repo->findAll();
        $categoriesJson = $serializer->serialize($categories, 'json',   ['groups' => 'category']);

        return $this->render("survey/new.html.twig", [
            "form" => $form->createView(), "categories"=>$categoriesJson
        ]);
    }

    /**
     * @Route("/profile/survey/{id}", name="survey_index")
     */
    function index(User $user, SurveyRepository $surveyRepository): Response
    {
        $surveys = $surveyRepository->findByUser($user);
        return $this->render('survey/index.html.twig', [
            'surveys' => $surveys
        ]);
    }

    /**
     * @Route("/profile/survey/delete/{id}", name="survey_delete")
     */
    function delete(Survey $survey, SurveyRepository $surveyRepository, EntityManagerInterface $em): Response
    {
        $nbOfFields = count($survey->getCategory()->getFields());
        $currendId = $survey->getId();

        for($i=0; $i < $nbOfFields; $i++){
            $currentSurvey = $surveyRepository->findOneBy(['id'=> $currendId-$i]);
                     $em->remove($currentSurvey);
            $em->flush();
        }

        $surveys = $surveyRepository->findByUser($this->getUser());
        return $this->redirectToRoute('survey_index', ['id'=>$this->getUser()->getId(),
            'surveys' => $surveys
        ]);
    }
}
