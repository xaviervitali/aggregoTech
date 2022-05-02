<?php



namespace App\Form;



use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Vich\UploaderBundle\Form\Type\VichFileType;



class AttendanceType extends AbstractType

{

    public function buildForm(FormBuilderInterface $builder, array $options): void

    {

        $builder

            // ->add('createdAt', DateTimeType::class, ['label'=>'Ajouter un emmargement', "date_format"=>'dd-MMM-yyyy-H-i',     'placeholder' => ['day' => 'Jour','month' => 'Mois', 'year'=>'Année', 

            // 'hour' => 'Heure', 'minute' => 'Minute', ], "attr"=>['class'=>'form-control']])
            ->add("submit", SubmitType::class, ['label' => "Emmarger", 'attr' => ["class" => "btn  btn-lg p-5 text-light", "style" => "background-color: #228822; "]]);
    }



    public function configureOptions(OptionsResolver $resolver): void

    {

        $resolver->setDefaults([

            // Configure your form options here

        ]);
    }
}
