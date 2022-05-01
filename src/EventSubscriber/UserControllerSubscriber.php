<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Security;

class UserControllerSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }


    public function onKernelControllerArguments(ControllerArgumentsEvent $event)
    {
        // dd($this->security->getUser());
        if ($this->security->getUser()) {
            if (strstr($event->getRequest()->getPathInfo(), "profile") && (in_array("ROLE_EMPLOYEE", $this->security->getUser()->getRoles()))) {


                $event->setArguments(array_map(
                    function ($u) {
                        if ($u instanceof User) {
                            return  $u = $this->security->getUser();
                        } else {
                            return $u;
                        }
                    },
                    $event->getArguments()
                ));
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller_arguments' => 'onKernelControllerArguments',
        ];
    }
}
