<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GeldanlageKondition
 *
 * @ORM\Table(name="geldanlage_kondition")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\GeldanlageKonditionRepository")
 */
class GeldanlageKondition extends BaseEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="kondition_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $konditionId;

    /**
     * @var float
     *
     * @ORM\Column(name="kondition_laufzeit", type="integer", nullable=false)
     */
    protected $konditionLaufzeit;

    /**
     * @var float
     *
     * @ORM\Column(name="kondition_einlage_von", type="float", precision=10, scale=0, nullable=false)
     */
    protected $konditionEinlageVon;

    /**
     * @var float
     *
     * @ORM\Column(name="kondition_einlage_bis", type="float", precision=10, scale=0, nullable=false)
     */
    protected $konditionEinlageBis;

    /**
     * @var float
     *
     * @ORM\Column(name="kondition_zinssatz", type="float", precision=10, scale=0, nullable=false)
     */
    protected $konditionZinssatz;

    /**
     * @var Produkt
     * 
     * @ORM\ManyToOne(targetEntity="Geldanlage", inversedBy="konditionen")
     * @ORM\JoinColumn(name="produkt_id", referencedColumnName="produkt_id", nullable=true)
     * */
    protected $produkt;

    /**
     * 
     * @return integer
     */
    public function getKonditionId() {
        return $this->konditionId;
    }

    /**
     * 
     * @return float#
     */
    public function getKonditionEinlageVon() {
        return $this->konditionEinlageVon;
    }

    /**
     * 
     * @param float $konditionEinlageVon
     */
    public function setKonditionEinlageVon($konditionEinlageVon) {
        $this->konditionEinlageVon = $konditionEinlageVon;
    }

    /**
     * 
     * @return float
     */
    public function getKonditionEinlageBis() {
        return $this->konditionEinlageBis;
    }

    /**
     * 
     * @param float $konditionEinlageBis
     */
    public function setKonditionEinlageBis($konditionEinlageBis) {
        $this->konditionEinlageBis = $konditionEinlageBis;
    }

    /**
     * 
     * @return float
     */
    public function getKonditionZinssatz() {
        return $this->konditionZinssatz;
    }

    /**
     * 
     * @param float $konditionZinssatz
     */
    public function setKonditionZinssatz($konditionZinssatz) {
        $this->konditionZinssatz = $konditionZinssatz;
    }

    /**
     * 
     * @return Geldanlage
     */
    public function getProdukt() {
        return $this->produkt;
    }

    /**
     * 
     * @param Geldanlage $produkt
     */
    public function setProdukt($produkt) {
        $this->produkt = $produkt;
    }

    /**
     * 
     * @return integer
     */
    public function getKonditionLaufzeit() {
        return $this->konditionLaufzeit;
    }

    /**
     * 
     * @param integer $konditionLaufzeit
     */
    public function setKonditionLaufzeit($konditionLaufzeit) {
        $this->konditionLaufzeit = $konditionLaufzeit;
    }

}
