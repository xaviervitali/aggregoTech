<?php

namespace App\Form;

use App\Entity\PostIt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostItType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            // ->add('createdAt')
            ->add('content', TextareaType::class, [
                "attr" => [
                    "class" => "form-control ",
                    "placeholder" => "Pense Bête",
                    "style" => "
                 
                        "

                ],
                "label" => false
            ])
            ->add('category', ChoiceType::class, [
                "label" => "Catégorie",
                "choices" => ["Émargement" => "attendance", "Info  générale" => "info", "Notification au salarié" => "remember"],
                "attr" => [
                    "class" => "form-control my-2 bg-secondary text-white",

                ],
                "expanded" => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PostIt::class,
        ]);
    }
}
