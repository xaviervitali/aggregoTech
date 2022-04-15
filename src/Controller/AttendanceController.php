<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Entity\User;
use App\Form\AttendancesViewType;
use App\Form\AttendanceType;
use App\Repository\AttendanceRepository;
use App\Repository\SignatureRepository;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\AST\Join;
use Error;
use PhpParser\Node\Stmt\Label;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AttendanceController extends AbstractController
{


    /**
     * @Route("/profile/attendance/{id<\d+>}", name="attendance")
     */
    public function index(AttendanceRepository $attendanceRepository, User $user, Request $request, EntityManagerInterface $em): Response
    {
        /**
         * @var User $currentUser
         */
        $currentUser =  $this->getUser();
        if ($user != $currentUser && !in_array("ROLE_ADMIN", $currentUser->getRoles())) {
            return    $this->redirectToRoute('attendance', ['id' => $currentUser->getId()]);
        }
        $userAttendance = $attendanceRepository->findBy(["user" => $user], ["createdAt" => "ASC"]);


        $form = $this->createForm(AttendanceType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Attendance attendance
             */
            $attendance = new Attendance;

            $attendance
                ->setAddedBy($this->getUser())
                ->setUpdatedAt(new DateTimeImmutable())
                ->setUser($user)
                ->setCreatedAt(DateTimeImmutable::createFromMutable($form->getData()["createdAt"]));
            $em->persist($attendance);
            $em->flush();

            return $this->render('attendance/index.html.twig', [
                'attendances' => $userAttendance,
                "form" => $form->createView(),
                "user" => $user

            ]);
        }

        return $this->render('attendance/index.html.twig', [
            'attendances' => $userAttendance,
            "form" => $form->createView(),
            "user" => $user

        ]);
    }

    /**
     * @Route("/profile/attendance/new", name="attendance_new")
     */
    public function new(Request $request, EntityManagerInterface $em, AttendanceRepository $attendanceRepository, UserRepository $userRepository): Response
    {
        date_default_timezone_set('Europe/Paris');
        /**
         * @var User $user
         */
        $user = $userRepository->findOneBy(['id' => $request->request->get('user')]);
        $currentUser =  $this->getUser();



        $date =  DateTimeImmutable::createFromMutable(new DateTime($request->request->get('date')));

        $userAttendance = $attendanceRepository->findBy(["user" => $user], ["createdAt" => "DESC"]);
        if (count($userAttendance) > 0) {
            $lastestAttendance = $userAttendance[0]->getCreatedAt();
            $delai = ($date->getTimestamp() - $lastestAttendance->getTimestamp());
            if (count($userAttendance) > 0) {
                if ($delai < 300) {
                    $this->addFlash('danger', message: "Temps minimum entre 2 emmargements 5 minutes, seulement $delai secondes se sont écoulées ! Cet émargement ne sera pas pris en compte.");

                    return new JsonResponse(["status" => 'error', 'attendance' => $delai . " secondes"]);
                }
            }
        }
        $attendance = new Attendance;
        $attendance
            ->setUser($user)
            ->setAddedBy($currentUser)
            ->setCreatedAt($date)
            ->setUpdatedAt(new DateTimeImmutable());

        $em->persist($attendance);
        $em->flush();

        $this->addFlash('success', message: $user->getLastname() . ' ' . $user->getFirstname() . ", votre émargement a été pris en compte  à " . $date->format("H:i"));
        return new JsonResponse(["status" => 'success', 'attendance' => $date]);
    }

    /**
     * @Route("/admin/attendance/delete/{id<\d+>}", name="attendance_delete")
     */
    public function delete(Attendance $attendance, EntityManagerInterface $em)
    {

        $user = $attendance->getUser();
        $em->remove($attendance);
        $em->flush();
        return $this->redirectToRoute('attendance', ['id' => $user->getId()]);
    }

    /**
     * @Route("admin/attendances/view", name="admin_attendance_view")
     */
    public function adminAttendanceView(AttendanceRepository $attendanceRepository, UserRepository $userRepository)
    {

        return $this->render('attendance/adminAttendancesView.html.twig', [
            "users" => array_filter($userRepository->findBy([], ["lastname" => "ASC"]), function ($user) {
                return in_array("ROLE_EMPLOYEE", $user->getRoles());
            }), "attendances" => $attendanceRepository->findAll(),

        ]);
    }

    /**
     * @Route("admin/getAttendances", name="admin_get_attendances")
     */
    public function getAttendances(Request $request, AttendanceRepository $attendanceRepository,)
    {
        $month = date_create($request->query->get('month'));
        $user = $request->query->get('user');;
        $attendances = $attendanceRepository->findByExampleField($month, $user);
        $createdAt = (array_map(function ($a) {
            return  $a->getCreatedAt();
        }, $attendances));
        $reponse = new JsonResponse($createdAt);


        return $reponse;
    }
}
