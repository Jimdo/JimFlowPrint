<?php
namespace Jimdo\JimkanbanBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ValidatorFactory;
use Jimdo\JimkanbanBundle\Entity\TicketType; 

class TicketTypeTest extends  WebTestCase 
{
    public function testSetValidbackgroundColor() {
        $e = new TicketType();
        $e->setBackgroundColor("111111");
        $validator = ValidatorFactory::buildDefault()->getValidator();
        $errors = $validator->validate($e);
        $this->assertEquals(0, count($errors));
    }
    
    public function testSetInvalidbackgroundColor() {
        $e = new TicketType();
        $e->setBackgroundColor("GGGGGG");
        $validator = ValidatorFactory::buildDefault()->getValidator();
        $errors = $validator->validate($e);
        $this->assertEquals(1, count($errors));
    }
}
?>