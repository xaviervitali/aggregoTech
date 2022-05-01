<?php

namespace App\Form;

use App\Entity\Appreciation;
use App\Entity\Level;
use PhpParser\Node\Stmt\Label;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppreciationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('level', EntityType::class, ["label" => false, "class" => Level::class, "choice_label" => "title", "attr" => ["class" => "form-select"]])
            ->add('comment', TextareaType::class, ["label" => false, "required" => false, "attr" => ["class" => "form-control", "placeholder" => "Commentaire eventuel"]])
            // ->add('skill')
            // ->add('statement')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appreciation::class,
        ]);
    }
}
