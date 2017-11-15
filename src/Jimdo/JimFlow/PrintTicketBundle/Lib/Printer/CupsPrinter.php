<?php
namespace  Jimdo\JimFlow\PrintTicketBundle\Lib\Printer;

use \Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\PrinterInterface;

use Symfony\Component\Process\Process;

class CupsPrinter implements PrinterInterface
{

    public function doPrint($printerId, array $file)
    {
        $filename = '/tmp/' . uniqid('jimflowprint') . '.pdf';
        file_put_contents($filename, $file['content']);

        // TODO Make color output configurable? (-o ColorModel=Grayscale)
        $process = new Process('lp -o media=A6,MultiTray -o landscape -d ' . escapeshellarg($printerId) . ' ' . escapeshellarg($filename));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}
