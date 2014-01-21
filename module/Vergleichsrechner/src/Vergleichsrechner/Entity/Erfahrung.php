<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Erfahrung
 *
 * @ORM\Table(name="erfahrung")
 * @ORM\Entity(repositoryClass="Vergleichsrechner\Entity\Repository\ErfahrungRepository")
 */
class Erfahrung
{
    /**
     * @var integer
     *
     * @ORM\Column(name="erfahrung_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $erfahrungId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="erfahrung_datum", type="datetime", nullable=true)
     */
    protected $erfahrungDatum;


    /**
     * @var integer
     *
     * @ORM\Column(name="erfahrung_note", type="integer", nullable=true)
     */
    protected $erfahrungNote;

    /**
     * @var string
     *
     * @ORM\Column(name="erfahrung_bericht", type="text", nullable=true)
     */
    protected $erfahrungBericht;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="erfahrung_empf_bank", type="integer", nullable=true)
     */
    protected $erfahrungEmpfBank;

    /**
     * @var integer
     *
     * @ORM\Column(name="erfahrung_empf_produkt", type="integer", nullable=true)
     */
    protected $erfahrungEmpfProdukt;

    /**
     * @var string
     *
     * @ORM\Column(name="erfahrung_autor_name", type="text", nullable=true)
     */
    protected $erfahrungAutorName;

    /**
     * @var string
     *
     * @ORM\Column(name="erfahrung_autor_vorname", type="text", nullable=true)
     */
    protected $erfahrungAutorVorname;    

    /**
     * @var string
     *
     * @ORM\Column(name="erfahrung_autor_email", type="text", nullable=true)
     */
    protected $erfahrungAutorEmail;
    
    /**
     * @var string
     *
     * @ORM\Column(name="erfahrung_autor_username", type="text", nullable=true)
     */
    protected $erfahrungAutorUsername;

    /**
     * @var boolean
     *
     * @ORM\Column(name="erfahrung_is_freigeschaltet", type="boolean", nullable=true)
     */
    protected $erfahrungIsFreigeschaltet;
    
    /**
     * @var Bank
     *
     * @ORM\ManyToOne(targetEntity="Bank")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="bank_id")
     */
    protected $bank;
    
    /**
     * Get erfahrungId
     *
     * @return integer 
     */
    public function getErfahrungId()
    {
        return $this->erfahrungId;
    }

    /**
     * Set erfahrungBericht
     *
     * @param string $erfahrungBericht
     * @return Erfahrung
     */
    public function setErfahrungBericht($erfahrungBericht)
    {
        $this->erfahrungBericht = $erfahrungBericht;

        return $this;
    }

    /**
     * Get erfahrungBericht
     *
     * @return string 
     */
    public function getErfahrungBericht()
    {
        return $this->erfahrungBericht;
    }

    /**
     * Set erfahrungDatum
     *
     * @param \DateTime $erfahrungDatum
     * @return Erfahrung
     */
    public function setErfahrungDatum($erfahrungDatum)
    {
        $this->erfahrungDatum = $erfahrungDatum;

        return $this;
    }

    /**
     * Get erfahrungDatum
     *
     * @return \DateTime 
     */
    public function getErfahrungDatum()
    {
        return $this->erfahrungDatum;
    }
    
    public function getErfahrungNote() 
    {
		return $this->erfahrungNote;
    }
    
    public function setErfahrungNote($erfahrungNote) 
    {
      	$this->erfahrungNote = $erfahrungNote;
    }
    
    public function getErfahrungEmpfBank() 
    {
      	return $this->erfahrungEmpfBank;
    }
    
    public function setErfahrungEmpfBank($erfahrungEmpfBank ) 
    {
      	$this->erfahrungEmpfBank = $erfahrungEmpfBank ;
    }
    
    public function getErfahrungEmpfProdukt() 
    {
      	return $this->erfahrungEmpfProdukt;
    }
    
    public function setErfahrungEmpfProdukt($erfahrungEmpfProdukt ) 
    {
      	$this->erfahrungEmpfProdukt = $erfahrungEmpfProdukt ;
    }
    
    public function getErfahrungAutorName() 
    {
      	return $this->erfahrungAutorName;
    }
    
    public function setErfahrungAutorName($erfahrungAutorName ) 
    {
      	$this->erfahrungAutorName = $erfahrungAutorName ;
    }
    
    public function getErfahrungAutorVorname() 
    {
      	return $this->erfahrungAutorVorname;
    }
    
    public function setErfahrungAutorVorname($erfahrungAutorVorname ) 
    {
      	$this->erfahrungAutorVorname = $erfahrungAutorVorname ;
    }
    
    public function getErfahrungAutorEmail() 
    {
      	return $this->erfahrungAutorEmail;
    }
    
    public function setErfahrungAutorEmail($erfahrungAutorEmail ) 
    {
      	$this->erfahrungAutorEmail = $erfahrungAutorEmail ;
    }
    
    public function getErfahrungAutorUsername() 
    {
      	return $this->erfahrungAutorUsername;
    }
    
    public function setErfahrungAutorUsername($erfahrungAutorUsername ) 
    {
      	$this->erfahrungAutorUsername = $erfahrungAutorUsername ;
    }
    
        
    public function getErfahrungIsFreigeschaltet() 
    {
      return $this->erfahrungIsFreigeschaltet;
    }
    
    public function setErfahrungIsFreigeschaltet($erfahrungIsFreigeschaltet ) 
    {
      $this->erfahrungIsFreigeschaltet = $erfahrungIsFreigeschaltet ;
    }

    public function setBank($bank)
    {
    	$this->bank = $bank;
    }
    
    public function getBank()
    {
    	return $this->bank;
    }
}
