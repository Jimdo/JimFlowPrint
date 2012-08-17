<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Component\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HexColorCodeValidator extends ConstraintValidator
{
    /**
     * @param $value
     * @return bool
     */
    private function isValidHexColorCode($value)
    {
        return 0 < preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $value);
    }

    /**
     * @param $value
     * @param  \Symfony\Component\Validator\Constraint $constraint
     * @return bool
     */
    public function isValid($value, Constraint $constraint)
    {
        if (!$this->isValidHexColorCode($value) ) {
            $this->setMessage($constraint->message, array('{{ value }}' => $value));

            return false;
        }

        return true;
    }
}
