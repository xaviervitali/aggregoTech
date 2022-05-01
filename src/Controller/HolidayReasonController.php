<?php

namespace App\Controller;

use App\Entity\HolidayReason;
use App\Form\HolidayReasonType;
use App\Repository\HolidayReasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/holidayreason')]
class HolidayReasonController extends AbstractController
{
    #[Route('/', name: 'holiday_reason_index', methods: ['GET'])]
    public function index(HolidayReasonRepository $holidayReasonRepository): Response
    {
        return $this->render('admin/holiday_reason/index.html.twig', [
            'holiday_reasons' => $holidayReasonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'holiday_reason_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $holidayReason = new HolidayReason();
        $form = $this->createForm(HolidayReasonType::class, $holidayReason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($holidayReason);
            $entityManager->flush();

            return $this->redirectToRoute('holiday_reason_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/holiday_reason/new.html.twig', [
            'holiday_reason' => $holidayReason,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'holiday_reason_show', methods: ['GET'])]
    public function show(HolidayReason $holidayReason): Response
    {
        return $this->render('admin/holiday_reason/show.html.twig', [
            'holiday_reason' => $holidayReason,
        ]);
    }

    #[Route('/{id}/edit', name: 'holiday_reason_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HolidayReason $holidayReason, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HolidayReasonType::class, $holidayReason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('holiday_reason_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/holiday_reason/edit.html.twig', [
            'holiday_reason' => $holidayReason,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'holiday_reason_delete', methods: ['POST'])]
    public function delete(Request $request, HolidayReason $holidayReason, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $holidayReason->getId(), $request->request->get('_token'))) {
            $entityManager->remove($holidayReason);
            $entityManager->flush();
        }

        return $this->redirectToRoute('holiday_reason_index', [], Response::HTTP_SEE_OTHER);
    }
}
