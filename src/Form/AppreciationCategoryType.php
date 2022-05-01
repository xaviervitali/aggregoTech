<?php

namespace App\Form;

use App\Entity\AppreciationCategory;
use App\Entity\Skill;
use App\Repository\SkillRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppreciationCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ["label" => false, "attr" => [
                'placeholder' => 'Nom de la nouvelle Catégorie', "class" => 'form-control'
            ]])
            ->add('skills', CollectionType::class, [    // each entry in the array will be an "email" field
                'entry_type' => SkillType::class,
                // these options are passed to each "email" type
                'entry_options' => [
                    'attr' => ['class' => 'tilte'],

                ],
                "allow_add" => true,
                "allow_delete" => true,
                "label" => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AppreciationCategory::class,
        ]);
    }
}
