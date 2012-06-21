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



    /**
     * @param \Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator $generator
     * @param array $options
     */
    public function __construct(LoggableGenerator $generator, array $options)
    {
        $this->generator = $generator;
        $this->options = $options;
    }

    /**
     * @param $html
     * @return string
     */
    public function generateFromHtml($html)
    {
        return $this->generator->getOutputFromHtml($html, $this->options);
    }
}
