<?php

namespace App\Controller;

use App\Entity\Appreciation;
use App\Entity\Statement;
use App\Entity\StatementComment;
use App\Entity\User;
use App\Form\StatementCommentType;
use App\Form\StatementType;
use App\Repository\AppreciationCategoryRepository;
use App\Repository\AppreciationRepository;
use App\Repository\CategoryRepository;
use App\Repository\LevelRepository;
use App\Repository\SkillRepository;
use App\Repository\StatementRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/profile/statement')]
class StatementController extends AbstractController
{

    private EntityManagerInterface $em;
    private SkillRepository $skillRepository;
    private UserRepository $userRepository;
    private LevelRepository $levelRepository;
    private Security $security;

    public function __construct(EntityManagerInterface $em, SkillRepository $skillRepository, UserRepository $userRepository, LevelRepository $levelRepository, Security $security)
    {

        $this->userRepository = $userRepository;
        $this->skillRepository = $skillRepository;
        $this->levelRepository = $levelRepository;
        $this->security = $security;
        $this->em = $em;
    }
    #[Route('/', name: 'statement_index', methods: ['GET'])]
    public function index(StatementRepository $statementRepository, UserRepository $userRepository): Response
    {

        return $this->render('admin/statement/index.html.twig', [
            'statements' => $statementRepository->findBy([], ["user" => "ASC"]),
            "users" => $userRepository->findAll()
        ]);
    }

    #[Route('/new/{id<\d+>}', name: 'statement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, User $user, EntityManagerInterface $entityManager, AppreciationCategoryRepository $appreciationCategoryRepository): Response
    {

        // $form = $this->createForm(AppreciationsType::class);

        $form = $this->createForm(StatementType::class);
        $form->handleRequest($request);
        if ($request->getContent()) {
            $evaluations = $request->getContent();
            $this->newBilan(json_decode($evaluations));
            return new JsonResponse("success");
        }

        return $this->renderForm('admin/statement/new.html.twig', [
            'form' => $form,
            "categories" => $appreciationCategoryRepository->findAll(),
            "user" => $user
        ]);
    }


    private function newBilan($evaluations)
    {
        $date = new DateTimeImmutable();
        $bilan = new Statement;
        $userId = $evaluations[0]->user;
        $user = $this->userRepository->findOneBy(["id" => $userId]);
        $bilan->setUser($user)
            ->setCreatedAt($date);
        foreach ($evaluations as $evaluation) {
            $appreciation = new Appreciation;
            $competence = $this->skillRepository->findOneBy(["id" => $evaluation->skill]);
            $appreciation
                ->setSkill($competence)
                ->setComment($evaluation->comment)
                ->setLevel($this->levelRepository->findOneBy(["id" => $evaluation->level]));

            $bilan->addAppreciation($appreciation);
            $this->em->persist($appreciation);
        }
        $this->em->persist($bilan);
        $this->em->flush();
    }
    #[Route('/{id}', name: 'statement_show', methods: ['GET', "POST"])]
    public function show(Statement $statement, AppreciationCategoryRepository $appreciationCategoryRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $statementComment = new StatementComment();
        $form = $this->createForm(StatementCommentType::class, $statementComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->security->getUser();
            $date = new DateTimeImmutable();

            $statementComment
                ->setComment($form->getData()->getComment())
                ->setCreatedAt($date)
                ->setUser($user);
            $entityManager->persist($statementComment);
            if (in_array("ROLE_EMPLOYEE", $this->security->getUser()->getRoles())) {
                $statement->setUserComment($statementComment);
            } else {
                $statement->setManagerComment($statementComment);
            }
            $entityManager->flush();

            return $this->redirectToRoute('statement_index');
        }
        return $this->render('admin/statement/show.html.twig', [
            'statement' => $statement,
            "categories" => $appreciationCategoryRepository->findAll(),
            "form" => $form->createView()

        ]);
    }

    #[Route('/{id}/edit', name: 'statement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Statement $statement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatementType::class, $statement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('statement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/statement/edit.html.twig', [
            'statement' => $statement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'statement_delete', methods: ['POST'])]
    public function delete(Request $request, Statement $statement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $statement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($statement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('statement_index', [], Response::HTTP_SEE_OTHER);
    }
}
