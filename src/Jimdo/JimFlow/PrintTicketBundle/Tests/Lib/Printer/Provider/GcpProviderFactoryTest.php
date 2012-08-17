<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Tests\Lib\Printer\Provider;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\GcpProviderFactory;

class GcpProviderFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Google\GCP\Client
     */
    private $gcpClient;

    /**
     * @var \Jimdo\PrintTicketBundle\Tests\Lib\Printer\Provider\GcpProviderFactory
     */
    private $gcpProviderFactory;

    public function setUp()
    {
        $this->gcpClient = $this->getMock('Jimdo\JimFlow\PrintTicketBundle\Lib\Google\GCP\Client', array(), array(), '', false);
        $this->gcpProviderFactory = new GcpProviderFactory($this->gcpClient);
    }

    /**
     * @test
     */
    public function itShouldReturnGcpProviderWithoutDocsInProdEnv()
    {
        $this->assertInstanceOf('Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\GcpWithoutDocs', $this->gcpProviderFactory->get('prod'));
    }

    /**
     * @test
     */
    public function itShouldReturnGcpProviderWithDocsInDevEnv()
    {
        $this->assertInstanceOf('Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\Gcp', $this->gcpProviderFactory->get('dev'));
    }

    /**
     * @test
     */
    public function itShouldReturnGcpProviderWithDocsInTestEnv()
    {
        $this->assertInstanceOf('Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider\Gcp', $this->gcpProviderFactory->get('test'));
    }

}
