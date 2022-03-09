<?php

namespace App\Controller;

use App\Entity\Signature;
use App\Entity\User;
use App\Form\EditUserType;
use App\Form\FileUploadType;
use App\Form\UserType;
use App\Repository\SignatureRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Provider\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\SignalRegistry\SignalRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserController extends AbstractController
{
    private $security;

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
        return $this->render("user/new.html.twig", [
            "form" => $form->createView()
        ]);
    }


       /**
     * @Route("/profile/user/edit/{id<\d+>}", name="user_edit")
     */
    public function edit(Request $request,  EntityManagerInterface $em,User $user ): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $em->persist($user);
            $em->flush();


            return $this->redirectToRoute("user_view", ["id"=>$user->getId()]);
        }

        return $this->render("user/edit.html.twig", [
            "form" => $form->createView(), "user"=>$user
        ]);
    }
    /**
     * @Route("/profile/user/{id<\d+>}", name="user_view")
     */
    public function view(Request $request,  User $user, EntityManagerInterface $em, UserPasswordHasherInterface $encoder): Response
    {
        if($this->security->getUser() == $user || in_array("ROLE_ADMIN", $this->security->getUser()->getRoles())){        $form = $this->createForm(UserType::class, $user);
       
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
    
                return  $this->render("user/view.html.twig", [
                    'user' => $user, "form"=>$form->createView()
                   ]);
        }

        return $this->render("user/view.html.twig", [
         'user' => $user, "form"=>$form->createView()
        ]);
    }


        return $this->render("user/view.html.twig", [
        'user' => $this->security->getUser()
        ]);
    }

    /**
     * @Route("/admin/users", name="user_index")
     */
    public function index(UserRepository $userRepository): Response
    {
        $admins = array_filter( $userRepository->findBy([], ["lastname" => "ASC"]), function($user){
            /**
             * @var User $user
             */
            return $user->haveRole("ROLE_ADMIN");
        });

        $employees =  array_filter( $userRepository->findBy([], ["lastname" => "ASC"]), function($user){
            /**
             * @var User $user
             */
            return $user->haveRole("ROLE_EMPLOYEE") && $user->getLeaveAt() == NULL;
        });

        $haveLeave =  array_filter( $userRepository->findBy([], ["leaveAt" => "DESC"]), function($user){
            /**
             * @var User $user
             */
            return $user->getLeaveAt() != NULL;
        });
  
        return $this->render('user/index.html.twig', [
            'admins' => $admins,  'employees' => $employees,'haveLeave' => $haveLeave,
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
        return $this->render('user/notAvailable.html.twig', ["user"=>$user]);

    }
    // /**
    //  * @Route("/profile/user/signature", name="signature_add", methods={"POST"})
    //  */
    // public function signatureAdd(EntityManagerInterface $em, Request $request, SignatureRepository $signatureRepository) :JsonResponse
    // {

    //     /**
    //      * @var User $user
    //      */
    //     $user = $this->security->getUser();
    //     $file = $request->request->get('signature');
    //     if ($file) {
         

    //         $oldSignature = $signatureRepository->findOneBy(['user' => $user]);
    //         if ($oldSignature) {
    //             $signature = $oldSignature;
    //             if(file_exists("assets/img/user/".$oldSignature->getImageName()))
    //          {   unlink("assets/img/user/".$oldSignature->getImageName());}
    //             $em->remove($signature);
    //             $em->flush();
    //         }

    //         $file = str_replace('data:image/png;base64,', '', $file);
    //         $file = str_replace(' ', '+', $file);
    //         $fileData = base64_decode($file);
    //         $fileName = $user->getUserIdentifier() . ".png";
    //         file_put_contents("assets/img/user/signature".$fileName, $fileData);
            
    //         $signature->setImageName($fileName);
    //         $signature->setUser($user);
    //         $em->persist($signature);
    //         $em->flush();
    //         return new JsonResponse(['status'=>'success', 'filename'=>$fileName]);
    //     }
    //     return new JsonResponse(['status'=>'error']);

    // }
}
