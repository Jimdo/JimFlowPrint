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
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$this->isValidHexColorCode($value) ) {
            $this->context->addViolation($constraint->message, array('{{ value }}' => $value));
        }
    }
}
