<?php

namespace App\Form;

use App\Entity\ProjectState;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, array('label' => 'Titre', 'attr' => array('placeholder' => 'Titre principal du projet')))
            ->add('catchPhrase', TextType::class, array('label' => 'Résumé', 'attr' => array('placeholder' => 'Petite phrase résumant le projet')))
            ->add('periode', TextType::class, array('label' => 'Période', 'attr' => array('placeholder' => 'Ex : Juin 2018, 18 décembre 2017...')))
            ->add('compoGroupe', TextType::class, array('label' => 'Composition du groupe', 'attr' => array('placeholder' => 'Groupe de x, Binôme...')))
            ->add('langages', TextType::class, array('label' => 'Langages utilisés', 'attr' => array('placeholder' => 'Énumération des langages utilisés')))
            ->add('description', TextareaType::class, array('label' => 'Description', 'attr' => array('placeholder' => 'Décrivez le projet le plus précisément possible')))
            ->add('state', EntityType::class, array('label' => 'État du projet', 'class' => ProjectState::class, 'choice_label' => 'title'))
            ->add('online', CheckboxType::class, array('label' => 'Projet en ligne ?', 'attr' => array('class' => 'form-check-input ml-3 mt-3'), 'label_attr' => array('class' => 'form-check-label'), 'required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
