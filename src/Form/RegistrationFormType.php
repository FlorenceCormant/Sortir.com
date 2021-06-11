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
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre pseudo ne peut etre vide',
                    ]),
                ],
            ])
            ->add("prenom", TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre prenom ne peut etre vide',
                    ]),
                ],
            ])
            ->add("nom", TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre prenom ne peut etre vide',
                    ]),
                ],])
            ->add("telephone", NumberType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numero de telephone ne peut etre vide'
                    ]),
                    new Regex('^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$
^',"Le format du numero de téléphone n'est pas le bon")
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => ['autocomplete' => 'email'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre email ne peut etre vide',
                    ]),
                ],
            ])
            ->add('villes', EntityType::class, [
                'class' => Villes::class,
                'choice_label' => 'nom',
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo',
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
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation'],
                'required' => true,
                'invalid_message' => 'Les mots de passe doivent être identiques',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez renseigner un mot de passe',
                    ]),
                    new Regex('^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$^','Le mot de passe doit faire au moins 8 caractères et avoir au moins une lettre et un chiffre'),

                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
        ]);
    }
}
