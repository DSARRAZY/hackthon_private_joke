<?php

namespace App\Form;

use App\Entity\Drug;
use App\Entity\Patient;
use App\Entity\Prescription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PrescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dosage', TextareaType::class)
            ->add('duration')
            ->add('beginningOfTreatment')
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => 'name',
            ])
            ->add('drugs',EntityType::class, [
                'class' => Drug::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'by_reference' => false,
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prescription::class,
        ]);
    }
}
