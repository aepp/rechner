<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Testbericht
 *
 * @ORM\Table(name="testbericht")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\TestberichtRepository")
 * @Annotation\Name("testbericht")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Testbericht
{
    /**
     * @var integer
     *
     * @ORM\Column(name="testbericht_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $testberichtId;

    /**
     * @var string
     *
     * @ORM\Column(name="testbericht_text", type="text", nullable=true)
     */
    protected $testberichtText;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="testbericht_datum", type="datetime", nullable=true)
     */
    protected $testberichtDatum;



    /**
     * Get testberichtId
     *
     * @return integer 
     */
    public function getTestberichtId()
    {
        return $this->testberichtId;
    }

    /**
     * Set testberichtText
     *
     * @param string $testberichtText
     * @return Testbericht
     */
    public function setTestberichtText($testberichtText)
    {
        $this->testberichtText = $testberichtText;

        return $this;
    }

    /**
     * Get testberichtText
     *
     * @return string 
     */
    public function getTestberichtText()
    {
        return $this->testberichtText;
    }

    /**
     * Set testberichtDatum
     *
     * @param \DateTime $testberichtDatum
     * @return Testbericht
     */
    public function setTestberichtDatum($testberichtDatum)
    {
        $this->testberichtDatum = $testberichtDatum;

        return $this;
    }

    /**
     * Get testberichtDatum
     *
     * @return \DateTime 
     */
    public function getTestberichtDatum()
    {
        return $this->testberichtDatum;
    }
}
