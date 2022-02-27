<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Field;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, ['label' => 'Question', 'attr' => [
            'placeholder' => 'Ecrivez la question ici', "class" => 'form-control'
        ]])
  
            ->add("categories", EntityType::class, [
                'class' => Category::class,
      
                     'expanded' => true,
                     'multiple' => true,
                     "label" => false,
                     'attr' => [
                        "class" => 'form-control'
                    ]
                ]);
              ;
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Field::class,
        ]);
    }
}
