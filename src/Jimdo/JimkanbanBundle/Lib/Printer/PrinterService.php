<?php
namespace Jimdo\JimkanbanBundle\Lib\Printer;
use \Jimdo\JimkanbanBundle\Lib\Generator\GeneratorService;
use \Jimdo\JimkanbanBundle\Lib\Printer\PrinterInterface;
use \finfo;

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

    /**
     * @var \finfo
     */
    private $fileInfo;

    public function __construct(PrinterInterface $printer, GeneratorService $generator, finfo $fileInfo)
    {
        $this->printer = $printer;
        $this->generator = $generator;
        $this->fileInfo = $fileInfo;
    }

    public function doPrint($printerId, $html)
    {
        return $this->printer->doPrint($printerId, $this->getFile($html));
    }

    private function getFile($html)
    {
        $file = $this->generator->generateFromHtml($html);
        return array(
            'content' => $file,
            'mime' => $this->getMimeType($file)
        );
    }

    private function getMimeType($file) {
        return $this->fileInfo->buffer($file);
    }
}
