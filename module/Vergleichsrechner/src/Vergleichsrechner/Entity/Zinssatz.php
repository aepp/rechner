<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zinssatz
 *
 * @ORM\Table(name="zinssatz")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\ZinssatzRepository")
 */
class Zinssatz extends BaseEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="zinssatz_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $zinssatzId;

    /**
     * @var string
     *
     * @ORM\Column(name="zinssatz_name", type="string", length=100, nullable=true)
     */
    protected $zinssatzName;

    /**
     * Get zinssatzId
     *
     * @return integer
     */
    public function getZinssatzId() {
        return $this->zinssatzId;
    }

    /**
     * Set zinssatzName
     *
     * @param string $zinssatzName
     * @return Zinssatz
     */
    public function setZinssatzName($zinssatzName) {
        $this->zinssatzName = $zinssatzName;

        return $this;
    }

    /**
     * Get zinssatzName
     *
     * @return string
     */
    public function getZinssatzName() {
        return $this->zinssatzName;
    }

}
