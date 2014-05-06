<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bank
 *
 * @ORM\Table(name="bank")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\BankRepository")
 */
class Bank extends BaseEntity{

    /**
     * @var integer
     *
     * @ORM\Column(name="bank_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $bankId;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_name", type="string", length=100, nullable=true)
     */
    protected $bankName;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_logo", type="string", length=255, nullable=true)
     */
    protected $bankLogo;

    /**
     * @var integer
     *
     * @ORM\Column(name="bank_dyn_id", type="integer", nullable=false)
     */
    protected $bankDynId;

    /**
     * @var Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Aktion", mappedBy="banken")
     * */
    protected $aktionen;

    public function __construct() {
        $this->aktionen = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get bankId
     *
     * @return integer 
     */
    public function getBankId() {
        return $this->bankId;
    }

    /**
     * Set bankName
     *
     * @param string $bankName
     * @return Bank
     */
    public function setBankName($bankName) {
        $this->bankName = $bankName;

        return $this;
    }

    /**
     * Get bankName
     *
     * @return string 
     */
    public function getBankName() {
        return $this->bankName;
    }

    /**
     * Set bankLogo
     *
     * @param string $bankLogo
     * @return Bank
     */
    public function setBankLogo($bankLogo) {
        $this->bankLogo = $bankLogo;

        return $this;
    }

    /**
     * Get bankLogo
     *
     * @return string 
     */
    public function getBankLogo() {
        return $this->bankLogo;
    }

    /**
     * Set aktionen
     *
     * @param Doctrine\Common\Collections\Collection $aktionen
     * @return Bank
     */
    public function setAktionen($aktionen) {
        $this->aktionen = $aktionen;

        return $this;
    }

    /**
     * Get aktionen
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAktionen() {
        return $this->aktionen;
    }

    /**
     * Add aktion
     *
     * @param Aktion $aktion
     * @return Bank
     */
    public function addAktion(Aktion $aktion) {
        if (!$this->aktionen->contains($aktion)) {
            $this->aktionen->add($aktion);
        }

        return $this;
    }

    /**
     * Remove aktion
     *
     * @param Aktion $aktion
     * @return Bank
     */
    public function removeAktion(Aktion $aktion) {
        if ($this->aktionen->contains($aktion)) {
            $this->aktionen->removeElement($aktion);
        }
        return $this;
    }

    public function getBankDynId() {
        return $this->bankDynId;
    }

    public function setBankDynId($bankDynId) {
        $this->bankDynId = $bankDynId;
    }
}
