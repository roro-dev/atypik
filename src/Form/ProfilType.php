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

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Nom *',
                'label_attr' => array(
                    'class' => 'col-2 col-form-label'
                )
            ))
            ->add('prenom', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Prénom *',
                'label_attr' => array(
                    'class' => 'col-2 col-form-label'
                )
            ))
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Adresse mail *',
                'label_attr' => array(
                    'class' => 'col-2 col-form-label'
                )
            ))
            ->add('telephone', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Téléphone *',
                'label_attr' => array(
                    'class' => 'col-2 col-form-label'
                )
            ))
            ->add('adresse', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Adresse *',
                'label_attr' => array(
                    'class' => 'col-2 col-form-label'
                )
            ))
            ->add('siret', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'label' => 'Numéro de siret *',
                'label_attr' => array(
                    'class' => 'col-2 col-form-label'
                )
            ))
            ->add('newsletter', CheckboxType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Utilisateur::class,
        ));
    }
}