<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RKVAbschluss
 *
 * @ORM\Table(name="rkv_abschluss")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\RKVAbschlussRepository")
 */
class RKVAbschluss extends BaseEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="rkv_abschluss_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $rkvAbschlussId;

    /**
     * @var string
     *
     * @ORM\Column(name="rkv_abschluss_name", type="text", nullable=false)
     */
    protected $rkvAbschlussName;

    public function __construct() {
        
    }

    /**
     * Get rkvAbschlussId
     *
     * @return integer 
     */
    public function getRkvAbschlussId() {
        return $this->rkvAbschlussId;
    }

    /**
     * Set rkvAbschlussName
     *
     * @param string $rkvAbschlussName
     * @return Aktion
     */
    public function setRkvAbschlussName($rkvAbschlussName) {
        $this->rkvAbschlussName = $rkvAbschlussName;

        return $this;
    }

    /**
     * Get rkvAbschlussName
     *
     * @return string
     */
    public function getRkvAbschlussName() {
        return $this->rkvAbschlussName;
    }

}
