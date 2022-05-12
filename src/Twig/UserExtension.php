<?php



namespace App\Twig;



use App\Entity\User;
use App\Repository\UserRepository;
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
            new TwigFilter('userListPerRole', [$this, 'userListPerRole']),

        ];
    }

    public function userListPerRole($users)
    {

        $userList = [];
        $userList[] = array_filter($users, function ($e) {
            return count($e->getRoles()) == 1;
        });


        $users =  array_filter($users, function ($e) {
            return count($e->getRoles()) > 1;
        });

        $roles = array_unique(array_merge(...array_map(function ($u) {
            $ROLE_USER = array_search("ROLE_USER", $u->getRoles());
            return (array_slice($u->getRoles(), $ROLE_USER - 1, 1));
        }, $users)));


        foreach ($roles as $role) {
            $userList[] =  array_filter($users, function ($user) use ($role) {
                return in_array($role, $user->getRoles());
            });
        }
        return ($userList);
    }


    public function roleRenamer($user)

    {

        $roles = $user->getRoles();



        if (count($roles)  > 1) {
            switch ($roles[0]) {


                case 'ROLE_ADMIN':

                    return    'Administrateur.rice';

                case "ROLE_EMPLOYEE":

                    return "Salarié.e";

                case "ROLE_RH":

                    return "R/H";
                default:

                    return "Membre";
            }
        } else {
            return "Ne fais plus partie de l'association";
        }
    }



    public function roleFilter($users,  $role)

    {

        return array_filter($users, function (User $u) use ($role) {

            return in_array($role, $u->getRoles());
        });
    }



    public function avatar(?User $user)

    {


        if ($user->getAvatar()) {



            $avatar = $user->getAvatar();



            return " <img src='/assets/img/user/$avatar' alt='avatar' class='logocarte'>";
        }



        return " <img src='/assets/img/user/default.jpg' alt='Pas d avatar' class='logocarte'>";
    }
}
