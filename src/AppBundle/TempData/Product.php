<?php

/**
 * Created by PhpStorm.
 * User: Pushpe
 * Date: 3/8/2018
 * Time: 11:43 PM
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $productASIN;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProductASIN()
    {
        return $this->productASIN;
    }

    /**
     * @param mixed $productASIN
     */
    public function setProductASIN($productASIN)
    {
        $this->productASIN = $productASIN;
    }

}