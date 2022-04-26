<?php



namespace App\Twig;



use App\Entity\User;

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



    public function holidayStatus(String $status)

    {

        $statusObj = [
            "n/a" => '<i class="fa-solid fa-circle-pause" style="color: orange;"></i>',
            "ok" => '<i class="fa-solid fa-circle-check" style="color: green;"></i>',
            "ko" => '<i class="fa-solid fa-circle-xmark" style="color: red;"></i>'
        ];

        return $statusObj[$status];
    }
}
