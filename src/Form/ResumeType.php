<?php

namespace App\Form;

use App\Entity\Resume;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ResumeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $fileExt = implode(",", ["image/jpeg", "image/gif", "image/png", "video/mp4", "video/quicktime", "video/avi", "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.oasis.opendocument.text", "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation", "text/plain"]);
        $builder
            ->add('motivation', TextareaType::class, ["label" => false, "attr" => [
                "placeholder" => "Votre motivation !!!",
                "class" => "form-control tinymce",
                "rows" => "20"
            ]])
            ->add("uploadedFile",  VichFileType::class, [
                'asset_helper' => true,
                'required' => false,
                'label' => "Votre CV",
                "attr" => ["placeholder" => "Votre Motivation !!!", "class" => "form-control ", "accept" => $fileExt]

            ])
            ->add(
                'extLink',
                UrlType::class,
                [
                    'label' => false,
                    'required' => false,

                    "attr" => ["placeholder" => "lien externe (facultatif)", "class" => "form-control "]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Resume::class,
        ]);
    }
}
