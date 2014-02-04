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

        $process = new Process('lp -o media=A6,MultiTray -o landscape -o ColorModel=Grayscale -d ' . escapeshellarg($printerId) . ' ' . escapeshellarg($filename));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
    }
}
