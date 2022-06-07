<?php

namespace App\Controller;

use App\Entity\Holiday;
use App\Entity\HolidayReason;
use App\Entity\User;
use App\Form\HolidayType;
use App\Repository\HolidayReasonRepository;
use App\Repository\HolidayRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/profile/holiday')]
class HolidayController extends AbstractController
{
    private SerializerInterface $serializer;
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
    #[Route('/', name: 'holiday_index', methods: ['GET'])]
    public function index(HolidayRepository $holidayRepository): Response
    {
        return $this->render('admin/holiday/index.html.twig', [
            'holidays' => $holidayRepository->findBy(["user" => $this->getUser()], ['id' => "DESC"]),
        ]);
    }

    #[Route('/new', name: 'holiday_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, HolidayReasonRepository $holidayReasonRepository): Response
    {
        // $currentUser =  $this->getUser();

        // if ($user != $currentUser && !in_array("ROLE_ADMIN", $currentUser->getRoles())) {
        //     return    $this->redirectToRoute('holiday_new', ['id' => $currentUser->getId()]);
        // }

        $holiday = new Holiday();
        $form = $this->createForm(HolidayType::class, $holiday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $holiday->setUser($this->getUser())
                ->setCreatedAt(new DateTimeImmutable());
            $entityManager->persist($holiday);

            $entityManager->flush();

            return $this->redirectToRoute('holiday_index');
        }

        return $this->renderForm('admin/holiday/new.html.twig', [
            'holiday' => $holiday,
            'form' => $form,
            'holidayReason' => $holidayReasonRepository->findAll()
        ]);
    }

    #[Route('/show/{id}', name: 'holiday_show', methods: ['GET'])]
    public function show(Holiday $holiday): Response
    {
        return $this->render('admin/holiday/show.html.twig', [
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
            $holiday->setStatus(null)
                ->setManager(null);
            $entityManager->flush();

            return $this->redirectToRoute('holiday_index', ["id" => $holiday->getUser()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/holiday/new.html.twig', [
            'holiday' => $holiday,
            'form' => $form,
            'holidayReason' => $holidayReasonRepository->findAll()

        ]);
    }

    #[Route('/{id{id<\d+>}/delete}', name: 'holiday_delete')]
    public function delete(Holiday $holiday, EntityManagerInterface $entityManager): Response
    {
        if ($holiday->getUser() == $this->getUser()) {
            $entityManager->remove($holiday);
            $entityManager->flush();

            return $this->redirectToRoute('holiday_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/{id<\d+>}/{status}', name: 'holiday_aggrement')]
    public function aggrement(Request $request, Holiday $holiday, EntityManagerInterface $entityManager, ?Boolean $status): Response
    {
        $holiday->setStatus($status)
            ->setManager($this->getUser());
        $entityManager->flush();
        return $this->redirectToRoute('holiday_index', ["id" => $holiday->getUser()->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/all', name: 'holiday_all')]
    public function all(HolidayRepository $holidayRepository): Response
    {
        $holidays = array_filter($holidayRepository->findAll(), function ($h) {
            return $h->getStatus() == null || $h->getStatus();
        });

        $customArray = [];

        foreach ($holidays as $holiday) {
            $user = $holiday->getUser();
            $customArray[] = ["title" => $user->getFirstname() . " " . $user->getFirstname(), "start" => $holiday->getStartDate(), "end" => $holiday->getEndDate(), "backgroundColor" => $holiday->getStatus() ? "rgb(65, 180, 120)" : "rgb(241, 97, 131)", "allDay" => true,];
        };

        return new Response($this->serializer->serialize($customArray, "json"));
    }
}
