<?php

namespace Jimdo\JimkanbanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jimdo\JimkanbanBundle\Entity\TicketType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jimdo\JimkanbanBundle\Entity\TicketTypeRepository")
 */
class TicketType
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $background_color
     *
     * @ORM\Column(name="background_color", type="string", length=6)
     */
    private $backgroundColor;

    /**
     * @var boolean $is_background_filled
     *
     * @ORM\Column(name="is_background_filled", type="boolean", nullable=true)
     */
    private $isBackgroundFilled;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set background_color
     *
     * @param string $backgroundColor
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * Get background_color
     *
     * @return string 
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * Set is_background_filled
     *
     * @param boolean $isBackgroundFilled
     */
    public function setIsBackgroundFilled($isBackgroundFilled)
    {
        $this->isBackgroundFilled = $isBackgroundFilled;
    }

    /**
     * Get is_background_filled
     *
     * @return boolean 
     */
    public function getIsBackgroundFilled()
    {
        return $this->isBackgroundFilled;
    }
}