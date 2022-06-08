<?php

namespace App\Controller;

use App\Entity\Resume;
use App\Entity\User;
use App\Form\ResumeType;
use App\Repository\ResumeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResumeController extends AbstractController
{
    #[Route('/resume/{username}', name: 'resume')]
    public function index(User $user): Response
    {
        return $this->render('admin/resume/index.html.twig', ["resume" => $user->getResume()]);
    }

    /**

     * @Route("/profile/resume/new", name="resume_new")

     */

    public function new(Request $request,  EntityManagerInterface $em, ResumeRepository $resumeRepository): Response

    {

        $form = $this->createForm(ResumeType::class);
        $user = $this->getUser();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Resume $resume
             */
            $resume = $form->getData();

            $oldResume = $resumeRepository->findOneBy([
                "user" => $user
            ]);

            if ($oldResume) {
                try {
                    unlink("assets/resumes/" . $oldResume->getResumeFile());
                } catch (Exception $e) {
                    // echo 'Exception reçue : ',  $e->getMessage(), "\n";
                }
                $oldResume->setResumeFile("");
                $oldResume->setMotivation($resume->getMotivation());
                $oldResume->setUploadedFile($resume->getUploadedFile());
                $oldResume->setExtLink($resume->getExtLink());
                $em->persist($oldResume);
                $em->flush();
            } else {
                $resume->setUser($user);

                $em->persist($resume);
                $em->flush();
            }

            return $this->redirectToRoute("resume_new", ["form" => $form->createView(), "resume" => $user->getResume()]);
        }

        return $this->render("admin/resume/new.html.twig", [

            "form" => $form->createView(), "resume" => $user->getResume()
        ]);
    }
}
