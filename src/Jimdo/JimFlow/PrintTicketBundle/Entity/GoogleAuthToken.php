<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GoogleAuthToken
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Jimdo\JimFlow\PrintTicketBundle\Entity\GoogleAuthTokenRepository")
 */
class GoogleAuthToken
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
     * @ORM\Column(name="refreshToken", type="string", length=255)
     */
    private $refreshToken;

    /**
     * @var string
     *
     * @ORM\Column(name="accessToken", type="string", length=255)
     */
    private $accessToken;



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
     * Set refreshToken
     *
     * @param string $refreshToken
     * @return GoogleAuthToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    
        return $this;
    }

    /**
     * Get refreshToken
     *
     * @return string 
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
