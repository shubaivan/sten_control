<?php

namespace App\Form;

use App\Entity\Control;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ControlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fisrt_name')
            ->add('last_name')
            ->add('device_hash')
            ->add('mobile')

            ->add('save', SubmitType::class, ['label' => 'Create'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Control::class,
        ]);
    }
}
