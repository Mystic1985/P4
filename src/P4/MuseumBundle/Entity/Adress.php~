<?php

namespace P4\MuseumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adress
 *
 * @ORM\Table(name="adress")
 * @ORM\Entity(repositoryClass="P4\MuseumBundle\Repository\AdressRepository")
 */
class Adress
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
     * @var int
     *
     * @ORM\Column(name="streetnumber", type="integer")
     */
    private $streetnumber;

    /**
     * @var string
     *
     * @ORM\Column(name="streetname", type="string", length=255)
     */
    private $streetname;

    /**
     * @var int
     *
     * @ORM\Column(name="zipcode", type="integer")
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set streetnumber
     *
     * @param integer $streetnumber
     *
     * @return Adress
     */
    public function setStreetnumber($streetnumber)
    {
        $this->streetnumber = $streetnumber;

        return $this;
    }

    /**
     * Get streetnumber
     *
     * @return int
     */
    public function getStreetnumber()
    {
        return $this->streetnumber;
    }

    /**
     * Set streetname
     *
     * @param string $streetname
     *
     * @return Adress
     */
    public function setStreetname($streetname)
    {
        $this->streetname = $streetname;

        return $this;
    }

    /**
     * Get streetname
     *
     * @return string
     */
    public function getStreetname()
    {
        return $this->streetname;
    }

    /**
     * Set zipcode
     *
     * @param integer $zipcode
     *
     * @return Adress
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return int
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Adress
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Adress
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
}
