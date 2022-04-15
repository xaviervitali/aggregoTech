<?php

namespace App\Form;

use App\Entity\AddressBookContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressBookContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => false, 'attr' => [
                'placeholder' => 'Nom/Prénom', "class" => 'col-auto mx-1'
            ]])
            ->add('email', EmailType::class, ['label' => false, 'attr' => [
                'placeholder' => 'Adresse Email', "class" => 'col-auto mx-1'
            ], "required" => false])
            ->add('phone', TextType::class, ['label' => false, 'attr' => [
                'placeholder' => 'N° de Téléphone', "class" => 'col-auto mx-1'
            ], "required" => false])
            ->add('role', TextType::class, ['label' => false, 'attr' => [
                'placeholder' => 'Rôle dans l\'entreprise', "class" => 'col-auto mx-1'
            ], "required" => false])
            // ->add('addressBook')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddressBookContact::class,
        ]);
    }
}
