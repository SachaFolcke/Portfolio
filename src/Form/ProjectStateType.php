<?php

namespace App\Form;

use App\Entity\ProjectState;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectStateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Titre', 'attr' => array('placeholder' => 'Titre court de l\'état')))
            ->add('description', TextareaType::class, array('label' => 'Description (facultatif)', 'required' => false, 'attr' => array('placeholder' => 'Description facultative de l\'état')))
            ->add('icon', TextType::class, array('label' => 'Nom de l\'icône (facultatif)', 'required' => false, 'attr' => array('placeholder' => 'Nom de l\'icône Iconic Bootstrap')))
            ->add('text_hex_color', ColorType::class, array('label' => 'Couleur du texte'))
            ->add('background_hex_color', ColorType::class, array('label' => 'Couleur du fond'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectState::class,
        ]);
    }
}
