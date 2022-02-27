<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('lastname', TextType::class,   ["label" => "Nom",  "attr" => ["placeholder" => "Nom", "class" => "form-control  zonetext"]])
            ->add('firstname', TextType::class,   ["label" => "Prénom",  "attr" => ["placeholder" => "Prénom", "class" => "form-control zonetext"]])
            ->add('email', EmailType::class,   ["label" => "Email",  "attr" => ["placeholder" => "Email", "class" => "form-control zonetext"]])
            ->add('phone', TelType::class,  ["label" => "Numéro de téléphone",  "attr" => ["placeholder" => "Numéro de téléphone", "class" => "form-control zonetext", "pattern" => "[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}"]])
            ->add('address', 
            TextType::class,  
             ["label" => "Adresse Postale",  "attr" => ["placeholder" => "Adresse Postale", "class" => "form-control adr", "autocomplete"=>"off", "list"=>"address"]]
             )
            ->add('firmName', TextType::class,   ["label" => "Nom de l'organisme",  "attr" => ["placeholder" => "Nom de l'organisme", "class" => "form-control d-none"], "required" => false])
            ->add('message', TextareaType::class,   ["label" => "Message",  "attr" => ["placeholder" => "Message", "class" => "form-control ", "style"=>"height: 100px"]])
            ->add('request', ChoiceType::class,  [
                'label' => "Type de demande", 'choices'  => [
                    'Un Partenariat' => "partenariat",
                    "Une Prestation" => "prestation",
                    'Des Informations' => "informations",
                    'Un Devis' => "devis",
                ], 
                "attr"=>["class"=>"form-control"],
                'preferred_choices' => ['devis', 'arr'], 
            ])
            ->add('entity', ChoiceType::class,  ['label' => "Vous êtes", 'choices'  => [
                'Un particulier' => 'particulier',
                'Une organisation' => 'organisation',
                'Une société' => 'société',
            ],  'preferred_choices' => ['particulier', 'arr'], "attr"=>["class"=>" form-control"]])
            ->add('captcha', ReCaptchaType::class, [
                'type' => 'invisible',
                'attr' => ["data-toggle" => 'recaptcha'],
                'mapped' => false,
                'required' => true,

            ])
            ->add('agreements', CheckboxType::class , [
                'label'    => false,
                'required' => true,
                'mapped' => false,     
                'attr'=>['class'=>'form-check-input']           
            ] );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
