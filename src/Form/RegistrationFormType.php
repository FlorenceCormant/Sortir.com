<?php

namespace App\Form;

use App\Entity\Participants;
use App\Entity\Sites;
use App\Entity\User;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add("prenom")
            ->add("nom")
            ->add("telephone")
            ->add("email")
            ->add('villes', EntityType::class, [
                'label' =>'Ville de rattachement',
                'class' => Villes::class,
                'choice_label' => 'nom',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'label' => 'Mot de Passe',
                'type'=> PasswordType::class,
                'first_options'=>['label'=>'Mot de passe'],
                'second_options'=>['label'=>'Confirmation'],
                'required'=>true,
                'invalid_message'=>'Les mots de passe doivent être identiques.',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            /*  ->add('agreeTerms', CheckboxType::class, [
                  'mapped' => false,
                  'constraints' => [
                      new IsTrue([
                          'message' => 'You should agree to our terms.',
                      ]),
                  ],
              ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participants::class,
        ]);
    }
}
