<?php
namespace Vergleichsrechner\Form;

use Zend\Form\Form;
use Zend\Form\Element;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Form\Element\ObjectSelect;
use Doctrine\Common\Persistence\ObjectManager;
use Vergleichsrechner\Entity\Kategorie;
use DoctrineModule\Form\Element\ObjectMultiCheckbox;

class AddProductForm extends Form implements ObjectManagerAwareInterface
{
	private $objectManager;
	
	public function init()
	{
		$jaNein = array(
					array(
							'label' =>'Ja', 
							'label_attributes' => array('class' => ''),
							'1' => 'Ja',
					), 
					array(
							'label' =>'Nein', 
							'label_attributes' => array('class' => ''),
							'0' => 'Nein',
					),
		);
		
		/*
		 * Setting up the form elements
		 */
		$kategorieId = new ObjectSelect();
		$produktartId = new ObjectSelect();
		$produktame = new Element\Text();
		$bankId = new ObjectSelect();
		$produktHasOnlineAbschluss = new Element\Radio();
		$produktMindestanlage = new Element\Text();
		$produktHoechstanlage = new Element\Text();
		$produktHasGesetzlEinlagvers = new Element\Radio();
		$einlagensicherungLandId = new ObjectSelect();
		$aktionId = new ObjectSelect();
		$produktKtofuehrKost = new Element\Text();
		$produktKtofuehrKostFllg = new ObjectSelect();
		$produktZinsgutschrift = new ObjectSelect();
		$produktVerfuegbarkeit = new ObjectSelect();
		$produktKuendbarkeit = new ObjectSelect();
		$produktHasOnlineBanking = new Element\Radio();
		$legitimationId = new ObjectSelect();
		$produktHasAltersbeschraenkung = new Element\Radio();
		$produktGueltigSeit = new Element\DateSelect();
		$produktCheck = new Element\Text();
		$produktTipp = new Element\Radio();
		$produktInformationen = new Element\Text();
		$produktUrl = new Element\Text();
		$produktKlickoutUrl = new Element\Text();
		$kontozugriffe = new ObjectMultiCheckbox();
		
		$kategorieId	
			->setName('kategorieId')
			->setLabel('Kategorie')
			->setLabelAttributes(array('class' => 'col-sm-2 control-label'))
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'kategorieId'
			))
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Kategorie',
					'property' => 'kategorieName',
					'empty_option'  => '--- Bitte wählen ---',
			));
		$produktartId	
			->setName('produktartId')
			->setLabel('Produktart')
			->setLabelAttributes(array('class' => 'col-sm-2 control-label'))
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktartId'
			))
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Produktart',
					'property' => 'produktartName',
					'empty_option'  => '--- Bitte wählen ---',
			));						
		$produktame	
			->setName('produktame')
			->setLabel('Produktname')
			->setLabelAttributes(array('class' => 'col-sm-2 control-label'))
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktame'
			));	
		$bankId	
			->setName('bankId')
			->setLabel('Bank')
			->setLabelAttributes(array('class' => 'col-sm-2 control-label'))
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'bankId'
			))
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Bank',
					'property' => 'bankName',
					'empty_option'  => '--- Bitte wählen ---',
			));		
		$produktHasOnlineAbschluss	
			->setName('produktHasOnlineAbschluss')
			->setLabel('Online-Abschluss?')
			->setLabelAttributes(array('class' => 'col-sm-2 control-label'))
			->setValueOptions($jaNein);
		$produktMindestanlage
			->setName('produktMindestanlage')
			->setLabel('Mindestanlage')
			->setLabelAttributes(array('class' => 'col-sm-2 control-label'))
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktMindestanlage'
			));
		$produktHoechstanlage
			->setName('produktHoechstanlage')
			->setLabel('Höchstanlage')
			->setLabelAttributes(array('class' => 'col-sm-2 control-label'))
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktHoechstanlage'
			));	
		$produktHasGesetzlEinlagvers
			->setName('produktHasGesetzlEinlagvers')
			->setLabel('Gesetzl. Einlagensicherung?')
			->setLabelAttributes(array('class' => 'col-sm-2 control-label'))
			->setValueOptions($jaNein);		
		$einlagensicherungLandId
			->setName('einlagensicherungLandId')
			->setLabel('Einlagensicherung Land')
			->setLabelAttributes(array('class' => 'col-sm-2 control-label'))
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'einlagensicherungLandId'
			))
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\EinlagensicherungLand',
					'property' => 'einlagensicherungLandName',
					'empty_option'  => '--- Bitte wählen ---',
			));
		$aktionId
			->setName('aktionId')
			->setLabel('Aktion')
			->setLabelAttributes(array('class' => 'col-sm-2 control-label'))
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'aktionId'
			))
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Aktion',
					'property' => 'aktionBeschreibung',
					'empty_option'  => '--- Bitte wählen ---',
			));
		
		/*
		 * Setting up the form
		 */		
		$this->setAttribute('method', 'post');
		$this->setAttribute('role', 'form');
		$this->setAttribute('class', 'form-horizontal');
		/*
		 * Adding elements to the form
		 */
		$this->add($kategorieId);
		$this->add($produktartId);
		$this->add($produktame);
		$this->add($bankId);
		$this->add($produktHasOnlineAbschluss);
		$this->add($produktMindestanlage);
		$this->add($produktHoechstanlage);
		$this->add($produktHasGesetzlEinlagvers);
		$this->add($einlagensicherungLandId);
		$this->add($aktionId);
// 		$this->add($produktKtofuehrKostFllg);
// 		$this->add($produktZinsgutschrift);
// 		$this->add($produktVerfuegbarkeit);
// 		$this->add($produktKuendbarkeit);
// 		$this->add($produktHasOnlineBanking);
// 		$this->add($legitimationId);
// 		$this->add($produktHasAltersbeschraenkung);
// 		$this->add($produktGueltigSeit);
// 		$this->add($produktCheck);
// 		$this->add($produktTipp);
// 		$this->add($produktUrl);
// 		$this->add($produktKlickoutUrl);
// 		$this->add($kontozugriffe);
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