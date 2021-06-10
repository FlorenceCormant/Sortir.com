<?php

namespace App\Form;

use App\Entity\Participants;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class,[
                'invalid_message' => 'Pseudo déjà utilisé'
            ])
            ->add("prenom",TextType::class,[

            ])

            ->add("nom")
            ->add("telephone",NumberType::class,[
                'invalid_message' => 'Seuls les chiffres sont autorisés'
            ])
            ->add('email', EmailType::class, [
                'attr' => ['autocomplete' => 'email'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your email',
                    ]),
                ],
            ])
            ->add('villes', EntityType::class, [
                'class' => Villes::class,
                'choice_label' => 'nom',
            ])
            ->add('photo', FileType::class, [
                'label' =>'Photo',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image(
                        [
                            'maxSize' => '7024k',
                            'mimeTypesMessage' => "Format de l'image incorrecte !"
                        ]
                    )
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'=> PasswordType::class,
                'first_options'=>['label'=>'Mot de passe'],
                'second_options'=>['label'=>'Confirmation'],
                'required'=>true,
                'invalid_message'=>'Les mots de passe doivent être identiques',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer un mot de passe",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir au minimum 6 caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
        ]);
    }
}
