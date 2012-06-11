<?php
namespace Jimdo\JimkanbanBundle\Lib\Printer;
use \Jimdo\JimkanbanBundle\Lib\Generator\GeneratorService;
use \Jimdo\JimkanbanBundle\Lib\Printer\PrinterInterface;

class PrinterService
{
    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Generator\GeneratorService
     */
    private $generator;

    /**
     * @var \Jimdo\JimkanbanBundle\Lib\Printer\PrinterInterface
     */
    private $printer;

    public function __construct(PrinterInterface $printer, GeneratorService $generator)
    {
        $this->printer = $printer;
        $this->generator = $generator;
    }

    public function doPrint($printer, $html)
    {
        return $this->printer->doPrint($printer, $this->getFile($html));
    }

    private function getFile($html)
    {
        $file = $this->generator->generateFromHtml($html);
        $fileInfo = new \finfo(FILEINFO_MIME);
        return array(
            'content' => $file,
            'mime' => $fileInfo->buffer($file)
        );

    }
}
