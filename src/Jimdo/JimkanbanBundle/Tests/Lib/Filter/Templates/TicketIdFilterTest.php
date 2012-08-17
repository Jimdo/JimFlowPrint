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
    public function itShouldStripAwayAllHashes()
    {
        $id = '123';
        $someKey = self::SOME_KEY;

        $filter = new TicketIdFilter();
        $data = array($someKey => $id);
        $data = $filter->filter($data, $someKey);
        $this->assertNotContains('#', $data[$someKey]);
    }

}
