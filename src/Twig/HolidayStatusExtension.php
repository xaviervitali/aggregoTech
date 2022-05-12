<?php



namespace App\Twig;



use App\Entity\User;
use phpDocumentor\Reflection\Types\Boolean;
use Twig\Extension\AbstractExtension;

use Twig\TwigFilter;



class HolidayStatusExtension extends AbstractExtension

{

    public function getFilters()

    {

        return [

            new TwigFilter('holidayStatus', [$this, 'holidayStatus']),

        ];
    }



    public function holidayStatus(?Boolean $status)

    {

        $statusObj = [
            null => '<i class="fa-solid fa-circle-pause" style="color: orange;"></i>',
            true => '<i class="fa-solid fa-circle-check" style="color: green;"></i>',
            false => '<i class="fa-solid fa-circle-xmark" style="color: red;"></i>'
        ];

        return $statusObj[$status];
    }
}
