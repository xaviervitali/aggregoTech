<?php

namespace App\Twig;

use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UserExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('role', [$this, 'roleRenamer']),
            new TwigFilter('roleFilter', [$this, 'roleFilter']),
            new TwigFilter('avatar', [$this, 'avatar']),
        ];
    }

    public function roleRenamer(User $user)
    {

        $roles = $user->getRoles();
        $gender = $user->getGender();
        $posRoleUser =  array_search("ROLE_USER", $roles);
        unset($roles[$posRoleUser]);

        switch ($roles[0] . $gender) {
            case   'ROLE_ADMINMme':
                return "Adminitratrice";
            case 'ROLE_ADMINM':
                return    'Administrateur';
            case 'ROLE_ADMINN/A':
                return    'Administrateur';
            case "ROLE_EMPLOYEEMme":
                return "Salariée";
            case "ROLE_EMPLOYEEM":
                return "Salarié";
            case "ROLE_EMPLOYEEN/A":
                return "Salarié";
            default:
                return "Membre";
        }
    }

    public function roleFilter($users,  $role)
    {
        return array_filter($users, function (User $u) use ($role) {
            return in_array($role, $u->getRoles());
        });
    }

    public function avatar(User $user)
    {
        if ($user->getAvatar()) {

            $avatar = $user->getAvatar();

            return " <img src='/assets/img/user/$avatar' alt='avatar' class='logocarte'>";
        }

        return " <img src='/assets/img/user/default.jpg' alt='Pas d avatar' class='logocarte'>";
    }
}
