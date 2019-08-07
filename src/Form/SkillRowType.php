<?php

namespace App\Form;

use App\Entity\SkillCategory;
use App\Entity\SkillRow;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillRowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextType::class, ['label' => 'Texte de la ligne'])
            ->add('category', EntityType::class, ['class' => SkillCategory::class, 'choice_label' => 'title', 'label' => 'Catégorie'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SkillRow::class,
        ]);
    }
}
