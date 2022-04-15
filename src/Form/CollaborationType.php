<?php

namespace App\Form;

use App\Entity\Collaboration;
use App\Entity\CollaborationChoice;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CollaborationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ["label" => false, "attr" => ["class" => "form-control my-2", "placeholder" => "Nom"]])
            ->add('url', TextType::class, ["label" => false, "attr" => ["class" => "form-control my-2", "placeholder" => "Page Web"]])
            ->add(
                'imageFile',
                VichFileType::class,
                [
                    "label" => "Logo du partenaire / financeur", "attr" => ["class" => "form-control my-2", "style" => "display:none;"],
                    'required' => false,
                    'allow_delete' => false,
                    "download_label" => "Télécharger le logo actuel"

                ]
            )

            ->add('collaborationChoice', EntityType::class, [
                "class" => CollaborationChoice::class,
                'choice_label' => 'title',
                "label" => false,
                "attr" => ["class" => "form-select my-2"]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Collaboration::class,
        ]);
    }
}
