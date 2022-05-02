<?php



namespace App\Subscriber;



use App\Entity\AddressBook;

use App\Entity\AddressBookActivity;

use App\Entity\AddressBookContact;

use App\Entity\Attendance;

use App\Entity\Avatar;

use DateTimeImmutable;

use App\Entity\Field;

use App\Entity\Category;

use App\Entity\Collaboration;

use App\Entity\Contact;

use App\Entity\FileCategory;

use App\Entity\FileUpload;

use App\Entity\Survey;

use App\Entity\User;

use App\Form\AddressBookType;

use App\Repository\UserRepository;

use Doctrine\ORM\Events;

use Doctrine\Common\EventSubscriber;

use Symfony\Component\Security\Core\Security;

use Doctrine\Persistence\Event\LifecycleEventArgs;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Component\PasswordHasher\PasswordHasherInterface;



class CreateAndUpdateSubscriber implements EventSubscriber

{

    protected $security;





    public function __construct(Security $security, UserPasswordHasherInterface $passwordHasher,  UserRepository $userRepository)

    {

        $this->passwordHasher = $passwordHasher;

        $this->security = $security;

        $this->userRepository = $userRepository;

        date_default_timezone_set('Europe/Paris');
    }



    public function getSubscribedEvents()

    {

        return [

            Events::prePersist,

            Events::preUpdate,



        ];
    }

    public function preUpdate(LifecycleEventArgs $event)

    {

        $entity = $event->getObject();

        if (method_exists($entity, "getUpdatedAt")) {

            // if (!$entity instanceof User && !$entity instanceof AddressBook && !$entity instanceof AddressBookActivity && !$entity instanceof Collaboration) {

            $date = new DateTimeImmutable();

            $entity->setUpdatedAt($date);
        }
    }







    public function prePersist(LifecycleEventArgs $event)

    {

        $entity = $event->getObject();
        $date = new DateTimeImmutable();


        if (method_exists($entity, "setCreatedAt")) {

            // if (!$entity instanceof User && !$entity instanceof AddressBook && !$entity instanceof AddressBookActivity && !$entity instanceof Collaboration) {


            $entity->setCreatedAt($date);
        }


        if ($entity instanceof FileUpload  || $entity instanceof User) {

            $date = new DateTimeImmutable();

            if (!$entity instanceof FileUpload) {

                $entity->setCreatedAt($date);
            }


            if (!$entity instanceof User) {

                if (method_exists($entity, "setUpdatedAt")) {

                    // if (!$entity instanceof User && !$entity instanceof AddressBook && !$entity instanceof AddressBookActivity && !$entity instanceof Collaboration) {


                    $entity->setUpdatedAt($date);
                }
            } else {

                $plainPwd = $entity->getPassword();

                $hashedPwd = $this->passwordHasher->hashPassword(

                    $entity,

                    $plainPwd

                );

                $entity->setPassword($hashedPwd);
            }
        }
    }
}
