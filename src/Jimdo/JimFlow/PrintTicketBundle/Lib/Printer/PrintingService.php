<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Printer;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Generator\Service;
use \Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\PrinterInterface;
use \finfo;

class PrintingService
{

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Generator\Service
     */
    private $generator;

    /**
     * @var \Jimdo\PrintTicketBundle\Lib\Printer\PrinterInterface
     */
    private $printer;

    /**
     * @var \finfo
     */
    private $fileInfo;

    public function __construct(PrinterInterface $printer, Service $generator, finfo $fileInfo)
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

    private function getMimeType($file)
    {
        $mime = explode(';', $this->fileInfo->buffer($file));
        return $mime[0];
    }
}
