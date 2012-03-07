<?php
namespace Jimdo\JimkanbanBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ValidatorFactory;
use Jimdo\JimkanbanBundle\Entity\TicketType; 

class TicketTypeTest extends WebTestCase 
{

    public function testSet() 
    {
        $e = new TicketType();
        $e->setBackgroundColor("11111");
        $validator = ValidatorFactory::buildDefault()->getValidator();
        $errors = $validator->validate($e);
        $this->assertEquals(0, count($errors));
    }
}
