<?php

namespace App\Twig;

use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CanvasExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('canvas', [$this, 'canvas']),
        ];
    }

    public function canvas($path)
    {

        return ;
    }
}
