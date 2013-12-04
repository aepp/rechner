<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BankTestbericht
 *
 * @ORM\Table(name="bank_testbericht")
 * @ORM\Entity
 */
class BankTestbericht
{
    /**
     * @var integer
     *
     * @ORM\Column(name="bank_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $bankId;

    /**
     * @var integer
     *
     * @ORM\Column(name="testbericht_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $testberichtId;



    /**
     * Set bankId
     *
     * @param integer $bankId
     * @return BankTestbericht
     */
    public function setBankId($bankId)
    {
        $this->bankId = $bankId;

        return $this;
    }

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
     * Set testberichtId
     *
     * @param integer $testberichtId
     * @return BankTestbericht
     */
    public function setTestberichtId($testberichtId)
    {
        $this->testberichtId = $testberichtId;

        return $this;
    }

    /**
     * Get testberichtId
     *
     * @return integer 
     */
    public function getTestberichtId()
    {
        return $this->testberichtId;
    }
}
