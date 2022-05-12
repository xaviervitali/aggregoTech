<?php

namespace App\Form;

use App\Entity\HolidayReason;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HolidayReasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ["label" => false, "attr" => ["placeholder" => "Nom du motif (Congés Payés, Congés Sans Solde ...)", "class" => "form-control"]])
            ->add('comment', TextType::class, ["label" => false, "attr" => ["placeholder" => "Descriptif", "class" => "form-control"]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HolidayReason::class,
        ]);
    }
}
