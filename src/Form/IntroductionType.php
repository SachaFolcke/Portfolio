<?php

namespace App\Form;

use App\Entity\Introduction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IntroductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Titre', 'attr' => array('placeholder' => 'Gros titre en haut de la catégorie')))
            ->add('text', TextareaType::class, array('label' => 'Texte de la présentation'))
            ->add('photo', FileType::class, array('label' => 'Photo', 'required' => false, 'mapped' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Introduction::class,
        ]);
    }
}
