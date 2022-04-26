<?php

namespace App\Controller;

use App\Entity\Holiday;
use App\Entity\HolidayReason;
use App\Entity\User;
use App\Form\HolidayType;
use App\Repository\HolidayReasonRepository;
use App\Repository\HolidayRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile/holiday')]
class HolidayController extends AbstractController
{
    #[Route('/{id<\d+>}', name: 'holiday_index', methods: ['GET'])]
    public function index(HolidayRepository $holidayRepository, User $user): Response
    {
        return $this->render('holiday/index.html.twig', [
            'holidays' => $holidayRepository->findBy(["user" => $user], ['id' => "DESC"]),
        ]);
    }

    #[Route('/new/{id<\d+>}', name: 'holiday_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, HolidayReasonRepository $holidayReasonRepository, User $user): Response
    {
        $currentUser =  $this->getUser();

        if ($user != $currentUser && !in_array("ROLE_ADMIN", $currentUser->getRoles())) {
            return    $this->redirectToRoute('holiday_new', ['id' => $currentUser->getId()]);
        }
        $holiday = new Holiday();
        $form = $this->createForm(HolidayType::class, $holiday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $holiday->setUser($user)
                ->setStatus("n/a");
            $entityManager->persist($holiday);

            $entityManager->flush();

            return $this->redirectToRoute('holiday_index', ["id" => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('holiday/new.html.twig', [
            'holiday' => $holiday,
            'form' => $form,
            'holidayReason' => $holidayReasonRepository->findAll()
        ]);
    }

    #[Route('/show/{id}', name: 'holiday_show', methods: ['GET'])]
    public function show(Holiday $holiday): Response
    {
        return $this->render('holiday/show.html.twig', [
            'holiday' => $holiday,
        ]);
    }

    #[Route('/{id}/edit', name: 'holiday_edit', methods: ['GET', 'POST'])]
    public function edit(HolidayReasonRepository $holidayReasonRepository, Request $request, Holiday $holiday, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HolidayType::class, $holiday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $holiday = $form->getData();
            $holiday->setStatus("n/a")
                ->setManager(null);
            $entityManager->flush();

            return $this->redirectToRoute('holiday_index', ["id" => $holiday->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('holiday/new.html.twig', [
            'holiday' => $holiday,
            'form' => $form,
            'holidayReason' => $holidayReasonRepository->findAll()

        ]);
    }

    #[Route('/{id}', name: 'holiday_delete', methods: ['POST'])]
    public function delete(Request $request, Holiday $holiday, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $holiday->getId(), $request->request->get('_token'))) {
            $entityManager->remove($holiday);
            $entityManager->flush();
        }

        return $this->redirectToRoute('holiday_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id<\d+>}/{status}', name: 'holiday_aggrement')]
    public function aggrement(Request $request, Holiday $holiday, EntityManagerInterface $entityManager, String $status): Response
    {
        $holiday->setStatus($status)
            ->setManager($this->getUser());
        $entityManager->flush();
        return $this->redirectToRoute('holiday_index', ["id" => $holiday->getUser()->getId()], Response::HTTP_SEE_OTHER);
    }
}
