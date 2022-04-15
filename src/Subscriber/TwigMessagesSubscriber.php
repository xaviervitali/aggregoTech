<?php

namespace App\Subscriber;

use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class TwigMessagesSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Twig\Environment
     */
    private $twig;

    private $contactRepository;

    public function __construct(Environment $twig, ContactRepository $contactRepository)
    {
        $this->twig    = $twig;
        $this->contactRepository    = $contactRepository;
    }

    public function injectGlobalVariables()
    {
        $this->twig->addGlobal("messages", count($this->contactRepository->findAll()));
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER =>  'injectGlobalVariables'];
    }
}
