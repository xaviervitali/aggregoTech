<?php

namespace App\Form;

use App\Entity\AddressBook;
use App\Entity\AddressBookActivity;
use App\Entity\AddressBookContact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companyName', TextType::class, ['label' => 'Nom de l\'organisme', 'attr' => [
                'placeholder' => 'Nom de l\'organisme', "class" => 'form-control my-2'
            ]])
            ->add('contacts', CollectionType::class, [
                'entry_type' => AddressBookContactType::class,
                'entry_options' => [
                    'attr' => ['class' => 'd-flex border p-2 my-2 justify-content-between'],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,

            ])
            ->add('website', TextType::class, ['label' => 'site web', 'attr' => [
                'placeholder' => 'site web', 'rows' => 4, "class" => 'form-control my-2 '
            ], "required" => false])
            ->add('address', TextType::class, ['label' => 'Adresse postale', 'attr' => [
                'placeholder' => 'Adresse postale', 'rows' => 4, "class" => 'form-control my-2'
            ], "required" => false])
            ->add('description', TextareaType::class, ['label' => 'Description de l\'organisme', 'attr' => [
                'placeholder' => 'Description de l\'organisme', 'rows' => 4, "class" => 'form-control my-2 '
            ]])
            ->add('addressBookActivities', EntityType::class, [
                'class' => AddressBookActivity::class,
                'choice_label' => function ($activity) {
                    return $activity->getName();
                },
                'expanded' => true,
                'multiple' => true,
                "label" => false,
                'attr' => [
                    "class" => ' my-2'
                ],
                'by_reference' => false,
                'label' => "Liste des activités"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddressBook::class,
        ]);
    }
}
