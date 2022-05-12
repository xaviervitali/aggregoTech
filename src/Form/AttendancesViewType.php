<?php

namespace App\Form;

use App\Entity\Attendance;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttendancesViewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add("createdAt", DateTimeType::class,  [
                'label' => 'Ajouter un emmargement',
                "widget" => "single_text",
                // "mapped" => false,
                "attr" => ["class" => "form-control"]


            ]);

        $builder->get('createdAt')
            ->addModelTransformer(new CallbackTransformer(
                function ($createdAt) {
                    // transform the array to a string
                    // return implode(', ', $tagsAsArray);
                    return $createdAt;
                },
                function ($createdAt) {
                    // transform the string back to an array
                    return DateTimeImmutable::createFromMutable($createdAt);
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Attendance::class
        ]);
    }
}
