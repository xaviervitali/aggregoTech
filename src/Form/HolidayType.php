<?php

namespace App\Form;

use App\Entity\Holiday;
use App\Entity\HolidayReason;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HolidayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'holidayReason',
                EntityType::class,
                [
                    "class" => HolidayReason::class,
                    "choice_label" => "name",
                    "label" => "Type de congés",
                    "attr" =>
                    ["class" => "form-select"],
                    // 'expanded' => true,
                ]


            )
            ->add(
                'startDate',
                DateType::class,
                [
                    "label" => "Du",

                    "widget" => "single_text",

                ]
            )
            ->add('endDate', DateType::class, [
                'label' => 'Fin',
                "widget" => "single_text",


            ])
            ->add('restartAt', DateType::class, [
                'label' => 'Reprise',
                "widget" => "single_text",


            ])
            ->add(
                'days',
                IntegerType::class,
                [
                    "label" => "Soit en jour.s",
                    "attr" =>
                    ["class" => "form-control", "placeholder" => "Nombre de jours"]
                ]
            )
            ->add("signature", CheckboxType::class, [
                'label'    => 'Je signe ma demande',
                'required' => true,
                "mapped" => false,
            ])
            ->add('comment', TextType::class, ["label" => "Plus d'info",  "attr" => ["placeholder" => "Plus d'info", "class" => "form-control"], "required" => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Holiday::class,
        ]);
    }
}
