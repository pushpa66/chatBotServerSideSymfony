<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * Set productASIN
     *
     * @param string $productASIN
     * @return Product
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
