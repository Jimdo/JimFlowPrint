<?php
namespace Jimdo\JimFlow\PrintTicketBundle\Lib\Printer;

class Config
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * determines whether the printer is available or offline due to for example maintenance
     * @var bool
     */
    private $isAvailable;

    public function __construct($id, $name, $isAvailable)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isAvailable = $isAvailable;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isAvailable()
    {
        return $this->isAvailable;
    }

}
