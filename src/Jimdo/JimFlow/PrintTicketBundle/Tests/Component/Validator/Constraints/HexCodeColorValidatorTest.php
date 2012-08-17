<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Component\Validator\Constraints;

use Symfony\Bundle\FrameworkBundle\Test;
use Jimdo\JimFlow\PrintTicketBundle\Component\Validator\Constraints\HexColorCodeValidator;
use Jimdo\JimFlow\PrintTicketBundle\Component\Validator\Constraints\HexColorCode;

class HexCodeColorValidatorTest extends \PHPUnit_Framework_TestCase
{
    const SOME_MESSAGE = 'ladidadida';

    /**
     * @var \Jimdo\JimFlow\PrintTicketBundle\Component\Validator\Constraints\HexColorCodeValidator
     */
    private $validator;

    /**
     * @var \Jimdo\JimFlow\PrintTicketBundle\Component\Validator\Constraints\HexColorCode
     */
    private $hexCodeConstraint;

    public function setUp()
    {
        $this->validator = new HexColorCodeValidator();
        $this->hexCodeConstraint = new HexColorCode();

    }

    /**
     * @test
     */
    public function itShouldNotAllowValuesWithHashAndLessThanThreeCharacters()
    {
        $codeWithLessThanThreeCharacters = '#aa';
        $this->assertFalse($this->validator->isValid($codeWithLessThanThreeCharacters, $this->hexCodeConstraint));
    }

    /**
     * @test
     */
    public function itShouldNotAllowValuesWithHashAndMoreThanSixCharacters()
    {
        $codeWithMoreThanSixChars = '#aaaaaaa';
        $this->assertFalse($this->validator->isValid($codeWithMoreThanSixChars, $this->hexCodeConstraint));
    }

    /**
     * @test
     */
    public function itShouldNotAllowValuesWithHashAndMoreThanThreeAndLessThanSixCharacters()
    {
        $codeWithFourChars = '#aaaa';
        $this->assertFalse($this->validator->isValid($codeWithFourChars, $this->hexCodeConstraint));
    }

    /**
     * @test
     */
    public function itShouldNotAllowValuesContainingAlphanumericCharactersGreaterThanF()
    {
        $code = '#GGG';
        $this->assertFalse($this->validator->isValid($code, $this->hexCodeConstraint));
    }

    /**
     * @test
     */
    public function itShouldAllowValuesContainingAlphanumericValuesFromZeroToNineAndFromAtoFWithLengthOfSix()
    {
        $validCode = '#aa123b';
        $this->assertTrue($this->validator->isValid($validCode, $this->hexCodeConstraint));
    }

    /**
     * @test
     */
    public function itShouldAllowValuesContainingAlphanumericValuesFromZeroToNineAndFromAtoFWithLengthOfThreePlusHash()
    {
        $validCode = '#ff0';
        $this->assertTrue($this->validator->isValid($validCode, $this->hexCodeConstraint));
    }

    /**
     * @test
     */
    public function itShouldBeCaseInsensitive()
    {
        $validCode = '#FfFf2A';
        $this->assertTrue($this->validator->isValid($validCode, $this->hexCodeConstraint));
    }

    /**
     * @test
     */
    public function itShouldSetValidatorMessageWhenInvalidValuesAreProvided()
    {
        $someInvalidCode = 'XXXX';
        $someMessage = self::SOME_MESSAGE;

        $this->hexCodeConstraint->message = $someMessage;
        $this->assertFalse($this->validator->isValid($someInvalidCode, $this->hexCodeConstraint));
        $this->assertEquals($someMessage, $this->validator->getMessageTemplate());
    }

     /**
     * @test
     */
    public function itShouldNotSetValidatorMessageWhenValidValuesAreProvided()
    {
        $someValidCode = '#000';
        $someMessage = self::SOME_MESSAGE;

        $this->hexCodeConstraint->message = $someMessage;
        $this->assertTrue($this->validator->isValid($someValidCode, $this->hexCodeConstraint));
        $this->assertNull($this->validator->getMessageTemplate());
    }

}
