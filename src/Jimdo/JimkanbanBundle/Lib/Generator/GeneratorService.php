<?php
namespace Jimdo\JimkanbanBundle\Lib\Generator;
use \Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator;

class GeneratorService
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var \Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator
     */
    private $generator;



    public function __construct(LoggableGenerator $generator, array $options)
    {
        $this->generator = $generator;
        $this->options = $options;
    }

    public function generateFromUrl($url)
    {
        return $this->generator->getOutput($url, $this->options);
    }
}
