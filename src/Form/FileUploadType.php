<?php

namespace App\Form;

use App\Entity\FileCategory;
use App\Entity\FileUpload;
use App\Repository\FileCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class FileUploadType extends AbstractType

{
    private FileCategoryRepository $repo;

    public function __construct( FileCategoryRepository $repo)
    {
        $this->repo = $repo;
    }
 
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                ["label" => "Titre du fichier",  "attr" => ["placeholder" => "Titre du fichier", "class" => "form-control"]]
            )
            ->add('description',  TextType::class, ["required" => false, "label" => "Description du fichier",  "attr" => ["placeholder" => "Description du fichier", "class" => "form-control"]])
            ->add('uploadedFile', VichFileType::class, ["required" => false,  "attr" => ["class" => "form-control-file my-2", "accept" => "image/*, video/*,  application/*"], "label" => "Fichier"])
            ->add("fileCategory", EntityType::class, [
                'class' => FileCategory::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FileUpload::class,
        ]);
    }
}
