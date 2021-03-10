<?php

namespace App\Form;

use App\Entity\Stage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Formation;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('dateDebut')
            ->add('duree')
            ->add('competencesRequises')
            ->add('experienceRequise')
            ->add('email')
            ->add('contact')
            ->add('entreprise', EntrepriseType::class)
            ->add('formations', EntityType::class, array(
              'class' => Formation::class,
              'choice_label' => 'nom',
              'multiple' => true,
              'expanded' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
