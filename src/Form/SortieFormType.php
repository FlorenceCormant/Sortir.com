<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Sorties;
use App\Entity\Villes;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class SortieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie :'
            ])
            ->add('date_debut', DateTimeType::class, [
                'html5' => true,
                'widget' => 'single_text'
            ])
            ->add('date_cloture', DateTimeType::class, [
                'html5' => true,
                'widget' => 'single_text'
            ])
            ->add('nb_inscriptions_max')
            ->add('duree', NumberType::class,[
                'label' => 'Durée en heure : '
            ])
            ->add('description_infos', TextareaType::class,[
                'label' => 'Description et infos :'
            ])
            ->add('noLieu', EntityType::class, [
                'label' => 'Lieu :',
                'class' => Lieux::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un lieu'])
            ->add('photo', FileType::class, [
                'label' => 'Photo : ',
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
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}