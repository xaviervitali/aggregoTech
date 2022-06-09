<?php

namespace App\Naming;

use Symfony\Component\Security\Core\Security;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;

class UsernameFileNamer implements NamerInterface
{
    private Security $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function name($object, PropertyMapping $mapping): string
    {
        $file = $mapping->getFile($object);
        $originalName = $file->getClientOriginalName();
        $extension = \strtolower(\pathinfo($originalName, \PATHINFO_EXTENSION));


        return  $this->security->getUser()->getUserIdentifier() . "." . $extension;
    }
}
