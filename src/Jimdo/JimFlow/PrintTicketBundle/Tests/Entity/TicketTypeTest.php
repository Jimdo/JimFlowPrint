<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Entity;

use Symfony\Component\Validator\ValidatorFactory;
use Jimdo\JimFlow\PrintTicketBundle\Entity\TicketType;

class TicketTypeTest extends  \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    const SOME_COLOR = 'some_color';
    const SOME_BOOL = true;
    /**
     * @var \Jimdo\PrintTicketBundle\Entity\TicketType
     */
    private $ticketType;

    const SOME_NAME = 'some_name';

    public function setUp()
    {
        $this->ticketType = new TicketType();
    }

    private function getKernel()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        return $kernel;
    }

    public function testSetValidbackgroundColor()
    {
        $kernel = $this->getKernel();

        $e = new TicketType();
        $e->setName(self::SOME_NAME);
        $e->setBackgroundColor("#111111");
        $validator = $kernel->getContainer()->get('validator');
        $errors = $validator->validate($e);
        $this->assertEquals(0, $errors->count());
    }

    public function testSetInvalidbackgroundColor()
    {
        $kernel = $this->getKernel();
        $e = new TicketType();
        $e->setName(self::SOME_NAME);
        $e->setBackgroundColor("GGGGGG");
        $validator = $kernel->getContainer()->get('validator');
        $errors = $validator->validate($e);
        $this->assertEquals(1, $errors->count());
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
