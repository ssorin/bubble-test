<?php

namespace Sorin\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Shop
 * @UniqueEntity("name")
 */
class Shop
{
    // ------------------
    // -- COLUMNS -------
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(min=3)
     * @Assert\NotNull()
     */
    private $name;

    /**
     * @var string
     * @Assert\Length(min=3)
     * @Assert\NotNull()
     */
    private $adress;



    // ---------------------
    // --GETTER / SETTER ---
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
     * @return Shop
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set adress
     *
     * @param string $adress
     * @return Shop
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string 
     */
    public function getAdress()
    {
        return $this->adress;
    }
}
