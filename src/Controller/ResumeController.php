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
    public function show(User $user): Response
    {
        return $this->render('admin/resume/show.html.twig', ["resume" => $user->getResume()]);
    }

    /**
     * @Route("/profile/resume/new", name="resume_new")
     */

    public function new(Request $request,  EntityManagerInterface $em): Response

    {

        $form = $this->createForm(ResumeType::class);
        $user = $this->getUser();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Resume $resume
             */
            $resume = $form->getData();
            $resume->setUser($user);
            $em->persist($resume);
            $em->flush();

            return $this->redirectToRoute("user_resume");
        }

        return $this->render("admin/resume/new.html.twig", [

            "form" => $form->createView()
        ]);
    }



    /**
     * @Route("/profile/resume/edit", name="resume_edit")
     */

    public function edit(Request $request,  EntityManagerInterface $em, ResumeRepository $resumeRepository): Response

    {

        $user = $this->getUser();
        $form = $this->createForm(ResumeType::class, $user->getResume());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var Resume $resume
             */
            $resume = $form->getData();
            $oldResume = $resumeRepository->findOneBy([
                "user" => $user
            ]);

            if ($resume->getUploadedFile()) {
                try {
                    unlink("assets/resumes/" . $oldResume->getResumeFile());
                } catch (Exception $e) {
                    // echo 'Exception reçue : ',  $e->getMessage(), "\n";
                }
                $oldResume->setResumeFile("");
                $oldResume->setUploadedFile($resume->getUploadedFile());
            };
            $oldResume->setMotivation($resume->getMotivation());
            $oldResume->setExtLink($resume->getExtLink());
            $em->persist($oldResume);
            $em->flush();

            return $this->redirectToRoute("user_resume");
        }

        return $this->render("admin/resume/new.html.twig", [

            "form" => $form->createView()
        ]);
    }

    #[Route('/profile/resume', name: 'user_resume')]
    public function index(): Response
    {
        return $this->render('admin/resume/index.html.twig', ["resume" => $this->getUser()->getResume()]);
    }

    #[Route('profile/resume/{id<d+>}', name: 'resume_delete')]
    public function delete(Resume $resume,  EntityManagerInterface $entityManager): Response
    {
        if ($resume->getUser() == $this->getUser()) {
            $entityManager->remove($resume);
            $entityManager->flush();
            return $this->redirectToRoute('user_resume', [], Response::HTTP_SEE_OTHER);
        }
    }
}
