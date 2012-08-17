<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Printer;
use \Jimdo\JimFlow\PrintTicketBundle\Entity\Printer;

interface PrinterInterface
{
    public function doPrint($printerId, array $file);
}
