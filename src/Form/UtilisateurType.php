<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label'=>'Nom *',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('prenom', TextType::class, array(
                'label'=>'Prenom *',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('email', EmailType::class, array(
                'label'=>'Email *',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array(
                    'label' => 'Mot de passe *',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ),
                'second_options' => array(
                    'label' => 'Répéter mot de passe *',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ),
            ))
            ->add('telephone', TextType::class, array(
                'label' => 'Télephone *',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('adresse', TextType::class, array(
                'label' => 'Adresse *',
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('cgv', CheckboxType::class)
            ->add('newsletter', CheckboxType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Utilisateur::class,
        ));
    }
}