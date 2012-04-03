<?php

namespace Jimdo\JimkanbanBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TicketType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('name', 'text', array(
                    'label' => 'Name'
                ))
                ->add('backgroundColor', 'text', array(
                    'label' => 'Background Color',
                    'attr' => array(
                        'class' => 'jk-color-picker ticket'
                    )
                ))
                ->add('isBackgroundFilled', 'checkbox', array(
                    'label' => 'Fill entire background',
                    'required' => false
                ))
        ;
    }

    public function getName() {
        return 'jimdo_jimkanbanbundle_tickettypetype';
    }

}
