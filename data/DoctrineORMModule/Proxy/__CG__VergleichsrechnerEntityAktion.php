<?php

namespace DoctrineORMModule\Proxy\__CG__\Vergleichsrechner\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Aktion extends \Vergleichsrechner\Entity\Aktion implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'aktionId', 'aktionBeschreibung', 'aktionStartOn', 'aktionEndeOn', 'aktionIsZuende');
        }

        return array('__isInitialized__', 'aktionId', 'aktionBeschreibung', 'aktionStartOn', 'aktionEndeOn', 'aktionIsZuende');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Aktion $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getAktionId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getAktionId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAktionId', array());

        return parent::getAktionId();
    }

    /**
     * {@inheritDoc}
     */
    public function setAktionBeschreibung($aktionBeschreibung)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAktionBeschreibung', array($aktionBeschreibung));

        return parent::setAktionBeschreibung($aktionBeschreibung);
    }

    /**
     * {@inheritDoc}
     */
    public function getAktionBeschreibung()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAktionBeschreibung', array());

        return parent::getAktionBeschreibung();
    }

    /**
     * {@inheritDoc}
     */
    public function setAktionStartOn($aktionStartOn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAktionStartOn', array($aktionStartOn));

        return parent::setAktionStartOn($aktionStartOn);
    }

    /**
     * {@inheritDoc}
     */
    public function getAktionStartOn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAktionStartOn', array());

        return parent::getAktionStartOn();
    }

    /**
     * {@inheritDoc}
     */
    public function setAktionEndeOn($aktionEndeOn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAktionEndeOn', array($aktionEndeOn));

        return parent::setAktionEndeOn($aktionEndeOn);
    }

    /**
     * {@inheritDoc}
     */
    public function getAktionEndeOn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAktionEndeOn', array());

        return parent::getAktionEndeOn();
    }

    /**
     * {@inheritDoc}
     */
    public function setAktionIsZuende($aktionIsZuende)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAktionIsZuende', array($aktionIsZuende));

        return parent::setAktionIsZuende($aktionIsZuende);
    }

    /**
     * {@inheritDoc}
     */
    public function getAktionIsZuende()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAktionIsZuende', array());

        return parent::getAktionIsZuende();
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'jsonSerialize', array());

        return parent::jsonSerialize();
    }

}
