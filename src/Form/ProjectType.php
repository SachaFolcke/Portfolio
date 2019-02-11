<?php

namespace App\Form;

use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titre', null, array('property_path' => 'titre'))
            ->add('Résumé', null, array('property_path' => 'catch_phrase'))
            ->add('Période', null, array('property_path' => 'periode'))
            ->add('Composition du groupe', null, array('property_path' => 'compo_groupe'))
            ->add('Langages utilisés', null, array('property_path' => 'langages'))
            ->add('Description', null, array('property_path' => 'description'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
