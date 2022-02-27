<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\Category;
use App\Entity\Field;
use App\Entity\Survey;
use App\Form\EventListener\AddNameFieldSubscriber;
use App\Repository\CategoryRepository;
use Faker\Core\File;
use PHPUnit\Framework\Reorderable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface as FormFormInterface;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      

        $builder->add("categories", EntityType::class, [
                            'class' => Category::class,
                            'choice_label' => function ($field) {
                                return $field->getTitle();},
                            'label' => "Liste des catégories",
                            "placeholder" => "Veuillez selectionner une catégorie",
                            'attr' => [
                                "class" => 'form-control'
                            ], 
                            // 'expanded'=>true,
                            'mapped'=>false
                ])
                // ->add('answer')
            
                ;
     ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Survey::class,
            "allow_extra_fields" => true,
        ]);  

    }
}
