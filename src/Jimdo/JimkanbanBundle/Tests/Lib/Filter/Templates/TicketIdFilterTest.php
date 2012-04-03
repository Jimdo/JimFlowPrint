<?php
namespace Jimdo\JimkanbanBundle\Tests\Lib\Filter\Templates;

use Symfony\Bundle\FrameworkBundle\Test;
use Jimdo\JimkanbanBundle\Lib\Filter\Templates\TicketIdFilter;

class TicketIdFilterTest extends \PHPUnit_Framework_TestCase
{
    const SOME_KEY = 'someKey';

    /**
     * @test
     */
    public function itShouldPrependAHashWhenNoneIsAlreadyExistent()
    {
        $id = '123';
        $someKey = self::SOME_KEY;

        $filter = new TicketIdFilter();
        $data = array($someKey => $id);
        $data = $filter->filter($data, $someKey);
        $this->assertEquals('#' . $id, $data[$someKey]);
    }

    /**
     * @test
     */
    public function itShouldNotPretendAHashWhenThereIsAlreadyOne()
    {
        $id = '#123';
        $someKey = self::SOME_KEY;

        $filter = new TicketIdFilter();
        $data = array($someKey => $id);
        $data = $filter->filter($data, $someKey);
        $this->assertEquals('#' . $id, $data[$someKey]);
    }

}
