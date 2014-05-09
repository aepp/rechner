<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EinlagensicherungLand
 *
 * @ORM\Table(name="einlagensicherung_land")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\EinlagensicherungLandRepository")
 */
class EinlagensicherungLand extends BaseEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="einlagensicherung_land_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $einlagensicherungLandId;

    /**
     * @var string
     *
     * @ORM\Column(name="einlagensicherung_land_name", type="string", length=100, nullable=true)
     */
    protected $einlagensicherungLandName;

    /**
     * Get einlagensicherungLandId
     *
     * @return integer 
     */
    public function getEinlagensicherungLandId() {
        return $this->einlagensicherungLandId;
    }

    /**
     * Set einlagensicherungLandName
     *
     * @param string $einlagensicherungLandName
     * @return EinlagensicherungLand
     */
    public function setEinlagensicherungLandName($einlagensicherungLandName) {
        $this->einlagensicherungLandName = $einlagensicherungLandName;

        return $this;
    }

    /**
     * Get einlagensicherungLandName
     *
     * @return string 
     */
    public function getEinlagensicherungLandName() {
        return $this->einlagensicherungLandName;
    }

}
