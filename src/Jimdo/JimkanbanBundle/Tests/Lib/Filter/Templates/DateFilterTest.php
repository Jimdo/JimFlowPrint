<?php

namespace Jimdo\JimkanbanBundle\Tests\Lib\Filter\Templates;

use Symfony\Bundle\FrameworkBundle\Test;
use Jimdo\JimkanbanBundle\Lib\Filter\Templates\TicketDateFilter;

class DateFilterTest extends \PHPUnit_Framework_TestCase {

    const SOME_GERMAN_DATE = '27.06.1990';

    /**
     * @var \TicketDateFilter\JimkanbanBundle\Lib\Filter\Templates\DateFilter
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
        $someDate = self::SOME_GERMAN_DATE;
        $exampleDateString = $someDate . '(1 year ago)';

        $this->assertEquals($this->filter($exampleDateString), array('date' => $someDate));
    }

    /**
     * @test
     */
    public function itShouldReturnTheDateInGermanFormat()
    {
        $americanDate = '2003-12-06';
        $expectedGermanDate = '06.12.2003';

        $this->assertEquals(array('date' => $expectedGermanDate), $this->filter($americanDate));
    }

}
