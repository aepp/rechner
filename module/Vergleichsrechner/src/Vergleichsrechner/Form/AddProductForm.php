<?php
namespace Vergleichsrechner\Form;

use Zend\Form\Form;
use Zend\Form\Element;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Vergleichsrechner\Entity\Kategorie;

class AddProductForm extends Form implements ObjectManagerAwareInterface
{
	private $objectManager;
	
	public function init()
	{
// 		$name = new Element\Text('name');
// 		$name->setOptions( array('label' => 'Kategoriebezeichnung'));
// 		$this->add($name);
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'produktKtegorie',
				'type' => 'DoctrineModule\Form\Element\ObjectSelect',
				'attributes' => array(
						'class' => 'form-control',
				),
				'options' => array(
						'label' => 'Kategorie: ',
						'object_manager' => $this->getObjectManager(),
						'target_class' => 'Vergleichsrechner\Entity\Kategorie',
						'property' => 'kategorieName',
						'empty_option'  => '--- Bitte wählen ---',
				)
		));	
	
// 		$this->setInputFilter($this->createInputFilter());
	}
		
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
    }
    
    public function setObjectManager(ObjectManager $objectManager) 
    {
    	$this->objectManager = $objectManager;
    }
    public function getObjectManager() 
    {
    	return $this->objectManager;
    }
}