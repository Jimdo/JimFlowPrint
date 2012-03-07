<?php

namespace Jimdo\JimkanbanBundle\Component\Validator\Constraints;
 
use Symfony\Component\Validator\Constraint;
 
/**
* @Annotation
*/
class HexColorCode extends Constraint
{
    /**
     * @var String
     */
    public $message;
}