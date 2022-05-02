<?php



namespace App\Controller;



use App\Entity\User;

use App\Form\FileUploadType;

use App\Form\UserType;

use App\Repository\UserRepository;

use DateTimeImmutable;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Component\Security\Core\Security;



class UserController extends AbstractController

{

    private $security;



    private  $avatar;



    public function __construct(Security $security)

    {

        // Avoid calling getUser() in the constructor: auth may not

        // be complete yet. Instead, store the entire Security object.

        $this->security = $security;
    }





    /**

     * @Route("/admin/user/add", name="user_add")

     */

    public function new(Request $request,  EntityManagerInterface $em): Response

    {



        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $user = $form->getData();

            $em->persist($user);

            $em->flush();



            return $this->redirectToRoute("user_index");
        }

        return $this->render("admin/user/new.html.twig", [

            "form" => $form->createView()

        ]);
    }





    /**

     * @Route("/profile/user/edit/{id<\d+>}", name="user_edit")

     */

    public function edit(Request $request,  EntityManagerInterface $em, User $user, UserRepository $userRepository): Response

    {

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);



        $this->avatar = !$this->avatar ? $user->getAvatar() : $this->avatar;



        if ($form->isSubmitted() && $form->isValid()) {

            /**

             * @var User $userTemp

             */

            $userTemp = $form->getData();



            $this->setAvatar($userTemp, $em);

            $em->persist($userTemp);

            $em->flush();





            return $this->redirectToRoute("user_view", ["id" => $user->getId()]);
        }



        return $this->render("admin/user/edit.html.twig", [

            "form" => $form->createView(), "user" => $user

        ]);
    }

    /**

     * @Route("/profile/user/{id<\d+>}", name="user_view")

     */

    public function view(Request $request,  User $user, EntityManagerInterface $em, UserPasswordHasherInterface $encoder): Response

    {

        if ($this->security->getUser() == $user || in_array("ROLE_ADMIN", $this->security->getUser()->getRoles())) {

            $form = $this->createForm(UserType::class, $user);



            $form = $this->createForm(FileUploadType::class);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                /** 

                 * @var FileUpload $task

                 */

                $task = $form->getData();

                $user = $this->getUser();

                $task->setUser($user);





                $em->persist($task);

                $em->flush();



                return  $this->render("admin/user/view.html.twig", [

                    'user' => $user, "form" => $form->createView()

                ]);
            }



            return $this->render("admin/user/view.html.twig", [

                'user' => $user, "form" => $form->createView()

            ]);
        }





        return $this->render("admin/user/view.html.twig", [

            'user' => $this->security->getUser()

        ]);
    }



    /**

     * @Route("/admin/users", name="user_index")

     */

    public function index(UserRepository $userRepository): Response

    {


        return $this->render('admin/user/index.html.twig', [

            'users' => $userRepository->findAll()
        ]);
    }







    /**

     * @Route("api", name="api")

     */

    public function getWord(): JsonResponse

    {





        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890-';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < 6; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return new JsonResponse($randomString);
    }



    /**

     * @Route("/admin/user/delete/{id<\d+>}", name="user_delete")

     */

    public function delete(User $user, EntityManagerInterface $em)

    {

        $em->remove($user);

        $em->flush();

        return $this->redirectToRoute('user_index');
    }



    /**

     * @Route("/admin/user/haveLeave/{id<\d+>}", name="user_leave")

     */

    public function leave(User $user, EntityManagerInterface $em)

    {

        // $em->remove($user);



        $user

            ->setLeaveAt(new DateTimeImmutable())

            ->setRoles([]);

        $em->flush();

        return $this->redirectToRoute('user_index');
    }



    /**

     * @Route("/admin/user/haveNotLeave/{id<\d+>}", name="user_not_leave")

     */

    public function notLeave(User $user, EntityManagerInterface $em)

    {

        // $em->remove($user);



        $user

            ->setLeaveAt(NULL)

            ->setRoles(["ROLE_EMPLOYEE"]);

        $em->flush();

        return $this->redirectToRoute('user_index');
    }



    /**

     * @Route("/{id<\d+>}", name="notAvailable")

     */

    public function notAvailable(User $user)

    {

        return $this->render('admin/user/notAvailable.html.twig', ["user" => $user]);
    }

    // SI ON VEUT CREER DES MINIATURES

    // CHARGER LE CONTENU DE L'IMAGE D'ORIGINE DANS LA MEMOIRE PHP

    // http://php.net/manual/fr/function.imagecreatefromjpeg.php

    // LARGEUR ET HAUTEUR ORIGINALE

    // RATIO = LARGEUR / HAUTEUR

    // RATIO > 1 => LARGEUR > HAUTEUR => PAYSAGE

    // RATIO < 1 => LARGEUR < HAUTEUR => PORTRAIT

    // LARGEUR => 1920 x HAUTEUR => 1080 (FULLHD)

    // miniature DOIT RENTRER DANS UN CARRE DE 800x800

    // LE PLUS GRAND COTE REMPLIT LE CARRE => 800

    // Lmini = 800

    // Hmini = HAUTEUR * Lmini / L => 1080 * 800 / 1920



    // http://php.net/manual/fr/function.imagesx.php

    // http://php.net/manual/fr/function.imagesy.php



    // CREER L'ESPACE MEMOIRE POUR L'IMAGE MINIATURE

    // http://php.net/manual/fr/function.imagecreatetruecolor.php

    // 800x800

    // ON GARDE LE RATIO ORIGINAL 

    // ET ON LE LIMITE DANS UN CARRE DE 800x800

    // SI PAYSAGE

    // Lmini = 800;

    // Hmini = HAUTEUR * Lmini / LARGEUR 

    // SI PORTRAIT

    // Hmini = 800

    // Lmini = LARGEUR * Hmini / HAUTEUR



    // CREER LA COPIE DANS LA MINIATURE

    // http://php.net/manual/fr/function.imagecopyresampled.php



    // SAUVEGARDER DANS UN FICHIER

    // http://php.net/manual/fr/function.imagejpeg.php



    function setAvatar(User $user, EntityManagerInterface $em,   $side = 300)

    {

        if ($user->getAvatar()) {



            if ($this->avatar && $this->avatar != $user->getAvatar()) {

                unlink("assets/img/user/" . $this->avatar);
            }



            $cheminSource = $user->getAvatar();



            $userName = $user->getUserIdentifier();

            // http://php.net/manual/fr/function.exif-imagetype.php

            $imgType = exif_imagetype($cheminSource);

            $ext = "";



            switch ($imgType) {

                case IMAGETYPE_JPEG:

                    $imgSrc     = \imagecreatefromjpeg($cheminSource);

                    $ext = "jpg";



                    break;

                case IMAGETYPE_PNG:

                    $imgSrc     = \imagecreatefrompng($cheminSource);

                    $ext = "png";



                    // IL FAUDRA COPIER LA TRANSPARENCE EN PLUS

                    break;

                case IMAGETYPE_GIF:

                    $imgSrc     = \imagecreatefromgif($cheminSource);

                    $ext = "gif";



                    // IL FAUDRA COPIER LA TRANSPARENCE EN PLUS

                    break;
            }



            $cheminThumbnail = "assets/img/user/$userName.$ext";



            // http://php.net/manual/fr/function.imagecreatefromjpeg.php





            // http://php.net/manual/fr/function.imagesx.php

            $largeurSrc = imagesx($imgSrc);

            // http://php.net/manual/fr/function.imagesy.php

            $hauteurSrc = imagesy($imgSrc);



            // SI L'IMAGE EST PLUS PETITE

            // ALORS ON NE CREE PAS DE MINIATURE

            // ...



            // PAYSAGE OU PORTRAIT

            if ($largeurSrc > $hauteurSrc) {

                // PAYSAGE

                // Lmini = 300;

                // Hmini = HAUTEUR * Lmini / LARGEUR

                $largeurThumbnail = $side;

                $hauteurThumbnail = $hauteurSrc * $largeurThumbnail / $largeurSrc;
            } else {

                // PORTRAIT

                $hauteurThumbnail = $side;

                $largeurThumbnail = $largeurSrc * $hauteurThumbnail / $hauteurSrc;
            }

            // CREER L'IMAGE THUMBNAIL VIDE

            // http://php.net/manual/fr/function.imagecreatetruecolor.php

            $imgThumbnail = imagecreatetruecolor($largeurThumbnail, $hauteurThumbnail);

            imagealphablending($imgThumbnail, false);

            imagesavealpha($imgThumbnail, true);



            // COPIE AVEC RE-ECHANTILLONAGE (meilleure qualité...)

            // http://php.net/manual/fr/function.imagecopyresampled.php

            imagecopyresampled(

                $imgThumbnail,

                $imgSrc,

                0,

                0,

                0,

                0,

                $largeurThumbnail,

                $hauteurThumbnail,

                $largeurSrc,

                $hauteurSrc

            );



            // SAUVEGARDER DANS UN FICHIER

            switch ($imgType) {

                case IMAGETYPE_JPEG:

                    imagejpeg($imgThumbnail, $cheminThumbnail);

                    break;



                case IMAGETYPE_PNG:

                    imagepng($imgThumbnail, $cheminThumbnail);

                    break;



                case IMAGETYPE_GIF:

                    imagegif($imgThumbnail, $cheminThumbnail);

                    break;
            }

            $user->setAvatar("$userName.$ext");



            // http://php.net/manual/fr/function.imagejpeg.php

        }
    }
}
