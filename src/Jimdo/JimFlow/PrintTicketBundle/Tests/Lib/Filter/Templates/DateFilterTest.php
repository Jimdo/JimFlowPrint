<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Lib\Filter\Templates;

use Symfony\Bundle\FrameworkBundle\Test;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Filter\Templates\TicketDateFilter;

class DateFilterTest extends \PHPUnit_Framework_TestCase {

    const SOME_AMERICAN_DATE = '1990-07-27';

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Filter\Templates\TicketDateFilter
     */
    private $dateFilter;

    public function setUp()
    {
        $this->dateFilter = new TicketDateFilter();
    }

    private function filter($dateString)
    {
       return $this->dateFilter->filter(array('date' => $dateString), 'date');
    }

    /**
     * @test
     */
    public function itShouldAllowToFilterADateWhenAStringContainingADateIsProvided()
    {
        $someDate = self::SOME_AMERICAN_DATE;
        $exampleDateString = $someDate . '(1 year ago)';

        $this->assertEquals($this->filter($exampleDateString), array('date' => $someDate));
    }

    /**
     * @test
     */
    public function itShouldReturnTheDateInAmericanFormat()
    {
        $germanDate = '06.12.2003';
        $expectedAmericanDate = '2003-12-06';

        $this->assertEquals(array('date' => $expectedAmericanDate), $this->filter($germanDate));
    }

}
