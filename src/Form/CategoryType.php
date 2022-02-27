<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Field;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;


class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('title', TextType::class, ['label' => 'Titre de la catégorie', 'attr' => [
            'placeholder' => 'Titre de la catégorie', "class" => 'form-control'
        ]])
        ->add('description', TextareaType::class, ['label' => 'Description de la catégorie', 'attr' => [
            'placeholder' => 'Description de la catégorie', 'rows' =>4, "class" => 'form-control'
        ]])
        ->add("fields", EntityType::class, [
            'class' => Field::class,
            'choice_label' => function ($field) {
                 return $field->getTitle();},
                 'expanded' => true,
                 'multiple' => true,
                 "label" => false,
                 'attr' => [
                    "class" => 'form-control'
                 ],
                 'by_reference' => false,
            ]);
          ;
       ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
