<?php

namespace Jimdo\JimkanbanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PrinterType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('notes','textarea', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'jimdo_jimkanbanbundle_printertype';
    }
}
