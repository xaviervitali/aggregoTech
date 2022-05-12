<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Entity\User;
use App\Form\AttendancesViewType;
use App\Form\RHType;
use App\Repository\AddressBookActivityRepository;
use App\Repository\AttendanceRepository;
use App\Repository\FileUploadRepository;
use App\Repository\HolidayRepository;
use App\Repository\StatementRepository;
use App\Repository\SurveyRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RHController extends AbstractController
{
    #[Route('admin/rh', name: 'admin_rh')]
    public function index(): Response
    {
        $form = $this->createForm(RHType::class);
        // $user = $request->request->get('user');
        // if ($user) {
        //     return new JsonResponse([
        //         "attendances" => $attendanceRepository->findBy(["user" => $user]),
        //         "fileUploads" => $fileUploadRepository->findBy(["user" => $user]),
        //         "statements" => $statementRepository->findBy(["user" => $user]),
        //         "holidays" => $holidayRepository->findBy(["user" => $user]),
        //         "user" => $user

        //     ]);
        // }
        return $this->render('admin/rh/index.html.twig', [
            'controller_name' => 'RHController',
            "form" => $form->createView()

        ]);
    }
    #[Route('admin/rh/{id<\d+>}', name: 'admin_rh_show')]
    public function show(Request $request, User $user, AttendanceRepository $attendanceRepository, FileUploadRepository $fileUploadRepository, StatementRepository $statementRepository, HolidayRepository $holidayRepository, SurveyRepository $surveyRepository, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RHType::class);
        $attendanceForm = $this->createForm(AttendancesViewType::class);

        $attendanceForm->handleRequest($request);
        if ($attendanceForm->isSubmitted() && $attendanceForm->isValid()) {
            /**
             * @var DateTimeImmutable $createdAt
             */
            $createdAt = $attendanceForm->getData()->getCreatedAt();

            $attendance = new Attendance;
            $attendance->setUpdatedAt(new DateTimeImmutable())
                ->setCreatedAt($createdAt)
                ->setUser($user)
                ->setAddedBy($this->getUser());
            $em->persist($attendance);
            $em->flush();
        }


        return $this->render('admin/rh/index.html.twig', [
            'controller_name' => 'RHController',
            "form" => $form->createView(),
            "attendanceForm" => $attendanceForm->createView(),
            "attendances" => $attendanceRepository->findBy(["user" => $user]),
            "fileUploads" => $fileUploadRepository->findBy(["user" => $user], ["updatedAt" => "DESC"]),
            "surveys" => $surveyRepository->findBy(["user" => $user]),
            "statements" => $statementRepository->findBy(["user" => $user]),
            "holidays" => $holidayRepository->findBy(["user" => $user]),
            "allHolidays" => $holidayRepository->findBy([]),
            "user" => $user

        ]);
    }
}
