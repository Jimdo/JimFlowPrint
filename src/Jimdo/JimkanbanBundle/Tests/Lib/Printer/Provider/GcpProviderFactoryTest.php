<?php
namespace Jimdo\JimkanbanBundle\Tests\Lib\Printer\Provider;
use \Jimdo\JimkanbanBundle\Lib\Printer\Provider\GcpProviderFactory;

class GcpProviderFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Google\GCP\Client
     */
    private $gcpClient;

    /**
     * @var \Jimdo\JimkanbanBundle\Tests\Lib\Printer\Provider\GcpProviderFactory
     */
    private $gcpProviderFactory;

    public function setUp()
    {
        $this->gcpClient = $this->getMock('Jimdo\JimkanbanBundle\Lib\Google\GCP\Client', array(), array(), '', false);
        $this->gcpProviderFactory = new GcpProviderFactory($this->gcpClient);
    }

    /**
     * @test
     */
    public function itShouldReturnGcpProviderWithoutDocsInProdEnv()
    {
        $this->assertInstanceOf('Jimdo\JimkanbanBundle\Lib\Printer\Provider\GcpWithoutDocs', $this->gcpProviderFactory->get('prod'));
    }

    /**
     * @test
     */
    public function itShouldReturnGcpProviderWithDocsInDevEnv()
    {
        $this->assertInstanceOf('Jimdo\JimkanbanBundle\Lib\Printer\Provider\Gcp', $this->gcpProviderFactory->get('dev'));
    }

    /**
     * @test
     */
    public function itShouldReturnGcpProviderWithDocsInTestEnv()
    {
        $this->assertInstanceOf('Jimdo\JimkanbanBundle\Lib\Printer\Provider\Gcp', $this->gcpProviderFactory->get('test'));
    }

}
