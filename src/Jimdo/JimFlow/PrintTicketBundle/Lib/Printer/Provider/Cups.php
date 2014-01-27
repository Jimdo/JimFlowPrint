<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Provider;

use Jimdo\JimFlow\PrintTicketBundle\Lib\Printer\Config;
use Symfony\Component\Process\Process;

class Cups implements ProviderInterface
{

    /**
     * @return \Jimdo\PrintTicketBundle\Lib\Printer\Config[]
     */
    public function getPrinters()
    {
        $process = new Process('lpstat -p');
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }

        $printers = array();

        $output = $process->getOutput();
        foreach (explode(PHP_EOL, $output) as $line) {
            if (preg_match('/^printer (\S+)/', $line, $matches)) {
                $printers[] = new Config($matches[1], $matches[1], TRUE);
            }
        }

        return $printers;
    }

}
