<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Jimdo\JimFlow\PrintTicketBundle\Component\Validator\Constraints as CustomAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Jimdo\JimFlow\PrintTicketBundle\Entity\TicketType
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jimdo\JimFlow\PrintTicketBundle\Entity\TicketTypeRepository")
 * @UniqueEntity("name")
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
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string $background_color
     *
     * @CustomAssert\HexColorCode(message="Invalid hexadecimal color code")
     *
     * @ORM\Column(name="background_color", type="string", length=7)
     */
    private $backgroundColor;

    /**
     * @var boolean $is_background_filled
     *
     * @ORM\Column(name="is_background_filled", type="boolean", nullable=true)
     */
    private $isBackgroundFilled;

     /**
     * @var boolean is_fallback
     *
     * @ORM\Column(name="is_fallback", type="boolean", nullable=true)
     */
    private $isFallback;

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

    /**
     * Set is_fallback
     *
     * @param boolean $isFallback
     */
    public function setIsFallback($isFallback)
    {
        $this->isFallback = $isFallback;
    }

     /**
     * Get is_fallback
     *
     * @return boolean
     */
    public function getIsFallback()
    {
        return $this->isFallback;
    }
}
