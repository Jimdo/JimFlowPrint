<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Component\Validator\Constraints;

use Symfony\Bundle\FrameworkBundle\Test;
use Jimdo\JimFlow\PrintTicketBundle\Component\Validator\Constraints\HexColorCodeValidator;
use Jimdo\JimFlow\PrintTicketBundle\Component\Validator\Constraints\HexColorCode;
use Symfony\Component\Validator\ExecutionContext;

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
        $executionContext = $this->getExecutionContextMock();
        $executionContext->expects($this->once())->method('addViolation');

        $this->validator->initialize($executionContext);

        $codeWithLessThanThreeCharacters = '#aa';
        $this->validator->validate($codeWithLessThanThreeCharacters, $this->hexCodeConstraint);
    }

    /**
     * @test
     */
    public function itShouldNotAllowValuesWithHashAndMoreThanSixCharacters()
    {
        $executionContext = $this->getExecutionContextMock();
        $executionContext->expects($this->once())->method('addViolation');

        $this->validator->initialize($executionContext);

        $codeWithMoreThanSixChars = '#aaaaaaa';
        $this->validator->validate($codeWithMoreThanSixChars, $this->hexCodeConstraint);
    }

    /**
     * @test
     */
    public function itShouldNotAllowValuesWithHashAndMoreThanThreeAndLessThanSixCharacters()
    {
        $executionContext = $this->getExecutionContextMock();
        $executionContext->expects($this->once())->method('addViolation');

        $this->validator->initialize($executionContext);

        $codeWithFourChars = '#aaaa';
        $this->validator->validate($codeWithFourChars, $this->hexCodeConstraint);
    }

    /**
     * @test
     */
    public function itShouldNotAllowValuesContainingAlphanumericCharactersGreaterThanF()
    {
        $executionContext = $this->getExecutionContextMock();
        $executionContext->expects($this->once())->method('addViolation');

        $this->validator->initialize($executionContext);

        $code = '#GGG';
        $this->validator->validate($code, $this->hexCodeConstraint);
    }

    /**
     * @test
     */
    public function itShouldAllowValuesContainingAlphanumericValuesFromZeroToNineAndFromAtoFWithLengthOfSix()
    {
        $executionContext = $this->getExecutionContextMock();
        $executionContext->expects($this->never())->method('addViolation');

        $this->validator->initialize($executionContext);

        $validCode = '#aa123b';
        $this->validator->validate($validCode, $this->hexCodeConstraint);
    }

    /**
     * @test
     */
    public function itShouldAllowValuesContainingAlphanumericValuesFromZeroToNineAndFromAtoFWithLengthOfThreePlusHash()
    {
        $executionContext = $this->getExecutionContextMock();
        $executionContext->expects($this->never())->method('addViolation');

        $this->validator->initialize($executionContext);

        $validCode = '#ff0';
        $this->validator->validate($validCode, $this->hexCodeConstraint);
    }

    /**
     * @test
     */
    public function itShouldBeCaseInsensitive()
    {
        $executionContext = $this->getExecutionContextMock();
        $executionContext->expects($this->never())->method('addViolation');

        $this->validator->initialize($executionContext);

        $validCode = '#FfFf2A';
        $this->validator->validate($validCode, $this->hexCodeConstraint);
    }

    /**
     * @test
     */
    public function itShouldSetValidatorMessageWhenInvalidValuesAreProvided()
    {
        $someMessage = self::SOME_MESSAGE;

        $executionContext = $this->getExecutionContextMock();
        $executionContext->expects($this->once())->method('addViolation')->with($someMessage);

        $this->validator->initialize($executionContext);

        $someInvalidCode = 'XXXX';

        $this->hexCodeConstraint->message = $someMessage;
        $this->validator->validate($someInvalidCode, $this->hexCodeConstraint);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getExecutionContextMock()
    {
        $executionContext = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        return $executionContext;
    }

}
