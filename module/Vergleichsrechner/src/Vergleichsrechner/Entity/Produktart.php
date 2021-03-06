<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produktart
 *
 * @ORM\Table(name="produktart")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\ProduktartRepository")
 */
class Produktart extends BaseEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="produktart_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $produktartId;

    /**
     * @var string
     *
     * @ORM\Column(name="produktart_name", type="string", length=100, nullable=true)
     */
    protected $produktartName;

    /**
     * @var Kategorie
     *
     * @ORM\ManyToOne(targetEntity="Kategorie")
     * @ORM\JoinColumn(name="kategorie_id", referencedColumnName="kategorie_id")
     */
    protected $kategorie;

    /**
     * Get produktartId
     *
     * @return integer 
     */
    public function getProduktartId() {
        return $this->produktartId;
    }

    /**
     * Set produktartName
     *
     * @param string $produktartName
     * @return Produktart
     */
    public function setProduktartName($produktartName) {
        $this->produktartName = $produktartName;

        return $this;
    }

    /**
     * Get produktartName
     *
     * @return string 
     */
    public function getProduktartName() {
        return $this->produktartName;
    }

    /**
     * Set kategorie
     *
     * @param Kategorie $kategorieId
     * @return Produkt
     */
    public function setKategorie($kategorie) {
        $this->kategorie = $kategorie;

        return $this;
    }

    /**
     * Get kategorie
     *
     * @return Kategorie
     */
    public function getKategorie() {
        return $this->kategorie;
    }

    public function jsonSerialize() {
        $json = parent::jsonSerialize();
        $json['kategorie'] = $this->getKategorie()->jsonSerialize();
        return $json;
    }

}
