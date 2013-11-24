<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Bank
 *
 * @ORM\Table(name="bank")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\BankRepository")
 * @Annotation\Name("bank")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Bank
{
    /**
     * @var integer
     *
     * @ORM\Column(name="bank_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $bankId;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_name", type="string", length=100, nullable=true)
     */
    private $bankName;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_logo", type="string", length=255, nullable=true)
     */
    private $bankLogo;



    /**
     * Get bankId
     *
     * @return integer 
     */
    public function getBankId()
    {
        return $this->bankId;
    }

    /**
     * Set bankName
     *
     * @param string $bankName
     * @return Bank
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;

        return $this;
    }

    /**
     * Get bankName
     *
     * @return string 
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set bankLogo
     *
     * @param string $bankLogo
     * @return Bank
     */
    public function setBankLogo($bankLogo)
    {
        $this->bankLogo = $bankLogo;

        return $this;
    }

    /**
     * Get bankLogo
     *
     * @return string 
     */
    public function getBankLogo()
    {
        return $this->bankLogo;
    }
    public function jsonSerialize() {
    	return [
    	'bankId' => $this->getBankId(),
    	'bankName' => $this->getBankName(),
    	'bankLogo' => $this->getBankLogo(),
    	];
    }
}
