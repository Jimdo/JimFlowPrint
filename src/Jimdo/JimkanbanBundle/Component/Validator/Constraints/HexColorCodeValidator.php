<?

namespace Jimdo\JimkanbanBundle\Component\Validator\Constraints;
 
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
 
class HexColorCodeValidator extends ConstraintValidator
{
    /*
     * Very simple validation logic to test german zip codes,
     * usually german zip codes consists of 5 digits
     */
    private function isValidZipCode($value){
        return 0 === preg_match('/\d[5]/', $value);
    }
 
    public function isValid($value, Constraint $constraint)
    {
        if(!$this->isValidZipCode($value) ) {
            $this->setMessage($constraint->message, array('{{ value }}' => $value));
 
            return false;
        }
 
        return false;
    }
}