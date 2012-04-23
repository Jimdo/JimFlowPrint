<?php
namespace  Jimdo\JimkanbanBundle\Lib\Printer;
use \Jimdo\JimkanbanBundle\Lib\Printer\PrinterInterface;
use \Jimdo\JimkanbanBundle\Entity\Printer;

class EmailPrinter implements PrinterInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var String
     */
    private $from;

    public function __construct(\Swift_Mailer $mailer, $from)
    {
        $this->mailer = $mailer;
        $this->from = $from;
    }

    public function doPrint(Printer $printer, array $file)
    {
        $attachment = \Swift_Attachment::newInstance($file['content'], 'ticket.png', $file['mime']);

        $message = \Swift_Message::newInstance()
        ->setSubject('Hello Email')
        ->setFrom($this->from)
        ->setTo($printer->getEmail())
        ->setBody('lol')
        ->attach($attachment);

        $this->mailer->send($message);

    }

}
