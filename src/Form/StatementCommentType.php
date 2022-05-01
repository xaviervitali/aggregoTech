<?php

namespace App\Form;

use App\Entity\StatementComment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatementCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comment', TextareaType::class, ["label" => false, "attr" => ["placeholder" => "Votre Commentaire", "class" => "form-control", "rows" => "5"]])
            // ->add('createdAt')
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StatementComment::class,
        ]);
    }
}
