<?php
namespace  Jimdo\JimkanbanBundle\Lib\Printer;

class EmailPrinter
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

    public function doPrint($attachment)
    {
        $message = \Swift_Message::newInstance()
        ->setSubject('Hello Email')
        ->setFrom($this->from)
        ->setTo('drexler.robin@gmail.com')
        ->setBody('lol');

        $this->mailer->send($message);

    }

}
