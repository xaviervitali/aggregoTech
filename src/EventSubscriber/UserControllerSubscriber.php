<?php

namespace App\EventSubscriber;

use App\Controller\AddressBookController;
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
    private $user;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }


    public function onKernelRequest($event)
    {
    }

    public function onKernelController(ControllerEvent $event)
    {
        // ...
        // dd($event);
        // the controller can be changed to any PHP callable
        // $event->setController($myCustomController);
    }

    public function onKernelControllerArguments(ControllerArgumentsEvent $event)
    {
        // $controller = $event->getController();
        // $this->user = $this->security->getUser();

        // $newArguments = [];
        // foreach ($event->getArguments() as $argument) {
        //     if ($argument instanceof User) {
        //         $newArguments[] = $this->user;
        //     } else {
        //         $newArguments[] = $argument;
        //     }
        // }

        // $requestedUser = $event->getRequest()->attributes->get("id");

        // $event->getRequest()->attributes->set("id", $this->user->getId());
        // $event->setController($controller);
        // $event->setArguments($newArguments);

        // dd($event->getRequest());

        // dd($event->setArguments($event->getArguments()));
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller_arguments' => 'onKernelControllerArguments',
            "kernel.request" => "OnKernelRequest",
            "kernel.controller" => "OnKernelController"
        ];
    }

    private function substituteUser($arguments)
    {
    }
}
