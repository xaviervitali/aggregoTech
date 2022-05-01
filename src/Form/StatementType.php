<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Statement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder->add('appreciations', CollectionType::class, [
            'entry_type' => AppreciationType::class,
            "by_reference" => false,
            "allow_add" => true,
            "label" => false
        ])
            ->add("categories", CollectionType::class, [
                "entry_type" => AppreciationCategoryType::class, "mapped" => false,
                "label" => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Statement::class,
        ]);
    }
}
