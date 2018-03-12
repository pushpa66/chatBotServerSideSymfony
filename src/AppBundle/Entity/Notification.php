<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
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
     * @ORM\Column(name="userID", type="string", length=100)
     */
    private $userID;

    /**
     * @var string
     *
     * @ORM\Column(name="productASIN", type="string", length=15)
     */
    private $productASIN;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=50)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=10)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="notifyType", type="string", length=2)
     */
    private $notifyType;


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
     * @return Notification
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
     * @return Notification
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

    /**
     * Set title
     *
     * @param string $title
     * @return Notification
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Notification
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Notification
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set notifyType
     *
     * @param string $notifyType
     * @return Notification
     */
    public function setNotifyType($notifyType)
    {
        $this->notifyType = $notifyType;

        return $this;
    }

    /**
     * Get notifyType
     *
     * @return string 
     */
    public function getNotifyType()
    {
        return $this->notifyType;
    }
}
