<?php

namespace App\Form;

use App\Entity\General;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeneralType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('website_title', TextType::class, array('label' => 'Titre du site', 'attr' => array('placeholder' => 'Texte dans l\'onglet')))
            ->add('title', TextType::class, array('label' => 'Titre du portfolio', 'attr' => array('placeholder' => 'Gros titre')))
            ->add('subtitle', TextType::class, array('label' => 'Sous-titre du portfolio', 'attr' => array('placeholder' => 'Sous-titre, sous le gros titre')))
            ->add('is_online', CheckboxType::class, array('label' => 'Portfolio en ligne ?', 'attr' => array('class' => 'form-check-input ml-3 mt-3'), 'label_attr' => array('class' => 'form-check-label'), 'required' => false))
            ->add('description', TextareaType::class, array('label' => 'Description du site (méta)', 'attr' => array('placeholder' => 'Description pour notre ami Google')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => General::class,
        ]);
    }
}
