<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add('prenom')
            ->add('nom')
            ->add('telephone')
            ->add('email')
            ->add('password', RepeatedType::class, [
                'type'=> PasswordType::class,
                'first_options'=>['label'=>'Mot de passe'],
                'second_options'=>['label'=>'Confirmation'],
                'required'=>true,
                'invalid_message'=>'Les mots de passe doivent être identiques.'
            ])
            ->add('ville', EntityType::class, [
                'label' =>'Ville de rattachement',
                'class' => Villes::class,
                'choice_label' => 'nom',
                'disabled' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
