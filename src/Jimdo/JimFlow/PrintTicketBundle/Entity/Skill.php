<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Jimdo\JimFlow\PrintTicketBundle\Component\Validator\Constraints as CustomAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Jimdo\JimFlow\PrintTicketBundle\Entity\Skill
 *
 * @ORM\Table(name="skill")
 * @ORM\Entity(repositoryClass="Jimdo\JimFlow\PrintTicketBundle\Entity\SkillRepository")
 * @UniqueEntity("name")
 */
class Skill
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * 
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @CustomAssert\HexColorCode(message="Invalid hexadecimal color code")
     *
     * @ORM\Column(name="background_color", type="string", length=7)
     */
    private $backgroundColor;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_background_filled", type="boolean", nullable=true)
     */
    private $isBackgroundFilled;

    /**
     * @var string
     * 
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     * @Assert\File(mimeTypes={ "image/*" })
     */
    private $image;

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
     * Set background color
     *
     * @param string $backgroundColor
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * Get background color
     *
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * Set background filled
     *
     * @param boolean $isBackgroundFilled
     */
    public function setIsBackgroundFilled($isBackgroundFilled)
    {
        $this->isBackgroundFilled = $isBackgroundFilled;
    }

    /**
     * Is background filled?
     *
     * @return boolean
     */
    public function getIsBackgroundFilled()
    {
        return $this->isBackgroundFilled;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

     /**
     * Get image
     *
     * @return string|null
     */
    public function getImage()
    {
        return $this->image;
    }
}
