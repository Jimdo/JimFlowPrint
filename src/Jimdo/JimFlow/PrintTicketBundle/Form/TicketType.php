<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Jimdo\JimFlow\PrintTicketBundle\Form\ColorType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $data = $options['data'];

        $builder
                ->add('name', 'text', array(
                    'label' => 'Name'
                ))
                ->add('backgroundColor', new ColorType(), array(
                    'label' => 'Background Color',
                    'attr' => array(
                        'class' => 'jk-color-picker ticket'
                    )
                ))
                ->add('isBackgroundFilled', 'checkbox', array(
                    'label' => 'Fill entire background',
                    'required' => false
                ))
        ->add('isFallback', $this->getIsFallbackType($data->getIsFallback()), array(
                    'label' => 'Use if no or unknown type is specified?',
                    'required' => false,
                ))
        ;
    }

    private function getIsFallbackType($isFallback)
    {
        return $isFallback ? 'hidden' : 'checkbox';
    }

    public function getName()
    {
        return 'jimdo_jimflow_printticketbundle_tickettypetype';
    }

}
