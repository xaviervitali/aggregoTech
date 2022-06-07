<?php



namespace App\Controller;



use App\Response\AsyncResponse;

use FilesystemIterator;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

use Psr\Log\LoggerInterface;

use RecursiveDirectoryIterator;

use RecursiveIteratorIterator;

use Symfony\Component\HttpClient\Response\AsyncResponse as ResponseAsyncResponse;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class SecurityController extends AbstractController

{



    public  $files = [];

    public  $filesCount = 0;

    /**

     * @Route("/login", name="app_login")

     */

    public function login(AuthenticationUtils $authenticationUtils): Response

    {

        $user = $this->getUser();

        if ($user && in_array("ROLE_ADMIN", $user->getRoles())) {

            return $this->redirectToRoute('user_index');
        }

        if ($user && in_array("ROLE_RH", $user->getRoles())) {

            return $this->redirectToRoute('admin_rh');
        }
        // For example:

        if ($user && in_array("ROLE_EMPLOYEE", $user->getRoles())) {

            return $this->redirectToRoute('attendance');
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



    /**

     * @Route("/admin/list_cache_files", name="list_cache_files")

     * 

     */

    public function listCacheFiles()

    {

        return $this->render('security/clear.html.twig', ['files' => $this->listFiles()]);
    }



    /**

     * @Route("/admin/clear_cache_api", name="clear_cache_api")

     * 

     */

    public function clearCacheApi()

    {



        foreach ($this->listFiles() as $file) {

            $file->isDir() ?  rmdir($file) : unlink($file);
        }

        return $this->redirectToRoute("list_cache_files");

        // return new JsonResponse(["cacheClear" => "ok", "cleared" => $nbFiles - $this->filesCount]);

    }



    public function listFiles()

    {

        $files = [];

        $dirs = ["../var/cache/dev/twig", "../var/cache/prod/twig"];

        foreach ($dirs as $dir) {

            if (is_dir($dir)) {

                $di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
            }
        }

        $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($ri as $file) {

            array_push($files, $file);
        }



        return $files;
    }
}
