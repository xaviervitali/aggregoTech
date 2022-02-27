<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
        if ($user && in_array("ROLE_ADMIN", $user->getRoles())) {
            return $this->redirectToRoute('category_index');
        }
        // For example:
        if ($user && in_array("ROLE_EMPLOYEE", $user->getRoles())) {
            return $this->redirectToRoute('attendance', ['id' => $user->getId()]);
        }        
        if ($user && count($user->getRoles()) < 2) {
            return $this->redirectToRoute('notAvailable', ['id' => $user->getId()]);
        }
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        // throw new \Exception('Don\'t forget to activate logout in security.yaml');

        // $this->render('public/accueil.html.twig');
    }
}
