<?php
namespace Jimdo\JimkanbanBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ValidatorFactory;
use Jimdo\JimkanbanBundle\Entity\TicketType; 

class TicketTypeTest extends  \PHPUnit_Framework_TestCase
{
    const SOME_COLOR = 'some_color';
    const SOME_BOOL = true;
    /**
     * @var \Jimdo\JimkanbanBundle\Entity\TicketType
     */
    private $ticketType;

    const SOME_NAME = 'some_name';

    public function setUp()
    {
        $this->ticketType = new TicketType();
    }

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

    /**
     * @test
     */
    public function itShouldAllowToSetTheName()
    {
        $name = self::SOME_NAME;
        $this->ticketType->setName($name);
        $this->assertEquals($name, $this->ticketType->getName());
    }

    /**
     * @test
     */
    public function itShouldAllowToSetTheBackGroundColor()
    {
        $backgroundColor = self::SOME_COLOR;
        $this->ticketType->setBackgroundColor($backgroundColor);
        $this->assertEquals($backgroundColor, $this->ticketType->getBackgroundColor());
    }

     /**
     * @test
     */
    public function itShouldAllowToSetIsBackgroundFilled()
    {
        $isBackgroundFilled = self::SOME_BOOL;
        $this->ticketType->setIsBackgroundFilled($isBackgroundFilled);
        $this->assertEquals($isBackgroundFilled, $this->ticketType->getIsBackgroundFilled());
    }
}
?>