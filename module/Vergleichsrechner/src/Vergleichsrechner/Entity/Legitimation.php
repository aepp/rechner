<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Legitimation
 *
 * @ORM\Table(name="legitimation")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\LegitimationRepository")
 */
class Legitimation extends BaseEntity {

    /**
     * @var integer
     *
     * @ORM\Column(name="legitimation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $legitimationId;

    /**
     * @var string
     *
     * @ORM\Column(name="legitimation_name", type="string", length=100, nullable=true)
     */
    protected $legitimationName;

    /**
     * Get legitimationId
     *
     * @return integer 
     */
    public function getLegitimationId() {
        return $this->legitimationId;
    }

    /**
     * Set legitimationName
     *
     * @param string $legitimationName
     * @return Legitimation
     */
    public function setLegitimationName($legitimationName) {
        $this->legitimationName = $legitimationName;

        return $this;
    }

    /**
     * Get legitimationName
     *
     * @return string 
     */
    public function getLegitimationName() {
        return $this->legitimationName;
    }

}
