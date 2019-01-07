<?php

namespace App\Form;

use App\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Logement;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo', FileType::class, array(
                'label' => 'Brochure (PDF file)',
                'attr' => array(
                    'multiple' => true
                )))
            ->add('id_logement', EntityType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'class' => Logement::class,
                'choice_label' => 'nom'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Photo::class,
        ]);
    }
}
