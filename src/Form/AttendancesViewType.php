<?php

namespace App\Form;

use App\Entity\Attendance;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttendancesViewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('user', EntityType::class, [
                "class" => User::class,
                "choice_label" => 'username',
                'query_builder' => function (EntityRepository $er) {
                    $roles = ["ROLE_EMPLOYEE"];
                    return
                        $er->createQueryBuilder('u')
                        ->orderBy('u.username', 'ASC')
                        ->andWhere("u.roles = :roles")
                        ->setParameter('roles', $roles);
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attendance::class
        ]);
    }
}
