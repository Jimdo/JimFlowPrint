<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ColorType extends AbstractType
{
    public function getDefaultOptions(array $options)
    {
        return array(

        );
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'color';
    }
}
