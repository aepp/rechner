<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Kategorie
 *
 * @ORM\Table(name="kategorie")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\KategorieRepository")
 * @Annotation\Name("kategorie")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Kategorie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="kategorie_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $kategorieId;

    /**
     * @var string
     *
     * @ORM\Column(name="kategorie_name", type="string", length=100, nullable=true)
     */
    private $kategorieName;



    /**
     * Get kategorieId
     *
     * @return integer 
     */
    public function getKategorieId()
    {
        return $this->kategorieId;
    }

    /**
     * Set kategorieName
     *
     * @param string $kategorieName
     * @return Kategorie
     */
    public function setKategorieName($kategorieName)
    {
        $this->kategorieName = $kategorieName;

        return $this;
    }

    /**
     * Get kategorieName
     *
     * @return string 
     */
    public function getKategorieName()
    {
        return $this->kategorieName;
    }
    
    public function jsonSerialize() {
    	return [
	    	'kategorieId' => $this->getKategorieId(),
	    	'kategorieName' => $this->getKategorieName(),
    	];
    }
}
