<?php

namespace App\Form;

use App\Entity\Control;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ControlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fisrt_name', TextType::class, [
                'label' => 'Имя',
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Фамилия',
            ])
            ->add('device_hash', TextType::class, [
                'label' => 'Хэш устройства',
            ])
            ->add('mobile', TextType::class, [
                'label' => 'UA mobile number ',
                'attr' => [
                    'placeholder' => '063 123 45 67'
                ]
            ])
            ->add('save', SubmitType::class, ['label' => 'Create']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Control::class,
        ]);
    }
}
