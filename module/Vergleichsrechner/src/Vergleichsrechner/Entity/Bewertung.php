<?php

namespace Vergleichsrechner\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Bewertung
 *
 * @ORM\Table(name="bewertung")
 * @ORM\Entity
 */
class Bewertung
{
    /**
     * @var integer
     *
     * @ORM\Column(name="bewertung_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $bewertungId;

    /**
     * @var string
     *
     * @ORM\Column(name="bewertung_text", type="text", nullable=true)
     */
    protected $bewertungText;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bewertung_datum", type="datetime", nullable=true)
     */
    protected $bewertungDatum;

    /**
     * @var string
     *
     * @ORM\Column(name="bewertung_verfasser", type="string", length=100, nullable=true)
     */
    protected $bewertungVerfasser;

    /**
     * @var string
     *
     * @ORM\Column(name="bewertung_verfasser_email", type="string", length=100, nullable=true)
     */
    protected $bewertungVerfasserEmail;

    /**
     * @var float
     *
     * @ORM\Column(name="bewertung_note", type="float", precision=10, scale=0, nullable=true)
     */
    protected $bewertungNote;

    /**
     * @var string
     *
     * @ORM\Column(name="bewertung_url", type="text", nullable=true)
     */
    protected $bewertungUrl;
    

    /**
     * Get bewertungId
     *
     * @return integer 
     */
    public function getBewertungId()
    {
        return $this->bewertungId;
    }

    /**
     * Set bewertungText
     *
     * @param string $bewertungText
     * @return Bewertung
     */
    public function setBewertungText($bewertungText)
    {
        $this->bewertungText = $bewertungText;

        return $this;
    }

    /**
     * Get bewertungText
     *
     * @return string 
     */
    public function getBewertungText()
    {
        return $this->bewertungText;
    }

    /**
     * Set bewertungDatum
     *
     * @param \DateTime $bewertungDatum
     * @return Bewertung
     */
    public function setBewertungDatum($bewertungDatum)
    {
        $this->bewertungDatum = $bewertungDatum;

        return $this;
    }

    /**
     * Get bewertungDatum
     *
     * @return \DateTime 
     */
    public function getBewertungDatum()
    {
        return $this->bewertungDatum;
    }

    /**
     * Set bewertungVerfasser
     *
     * @param string $bewertungVerfasser
     * @return Bewertung
     */
    public function setBewertungVerfasser($bewertungVerfasser)
    {
        $this->bewertungVerfasser = $bewertungVerfasser;

        return $this;
    }

    /**
     * Get bewertungVerfasser
     *
     * @return string 
     */
    public function getBewertungVerfasser()
    {
        return $this->bewertungVerfasser;
    }

    /**
     * Set bewertungVerfasserEmail
     *
     * @param string $bewertungVerfasserEmail
     * @return Bewertung
     */
    public function setBewertungVerfasserEmail($bewertungVerfasserEmail)
    {
        $this->bewertungVerfasserEmail = $bewertungVerfasserEmail;

        return $this;
    }

    /**
     * Get bewertungVerfasserEmail
     *
     * @return string 
     */
    public function getBewertungVerfasserEmail()
    {
        return $this->bewertungVerfasserEmail;
    }

    /**
     * Set bewertungNote
     *
     * @param float $bewertungNote
     * @return Bewertung
     */
    public function setBewertungNote($bewertungNote)
    {
        $this->bewertungNote = $bewertungNote;

        return $this;
    }

    /**
     * Get bewertungNote
     *
     * @return float 
     */
    public function getBewertungNote()
    {
        return $this->bewertungNote;
    }

    /**
     * Set bewertungUrl
     *
     * @param string $bewertungUrl
     * @return Bewertung
     */
    public function setBewertungUrl($bewertungUrl)
    {
        $this->bewertungUrl = $bewertungUrl;

        return $this;
    }

    /**
     * Get bewertungUrl
     *
     * @return string 
     */
    public function getBewertungUrl()
    {
        return $this->bewertungUrl;
    }
}
