<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_debut', DateType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Date de début',
                'widget' => 'single_text'
            ))
            ->add('date_fin', DateType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Date de fin',
                'widget' => 'single_text'
            ))
            ->add('date_creation', DateType::class, array(
                'attr' => array(
                    'class' => 'form-control',
                    'readonly' => true
                ),
                'label' => 'Date de Création',
                'widget' => 'single_text'
            ))
            ->add('nbPersonne', NumberType::class,  array(
                'attr' => array(
                    'class' => 'form-control'
                ))
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
