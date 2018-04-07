<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="userID", type="string", length=20)
     */
    private $userID;

    /**
     * @var string
     *
     * @ORM\Column(name="userFirstName", type="string", length=100)
     */
    private $userFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="domainID", type="string", length=10)
     */
    private $domainID;

    /**
     * @return string
     */
    public function getDomainID()
    {
        return $this->domainID;
    }

    /**
     * @param string $domainID
     */
    public function setDomainID($domainID)
    {
        $this->domainID = $domainID;
    }


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
     * Set userID
     *
     * @param string $userID
     * @return User
     */
    public function setUserID($userID)
    {
        $this->userID = $userID;

        return $this;
    }

    /**
     * Get userID
     *
     * @return string 
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * Set userFirstName
     *
     * @param string $userFirstName
     * @return User
     */
    public function setUserFirstName($userFirstName)
    {
        $this->userFirstName = $userFirstName;

        return $this;
    }

    /**
     * Get userFirstName
     *
     * @return string 
     */
    public function getUserFirstName()
    {
        return $this->userFirstName;
    }
}
