<?php

namespace App\Form;

use App\Entity\AddressBook;
use App\Entity\AddressBookContact;
use App\Entity\Survey;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addressBook', EntityType::class, [
                'class' => AddressBook::class,
                "label" => false,
                'choice_label' => 'companyname',
                "attr" => [

                    "class" => "form-control d-none"
                ]

            ])
            ->add('contact', EntityType::class, [
                'class' => AddressBookContact::class,
                "label" => "Contact",
                'choice_label' => 'name',
                "attr" => [

                    "class" => "form-select"
                ]

            ])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                "label" => "Date ",
                'input'  => 'datetime_immutable',
                "attr" => [
                    "class" => "form-control"
                ]

            ])
            ->add('way', ChoiceType::class, [
                "label" => "Moyen",
                "attr" => [
                    "class" => "form-select",
                    "value" => "0"
                ],
                'choices'  => [
                    'Présentiel' => 'Présentiel',
                    'Appel Téléphonique' => 'Appel Téléphonique',
                    'Visio' => "Visio",
                    'Mail' => "Mail",
                    'Courrier Postal' => "Courrier Postal",
                ],
            ])
            ->add('comments', TextareaType::class, [
                "label" => "Commentaires",
                "attr" => [
                    "placeholder" => "Commentaires",
                    "class" => "form-control"
                ]

            ])
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Survey::class,
        ]);
    }
}
