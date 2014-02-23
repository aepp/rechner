<?php
namespace Vergleichsrechner\Form;

use Zend\Form\Form;
use Zend\Form\Element;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Form\Element\ObjectRadio;
use Doctrine\Common\Persistence\ObjectManager;
use Vergleichsrechner\Entity\Kategorie;
use DoctrineModule\Form\Element\ObjectMultiCheckbox;
use Zend\Text\Table\Table;

class GeldanlageForm extends Form implements ObjectManagerAwareInterface
{
	private $objectManager;
	
	public function init()
	{
		$jaNein = array(
					array(
							'label' =>'ja', 
							'label_attributes' => array('class' => ''),
							'1' => 'Ja',
							'value' => 1
					), 
					array(
							'label' =>'nein', 
							'label_attributes' => array('class' => ''),
							'0' => 'Nein',
							'value' => 0
					),
		);
		$labelAttributes = array('class' => 'col-lg-4 col-md-4 col-sm-4 col-xs-12 control-label');
		/*
		 * Setting up the form elements
		 */
		$kategorie = new ObjectSelect();
		$produktart = new ObjectSelect();
		$produktName = new Element\Text();
		$bank = new ObjectSelect();
		$produktHasOnlineAbschluss = new Element\Radio();
		$zinssatz = new ObjectRadio();
		$produktMindestanlage = new Element\Text();
		$produktHoechstanlage = new Element\Text();
		$produktHasGesetzlEinlagvers = new Element\Radio();
		$einlagensicherungLand = new ObjectSelect();
		$aktion = new Element\Select();
		$produktKtofuehrKost = new Element\Text();
		$produktKtofuehrKostFllg = new ObjectRadio();
		$produktZinsgutschrift = new ObjectSelect();
		$produktVerfuegbarkeit = new ObjectSelect();
		$produktKuendbarkeit = new ObjectSelect();
		$produktHasOnlineBanking = new Element\Radio();
		$legitimation = new ObjectRadio();
		$produktHasAltersbeschraenkung = new Element\Radio();
		$produktGueltigSeit = new Element\Text();
		$produktCheck = new Element\Text();
		$produktTipp = new Element\Radio();
		$produktInformationen = new Element\Textarea();
		$produktUrl = new Element\Text();
		$produktKlickoutUrl = new Element\Text();
		$ktozugriffe = new ObjectMultiCheckbox();
		$modus = new Element\Hidden();
		
		$kategorie	
			->setName('kategorie')
			->setLabel('Kategorie')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control validate[required]',
					'id' => 'kategorie',
					'disabled' => 'disabled',
			))
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Kategorie',
					'property' => 'kategorieName',
					'is_method'      => true,
					'find_method'    => array(
							'name'   => 'findBy',
							'params' => array(
									'criteria' => array('kategorieId' => 1),
							),
					),
			));
		$produktart
			->setName('produktart')
			->setLabel('Produktart')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control validate[required]',
					'id' => 'produktart'
			))
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Produktart',
					'property' => 'produktartName',
					'is_method'      => true,
					'find_method'    => array(
							'name'   => 'findBy',
							'params' => array(
									'criteria' => array('kategorie' => 1),
									'orderBy'  => array('produktartName' => 'ASC'),
							),
					),
					'empty_option'  => '--- Bitte wählen ---',
			));						
		$produktName	
			->setName('produktName')
			->setLabel('Produktname')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control validate[required]',
					'id' => 'produktName'
			));	
		$bank	
			->setName('bank')
			->setLabel('Bank')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control validate[required]',
					'id' => 'bank'
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
			->setLabelAttributes($labelAttributes)
			->setValueOptions($jaNein);
		$produktMindestanlage
			->setName('produktMindestanlage')
			->setLabel('Mindestanlage')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control validate[custom[numberKom]]',
					'id' => 'produktMindestanlage'
			));
		$zinssatz
			->setName('zinssatz')
			->setLabel('Zinssatz')
			->setLabelAttributes($labelAttributes)
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Zinssatz',
					'property' => 'zinssatzName',
					'empty_option'  => '--- Bitte wählen ---',
			));
		$produktHoechstanlage
			->setName('produktHoechstanlage')
			->setLabel('Höchstanlage')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control validate[custom[numberKom]]',
					'id' => 'produktHoechstanlage'
			));	
		$produktHasGesetzlEinlagvers
			->setName('produktHasGesetzlEinlagvers')
			->setLabel('Gesetzl. Einlagensicherung?')
			->setLabelAttributes($labelAttributes)
			->setValueOptions($jaNein);		
		$einlagensicherungLand
			->setName('einlagensicherungLand')
			->setLabel('Einlagensicherung Land')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'einlagensicherungLand'
			))
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\EinlagensicherungLand',
					'property' => 'einlagensicherungLandName',
					'empty_option'  => '--- Bitte wählen ---',
			));
		$aktion
			->setName('aktion')
			->setLabel('Aktion')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'aktion'
			))
			->setOptions(array(
					'empty_option'  => '--- Bitte wählen ---',
			));			
		$produktKtofuehrKost
			->setName('produktKtofuehrKost')
			->setLabel('Kontoführungskosten')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktKtofuehrKost'
			));	
		$produktKtofuehrKostFllg
			->setName('produktKtofuehrKostFllg')
			->setLabel(' ')
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Zeitabschnitt',
					'property' => 'zeitabschnittName',
					'is_method'      => true,
					'find_method'    => array(
							'name'   => 'findYearandMonth'
					),
			));
		$produktZinsgutschrift
			->setName('produktZinsgutschrift')
			->setLabel('Zinsgutschrift')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktZinsgutschrift'
			))
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Zeitabschnitt',
					'property' => 'zeitabschnittName',
					'empty_option'  => '--- Bitte wählen ---',
			));		
		$produktVerfuegbarkeit
			->setName('produktVerfuegbarkeit')
			->setLabel('Verfügbarkeit')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktVerfuegbarkeit'
			))
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Zeitabschnitt',
					'property' => 'zeitabschnittName',
					'empty_option'  => '--- Bitte wählen ---',
			));					
		$produktKuendbarkeit
			->setName('produktKuendbarkeit')
			->setLabel('Kündbarkeit')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktKuendbarkeit'
			))
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Zeitabschnitt',
					'property' => 'zeitabschnittName',
					'empty_option'  => '--- Bitte wählen ---',
			));					
		$produktHasOnlineBanking	
			->setName('produktHasOnlineBanking')
			->setLabel('Online-Banking?')
			->setLabelAttributes($labelAttributes)
			->setValueOptions($jaNein);
		$legitimation
			->setName('legitimation')
			->setLabel('Legitimation')
			->setLabelAttributes($labelAttributes)
			->setOptions(array(
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Legitimation',
					'property' => 'legitimationName',
					'empty_option'  => '--- Bitte wählen ---',
			));		
		$produktHasAltersbeschraenkung
			->setName('produktHasAltersbeschraenkung')
			->setLabel('Altersbeschränkung?')
			->setLabelAttributes($labelAttributes)
			->setValueOptions($jaNein);	
		$produktGueltigSeit
			->setName('produktGueltigSeit')
			->setLabel('Gültig seit')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktGueltigSeit',
			))
			->setOptions(array(
					'min_year' => date('Y') - 5,
					'max_year' => date('Y') + 2,
			));		
		$produktCheck
			->setName('produktCheck')
			->setLabel('Produktcheck')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control validate[custom[numberKom]]',
					'id' => 'produktCheck'
			));
		$produktTipp
			->setName('produktTipp')
			->setLabel('Tipp?')
			->setLabelAttributes($labelAttributes)
			->setValueOptions($jaNein);
		$produktUrl
			->setName('produktUrl')
			->setLabel('Produkt-URL')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktUrl'
		));
		$produktKlickoutUrl
			->setName('produktKlickoutUrl')
			->setLabel('Klickout-URL')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktKlickoutUrl'
		));
		$ktozugriffe
			->setName('ktozugriffe')
			->setLabel('Kontozugriff')
			->setLabelAttributes($labelAttributes)
			->setOptions(array(
					'empty_option'  => '--- Bitte wählen ---',
					'object_manager' => $this->getObjectManager(),
					'target_class' => 'Vergleichsrechner\Entity\Kontozugriff',
					'property' => 'kontozugriffName',
			));
		$produktInformationen
			->setName('produktInformationen')
			->setLabel('Informationen')
			->setLabelAttributes($labelAttributes)
			->setAttributes(array(
					'class' => 'form-control',
					'id' => 'produktInformationen'
			));		
		$modus
			->setName('modus')
			->setValue('create')
			->setAttribute('id', 'modus')
			->setLabel('Modus')
			->setLabelAttributes(array(
				'class' => 'hidden'
			));
		/*
		 * Setting up the form
		 */		
		$this
			->setName('addProductForm')
			->setLabel('Produkt hinzufügen')
			->setAttributes(array(
					'method' => 'post',
					'role' =>'form',
					'class' => 'form-horizontal',
					'id' => 'produkt-form'
			));
		
		/*
		 * Adding elements to the form
		 */
		$this->add($kategorie);
		$this->add($produktart);
		$this->add($produktName);
		$this->add($bank);
		$this->add($aktion);
		$this->add($zinssatz);
		$this->add($produktHasOnlineAbschluss);
		$this->add($produktKtofuehrKost);
		$this->add($produktCheck);
		$this->add($produktTipp);
		
		$this->add($legitimation);
		$this->add($produktHasAltersbeschraenkung);
			
		$this->add($produktMindestanlage);
		$this->add($produktHoechstanlage);
		$this->add($produktHasGesetzlEinlagvers);
		$this->add($einlagensicherungLand);
		$this->add($produktZinsgutschrift);
		$this->add($produktVerfuegbarkeit);
		$this->add($produktKuendbarkeit);
		$this->add($produktHasOnlineBanking);
		$this->add($ktozugriffe);
		
		$this->add($produktInformationen);
		$this->add($produktGueltigSeit);
		$this->add($produktUrl);
		$this->add($produktKlickoutUrl);
		
		$this->add($modus);
		
		$this->add($produktKtofuehrKostFllg);
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