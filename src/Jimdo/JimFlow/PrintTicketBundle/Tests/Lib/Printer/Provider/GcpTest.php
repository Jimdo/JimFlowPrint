<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Lib\Printer\Provider;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\Gcp;
use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;

class GcpTest extends \PHPUnit_Framework_TestCase
{
    private $response = array(
        array('id' => '1', 'displayName' => 'horst', 'connectionStatus' => 'ONLINE'),
        array('id' => '2', 'displayName' => 'peter', 'connectionStatus' => 'ONLINE'),
        array('id' => '3', 'displayName' => 'walter', 'connectionStatus' => 'OFFLINE'),
    );

    private $gcpClient;

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Printer\Provider\Gcp
     */
    private $gcpProvider;

    public function setUp()
    {
        $this->gcpClient = $this->getMock('Jimdo\JimFlow\PrintTicketBundle\Lib\Google\GCP\Client', array(), array(), '', false);
        $this->gcpClient->expects($this->any())->method('getPrinterList')->will($this->returnValue($this->response));

        $this->gcpProvider = new Gcp($this->gcpClient);
    }

    /**
     * @test
     */
    public function itShouldReturnAllPrinters()
    {
        $expected = array(
            new Config('1', 'horst', true),
            new Config('2', 'peter', true),
            new Config('3', 'walter', false),
        );
        $this->assertEquals($expected, $this->gcpProvider->getPrinters());
    }
}
