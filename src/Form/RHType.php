<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RHType extends AbstractType
{
    public AuthorizationCheckerInterface $checker;
    public UserRepository $userRepository;
    public function __construct(AuthorizationCheckerInterface $checker, UserRepository $userRepository)

    {
        $this->checker = $checker;
        $this->userRepository = $userRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('users', EntityType::class, [
            'class' => User::class,
            'choice_label' => function ($user) {
                return $user->getLastname() . " " . $user->getFirstname();
            },
            'placeholder' => 'Veuillez sélectionner un salarié',
            "choices" => $this->userRepository->findBy([], ["lastname" => "ASC"]),
            'group_by' => function ($choice) {

                if (in_array("ROLE_EMPLOYEE", $choice->getRoles())) {
                    return 'Salariés en Insertion';
                } else  if (in_array("ROLE_ADMIN", $choice->getRoles())) {
                    return "Administrateurs";
                } else if (in_array("ROLE_RH", $choice->getRoles())) {
                    return "RHs";
                } else {
                    return "Anciens salariés";
                }
            },
            "attr" => [
                "class" => "form-select"
            ],
            "label" => false,
            "mapped" => false,
            // 'placeholder' => 'Liste des Salariés',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
