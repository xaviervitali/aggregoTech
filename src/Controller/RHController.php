<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Entity\PostIt;
use App\Entity\User;
use App\Form\AttendancesViewType;
use App\Form\PostItType;
use App\Form\RHType;
use App\Repository\AddressBookActivityRepository;
use App\Repository\AppreciationCategoryRepository;
use App\Repository\AttendanceRepository;
use App\Repository\FileUploadRepository;
use App\Repository\HolidayRepository;
use App\Repository\LevelRepository;
use App\Repository\PostItRepository;
use App\Repository\StatementRepository;
use App\Repository\SurveyRepository;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use ReCaptcha\RequestMethod\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RHController extends AbstractController
{

    private $userTypes;
    public function __construct(UserRepository $userRepository)
    {
        $this->userTypes = [
            'Salariés en Insertion' => $userRepository->findAllUser('["ROLE_EMPLOYEE"]'),
            "RH" => $userRepository->findAllUser('["ROLE_RH"]'),
            "Administrateurs" => $userRepository->findAllUser('["ROLE_ADMIN"]'),
            "Anciens Salariés" => $userRepository->findBy(["roles" => ["ROLE_USER"]])
        ];
    }

    #[Route('admin/rh', name: 'admin_rh')]
    public function index(PostItRepository $postItRepository): Response
    {

        return $this->render('admin/rh/index.html.twig', [
            "userTypes" => $this->userTypes,
            "postIts" => $postItRepository->findAll()

        ]);
    }
    #[Route('admin/rh/{id<\d+>}', name: 'admin_rh_show')]
    public function show(Request $request, User $user, AttendanceRepository $attendanceRepository, FileUploadRepository $fileUploadRepository, StatementRepository $statementRepository, HolidayRepository $holidayRepository, SurveyRepository $surveyRepository, EntityManagerInterface $em, AppreciationCategoryRepository $appreciationCategoryRepository, LevelRepository $levelRepository, PostItRepository $postItRepository): Response
    {
        $postItForm = $this->createForm(PostItType::class);
        $attendanceForm = $this->createForm(AttendancesViewType::class);
        $attendanceForm->handleRequest($request);
        $postItForm->handleRequest($request);
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

        if ($postItForm->isSubmitted() && $postItForm->isValid()) {
            $now = new DateTimeImmutable();
            $postIt = $postItForm->getData();
            $postIt
                ->setCreatedAt($now)
                ->setCreatedBy($this->getUser())
                ->setEmployee($user)
                ->setContent($postItForm->getData()->getContent());
            $em->persist($postIt);
            $em->flush();
            $this->addFlash("info", "Post It enregistré");
        }

        return $this->render('admin/rh/index.html.twig', [
            // "rhForm" => $rhForm->createView(),
            "userTypes" => $this->userTypes,
            "attendanceForm" => $attendanceForm->createView(),
            "postItForm" => $postItForm->createView(),
            "attendances" => $attendanceRepository->findBy(["user" => $user]),
            "fileUploads" => $fileUploadRepository->findBy(["user" => $user], ["updatedAt" => "DESC"]),
            "surveys" => $surveyRepository->findBy(["user" => $user]),
            "holidays" => $holidayRepository->findBy(["user" => $user]),
            "allHolidays" => $holidayRepository->findBy([]),
            "user" => $user,
            "statements" => $statementRepository->findBy(["user" => $user]),
            "statementCategories" => $appreciationCategoryRepository->findBy([]),
            "levels" => $levelRepository->findBy([], ["title" => "ASC"]),
            "userPostIts" => $postItRepository->findBy(["employee" => $user]),
            "postIts" => $postItRepository->findAll()

        ]);
    }

    /**
     * @Route("/postIt/delete/{id}",name="postIt_delete")
     */
    public function postItDelete(EntityManagerInterface $em, PostIt $postIt)
    {

        $user = $postIt->getEmployee()->getId();
        $em->remove($postIt);
        $em->flush();

        return $this->redirectToRoute("admin_rh_show", ["id" => $user]);
    }
}
