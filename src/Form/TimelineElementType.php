<?php

namespace App\Form;

use App\Entity\TimelineElement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimelineElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre', 'attr' => ['placeholder' => "Titre principal de l'élément"]])
            ->add('period', TextType::class, ['label' => 'Période', 'attr' => ['placeholder' => "Septembre 2019, 12 Décembre 2018..."]])
            ->add('description', TextareaType::class, ['label' => 'Description', 'attr' => ['placeholder' => "Description rapide de l'élément"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TimelineElement::class,
        ]);
    }
}
