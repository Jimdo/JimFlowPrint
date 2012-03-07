<?

namespace Jimdo\JimkanbanBundle\Component\Validator\Constraints;
 
use Symfony\Component\Validator\Constraint;
 
/**
* @Annotation
*/
class HexColorCode extends Constraint
{
    // message is optional, you can also pass the message in the annotation
    public $message = 'The zip code should consist of 5 digits. Your input was {{ value }}.';
}