<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;

/**
 * Kontozugriff
 *
 * @ORM\Table(name="kontozugriff")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\KontozugriffRepository")
 */
class Kontozugriff extends BaseEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="kontozugriff_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $kontozugriffId;

    /**
     * @var string
     *
     * @ORM\Column(name="kontozugriff_name", type="string", length=100, nullable=true)
     */
    protected $kontozugriffName;

    public function __construct() {
        $this->produkte = new Collections\ArrayCollection();
    }

    /**
     * Get kontozugriffId
     *
     * @return integer 
     */
    public function getKontozugriffId() {
        return $this->kontozugriffId;
    }

    /**
     * Set kontozugriffName
     *
     * @param string $kontozugriffName
     * @return Kontozugriff
     */
    public function setKontozugriffName($kontozugriffName) {
        $this->kontozugriffName = $kontozugriffName;

        return $this;
    }

    /**
     * Get kontozugriffName
     *
     * @return string 
     */
    public function getKontozugriffName() {
        return $this->kontozugriffName;
    }

}
