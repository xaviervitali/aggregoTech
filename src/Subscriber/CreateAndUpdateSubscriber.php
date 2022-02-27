<?php

namespace App\Subscriber;

use App\Entity\Attendance;
use App\Entity\Avatar;
use DateTimeImmutable;
use App\Entity\Field;
use App\Entity\Category;
use App\Entity\Contact;
use App\Entity\FileCategory;
use App\Entity\FileUpload;
use App\Entity\Survey;
use App\Entity\User;
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
        
        if (!$entity instanceof User && !$entity instanceof Avatar) {
            $date = new DateTimeImmutable();
            $entity->setUpdatedAt($date);
        } 

    }



    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getObject();
        // if($entity instanceof Avatar){
        //     return;
        // }


        $date = new DateTimeImmutable();

        if ($entity instanceof Attendance ||  $entity instanceof FileCategory ) {
            return;
        }
        if (!$entity instanceof FileUpload ) {

            $entity->setCreatedAt($date);
        }

if($entity instanceof Contact){
    return;
}
     
        
        if (!$entity instanceof User)  {
            $entity->setUpdatedAt($date);
        } else {
            $plainPwd = $entity->getPassword();

            $hashedPwd = $this->passwordHasher->hashPassword(
                $entity,
                $plainPwd
            );
            $entity->setPassword($hashedPwd)
            ;
        }
    }


}
