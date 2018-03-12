<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserProduct
 *
 * @ORM\Table(name="user_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserProductRepository")
 */
class UserProduct
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
     * @ORM\Column(name="productASIN", type="string", length=15)
     */
    private $productASIN;


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
     * @return UserProduct
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
     * Set productASIN
     *
     * @param string $productASIN
     * @return UserProduct
     */
    public function setProductASIN($productASIN)
    {
        $this->productASIN = $productASIN;

        return $this;
    }

    /**
     * Get productASIN
     *
     * @return string 
     */
    public function getProductASIN()
    {
        return $this->productASIN;
    }
}
