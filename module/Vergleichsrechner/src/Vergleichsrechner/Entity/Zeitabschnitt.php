<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zeitabschnitt
 *
 * @ORM\Table(name="zeitabschnitt")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\ZeitabschnittRepository")
 */
class Zeitabschnitt extends BaseEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="zeitabschnitt_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $zeitabschnittId;

    /**
     * @var string
     *
     * @ORM\Column(name="zeitabschnitt_name", type="string", length=100, nullable=false)
     */
    protected $zeitabschnittName;

    /**
     * @var integer
     *
     * @ORM\Column(name="zeitabschnitt_anz_zinsperioden", type="integer", nullable=true)
     */
    protected $zeitabschnittAnzZinsperioden;

    /**
     * @var string
     *
     * @ORM\Column(name="zeitabschnitt_name2", type="string", length=100, nullable=false)
     */
    protected $zeitabschnittName2;

    /**
     * Get zeitabschnittId
     *
     * @return integer 
     */
    public function getZeitabschnittId() {
        return $this->zeitabschnittId;
    }

    /**
     * Set zeitabschnittName
     *
     * @param string $zeitabschnittName
     * @return Zeitabschnitt
     */
    public function setZeitabschnittName($zeitabschnittName) {
        $this->zeitabschnittName = $zeitabschnittName;

        return $this;
    }

    /**
     * Get zeitabschnittName
     *
     * @return string 
     */
    public function getZeitabschnittName() {
        return $this->zeitabschnittName;
    }

    /**
     * Set zeitabschnittAnzZinsperioden
     *
     * @param integer $zeitabschnittAnzZinsperioden
     * @return Zeitabschnitt
     */
    public function setZeitabschnittAnzZinsperioden($zeitabschnittAnzZinsperioden) {
        $this->zeitabschnittAnzZinsperioden = $zeitabschnittAnzZinsperioden;

        return $this;
    }

    /**
     * Get zeitabschnittAnzZinsperioden
     *
     * @return integer 
     */
    public function getZeitabschnittAnzZinsperioden() {
        return $this->zeitabschnittAnzZinsperioden;
    }

    /**
     * Set zeitabschnittName2
     *
     * @param string $zeitabschnittName2
     * @return Zeitabschnitt
     */
    public function setZeitabschnittName2($zeitabschnittName2) {
        $this->zeitabschnittName2 = $zeitabschnittName2;

        return $this;
    }

    /**
     * Get zeitabschnittName2
     *
     * @return string
     */
    public function getZeitabschnittName2() {
        return $this->zeitabschnittName2;
    }

}
