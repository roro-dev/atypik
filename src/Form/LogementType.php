<?php

namespace App\Form;

use App\Entity\Logement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Proxies\__CG__\App\Entity\TypeLogement;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Utilisateur;

class LogementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('nbVoyageur', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('nbLits', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('nbSalledeBain', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('prix', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))
            ->add('id_type', EntityType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'class' => TypeLogement::class,
                'choice_label' => 'type'
            ))
            ->add('id_proprietaire', EntityType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'class' => Utilisateur::class
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Logement::class,
        ]);
    }
}
