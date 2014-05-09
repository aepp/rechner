<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kategorie
 *
 * @ORM\Table(name="kategorie")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\KategorieRepository")
 */
class Kategorie extends BaseEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="kategorie_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $kategorieId;

    /**
     * @var string
     *
     * @ORM\Column(name="kategorie_name", type="string", length=100, nullable=true)
     */
    protected $kategorieName;

    /**
     * Get kategorieId
     *
     * @return integer 
     */
    public function getKategorieId() {
        return $this->kategorieId;
    }

    /**
     * Set kategorieName
     *
     * @param string $kategorieName
     * @return Kategorie
     */
    public function setKategorieName($kategorieName) {
        $this->kategorieName = $kategorieName;

        return $this;
    }

    /**
     * Get kategorieName
     *
     * @return string 
     */
    public function getKategorieName() {
        return $this->kategorieName;
    }

}
