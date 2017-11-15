<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Form;

use Jimdo\JimFlow\PrintTicketBundle\Form\ColorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Skill extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                [
                    'label' => 'Name',
                    'attr' => [
                        'pattern' => '^[^;]+$',
                    ],
                ]
            )
            ->add(
                'backgroundColor',
                new ColorType(),
                [
                    'label' => 'Background Color',
                    'attr' => [
                        'class' => 'jk-color-picker ticket',
                    ]
                ]
            )
            ->add(
                'isBackgroundFilled',
                'checkbox',
                [
                    'label' => 'Fill background',
                    'required' => false,
                ]
            )
            ->add(
                'image',
                'file',
                [
                    'label' => 'Image (Ratio: 1/0.4)',
                    'required' => false,
                    'attr' => [
                        'accept' => 'image/*',
                    ],
                ]
            )
            ->add(
                'deleteImage',
                'checkbox',
                [
                    'label' => 'Delete image?',
                    'mapped' => false,
                    'required' => false,
                ]
            );

    }

    public function getName()
    {
        return 'jimdo_jimflow_printticketbundle_skilltype';
    }
}
