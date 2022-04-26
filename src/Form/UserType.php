<?php



namespace App\Form;



use App\Entity\User;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\CallbackTransformer;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\FormEvents;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Security;

use Vich\UploaderBundle\Form\Type\VichFileType;

use Vich\UploaderBundle\Form\Type\VichImageType;

use Symfony\Component\Validator\Constraints as Assert;



class UserType extends AbstractType

{

    public function __construct(Security $security)

    {

        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void

    {

        $builder

            ->add('firstname', TextType::class, ["label" => "Prénom", 'attr' => [

                'class' => 'form-control ',

                "placeholder" => "Prénom",

            ]])

            ->add('lastname', TextType::class, ["label" => "Nom", 'attr' => [

                'class' => 'form-control',

                "placeholder" => "Nom de famille",

            ]])

            ->add('gender', ChoiceType::class, [

                'attr' => ['class' => 'form-control '],

                'choices' => [

                    'Mme' => "Mme",

                    'M' => "M",

                    'N/A' => "N/A"

                ],

                "label" => "Genre"





            ])

            ->add('roles', ChoiceType::class, [

                'attr' => ['class' => 'form-control'],

                'required' => true,

                'multiple' => false,

                'expanded' => false,

                'choices' => [

                    'Salarié' => "ROLE_EMPLOYEE",
                    'Administrateur' => "ROLE_ADMIN",
                    'RH' => "ROLE_RH",

                ],

                "label" => "Attribution",



            ])

            ->add("avatar",  FileType::class, array(

                'data_class' => null,

                'required' => false,

                'label' => 'Avatar',

                // 'constraints' => array(

                //     new Assert\Image(array(

                //         'maxHeight' => 600,

                //         'maxWidth' => 600,

                //         'maxSize' => 1000000,

                //         'maxHeightMessage' => 'Longeur maximale de 600Px',

                //         'maxWidthMessage' => 'Largeur maximale de 600Px',

                //         'maxSizeMessage' => 'Taille maximale de 1Mo',

                //     ))

                // ),

                'invalid_message' => 'Cette valeur est invalide',

                // 'mapped' => false, 

                "attr" => ["accept" => "image/jpeg, image/png, image/gif"]

            ))

            ->add(

                "username",

                TextType::class,

                [

                    "label" => "Nom d'utilisateur",

                    'attr' => [

                        'class' => 'form-control ',

                        "placeholder" => "Nom d'utilisateur",

                    ]

                ]

            )

            ->add(

                "description",

                TextType::class,

                [

                    // "label" => "A propos",

                    'attr' => [

                        'class' => 'form-control my-2',

                        // "placeholder"=>"A propos",

                    ]

                ]

            )

            ->add("password", PasswordType::class, ["label" => "Mot de passe", 'attr' => [

                'class' => 'form-control',

                "placeholder" => "Mot de passe"

            ]])



            ->add('signature', HiddenType::class, ["attr" => ["class" => "output"]]);



        // Data transformer

        $builder->get('roles')

            ->addModelTransformer(new CallbackTransformer(

                function ($rolesArray) {

                    // transform the array to a string

                    return $rolesArray != null ? $rolesArray[0] : null;
                },

                function ($rolesString) {

                    // transform the string back to an array

                    return [$rolesString];
                }

            ));
    }



    public function configureOptions(OptionsResolver $resolver): void

    {

        $resolver->setDefaults([

            'data_class' => User::class,



        ]);
    }
}
