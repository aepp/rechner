<?php

namespace Vergleichsrechner\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Form\Element\ObjectSelect;
use Doctrine\Common\Persistence\ObjectManager;
use DoctrineModule\Form\Element\ObjectMultiCheckbox;
use DoctrineModule\Form\Element\ObjectRadio;

class KreditForm extends Form implements ObjectManagerAwareInterface {

    private $objectManager;

    public function init() {
        $jaNein = array(
            array(
                'label' => 'ja',
                'label_attributes' => array('class' => ''),
                '1' => 'Ja',
                'value' => 1
            ),
            array(
                'label' => 'nein',
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
        $produktMinKredit = new Element\Text();
        $produktMaxKredit = new Element\Text();
        $zinssatz = new ObjectRadio();
        $produktIsBonitabh = new Element\Radio();
        $aktion = new Element\Select();
        $produktKtofuehrKost = new Element\Text();
        $produktKtofuehrKostFllg = new ObjectRadio();
        $produktBearbeitungsgebuehr = new Element\Text();
        $produktWiderrufsfrist = new Element\Text();
        $produktWiderrufsfristZeiteinh = new ObjectRadio();
        $produktSondertilgungen = new Element\Text();
        $produktGueltigSeit = new Element\Text();
        $produktCheck = new Element\Text();
        $produktTipp = new Element\Radio();
        $produktInformationen = new Element\Textarea();
        $produktUrl = new Element\Text();
        $produktKlickoutUrl = new Element\Text();
        $ktozugriffe = new ObjectMultiCheckbox();
        $modus = new Element\Hidden();
        $produktEffektiverJahreszins = new Element\Text();
        $produktAnnahmerichtlinie = new Element\Textarea();
        $produktSollzins = new Element\Text();
        $produktGesamtbetrag = new Element\Text();
        $produktNettokreditsumme = new Element\Text();
        $rkvAbschluss = new ObjectRadio();
        $produktLaufzeit = new Element\Text();
        $legitimation = new ObjectRadio();
        $ktozugriffe = new ObjectMultiCheckbox();

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
                    'is_method' => true,
                    'find_method' => array(
                        'name' => 'findBy',
                        'params' => array(
                            'criteria' => array('kategorieId' => 2),
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
                    'is_method' => true,
                    'find_method' => array(
                        'name' => 'findBy',
                        'params' => array(
                            'criteria' => array('kategorie' => 2),
                            'orderBy' => array('produktartName' => 'ASC'),
                        ),
                    ),
                    'empty_option' => '--- Bitte wählen ---',
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
                    'empty_option' => '--- Bitte wählen ---',
        ));
        $produktHasOnlineAbschluss
                ->setName('produktHasOnlineAbschluss')
                ->setLabel('Online-Abschluss?')
                ->setLabelAttributes($labelAttributes)
                ->setValueOptions($jaNein);
        $zinssatz
                ->setName('zinssatz')
                ->setLabel('Zinssatz')
                ->setLabelAttributes($labelAttributes)
                ->setOptions(array(
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Vergleichsrechner\Entity\Zinssatz',
                    'property' => 'zinssatzName'
        ));
        $produktMinKredit
                ->setName('produktMinKredit')
                ->setLabel('Min. Kredit')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control validate[custom[numberKom]]',
                    'id' => 'produktMinKredit'
        ));
        $produktMaxKredit
                ->setName('produktMaxKredit')
                ->setLabel('Max. Kredit')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control validate[custom[numberKom]]',
                    'id' => 'produktMaxKredit'
        ));
        $produktIsBonitabh
                ->setName('produktIsBonitabh')
                ->setLabel('Bonitätsabhängig?')
                ->setLabelAttributes($labelAttributes)
                ->setValueOptions($jaNein);
        $aktion
                ->setName('aktion')
                ->setLabel('Aktion')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control',
                    'id' => 'aktion'
                ))
                ->setOptions(array(
                    'empty_option' => '--- Bitte wählen ---',
        ));
        $produktKtofuehrKost
                ->setName('produktKtofuehrKost')
                ->setLabel('Kontoführungskosten')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control validate[custom[numberKom]]',
                    'id' => 'produktKtofuehrKost'
        ));
        $produktKtofuehrKostFllg
                ->setName('produktKtofuehrKostFllg')
                ->setLabel(' ')
                ->setOptions(array(
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Vergleichsrechner\Entity\Zeitabschnitt',
                    'property' => 'zeitabschnittName',
                    'is_method' => true,
                    'find_method' => array(
                        'name' => 'findYearandMonth'
                    ),
        ));
        $produktBearbeitungsgebuehr
                ->setName('produktBearbeitungsgebuehr')
                ->setLabel('Bearbeitungsgebühr')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control',
                    'id' => 'produktBearbeitungsgebuehr'
        ));
        $produktWiderrufsfrist
                ->setName('produktWiderrufsfrist')
                ->setLabel('Widerrufsfrist')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control',
                    'id' => 'produktWiderrufsfrist'
        ));
        $produktWiderrufsfristZeiteinh
                ->setName('produktWiderrufsfristZeiteinh')
                ->setLabel(' ')
                ->setOptions(array(
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Vergleichsrechner\Entity\Zeitabschnitt',
                    'property' => 'zeitabschnittName2',
                    'is_method' => true,
                    'find_method' => array(
                        'name' => 'findMonthandDay'
                    ),
        ));
        $produktSondertilgungen
                ->setName('produktSondertilgungen')
                ->setLabel('Sondertilgungen')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control',
                    'id' => 'produktSondertilgungen'
        ));
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
        $produktInformationen
                ->setName('produktInformationen')
                ->setLabel('Informationen')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control',
                    'id' => 'produktInformationen',
                    'maxlength' => '500'
        ));
        $modus
                ->setName('modus')
                ->setValue('create')
                ->setAttribute('id', 'modus')
                ->setLabel('Modus')
                ->setLabelAttributes(array(
                    'class' => 'hidden'
        ));
        $produktEffektiverJahreszins
                ->setName('produktEffektiverJahreszins')
                ->setLabel('Effektiver Jahreszins')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control validate[custom[numberKom]]',
                    'id' => 'produktEffektiverJahreszins'
        ));
        $produktAnnahmerichtlinie
                ->setName('produktAnnahmerichtlinie')
                ->setLabel('Annahmerichtlinie')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control',
                    'id' => 'produktAnnahmerichtlinie'
        ));
        $produktSollzins
                ->setName('produktSollzins')
                ->setLabel('Sollzins')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control validate[custom[numberKom]]',
                    'id' => 'produktSollzins'
        ));
        $produktGesamtbetrag
                ->setName('produktGesamtbetrag')
                ->setLabel('Gesamtbetrag')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control validate[custom[numberKom]]',
                    'id' => 'produktGesamtbetrag'
        ));
        $produktNettokreditsumme
                ->setName('produktNettokreditsumme')
                ->setLabel('Nettokreditsumme')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control validate[custom[numberKom]]',
                    'id' => 'produktNettokreditsumme'
        ));
        $rkvAbschluss
                ->setName('rkvAbschluss')
                ->setLabel('RKV-Abschluss')
                ->setLabelAttributes($labelAttributes)
                ->setOptions(array(
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Vergleichsrechner\Entity\RKVAbschluss',
                    'property' => 'rkvAbschlussName'
        ));
        $produktLaufzeit
                ->setName('produktLaufzeit')
                ->setLabel('Laufzeit')
                ->setLabelAttributes($labelAttributes)
                ->setAttributes(array(
                    'class' => 'form-control validate[custom[number]]',
                    'id' => 'produktLaufzeit'
        ));
        $legitimation
                ->setName('legitimation')
                ->setLabel('Legitimation')
                ->setLabelAttributes($labelAttributes)
                ->setOptions(array(
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Vergleichsrechner\Entity\Legitimation',
                    'property' => 'legitimationName',
                    'empty_option' => '--- Bitte wählen ---',
        ));
        $ktozugriffe
                ->setName('ktozugriffe')
                ->setLabel('Kontozugriff')
                ->setLabelAttributes($labelAttributes)
                ->setOptions(array(
                    'empty_option' => '--- Bitte wählen ---',
                    'object_manager' => $this->getObjectManager(),
                    'target_class' => 'Vergleichsrechner\Entity\Kontozugriff',
                    'property' => 'kontozugriffName',
        ));

        /*
         * Setting up the form
         */
        $this
                ->setName('addProductForm')
                ->setLabel('Produkt hinzufügen')
                ->setAttributes(array(
                    'method' => 'post',
                    'role' => 'form',
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
        $this->add($ktozugriffe);

        $this->add($produktMinKredit);
        $this->add($produktMaxKredit);
        $this->add($produktIsBonitabh);
        $this->add($produktBearbeitungsgebuehr);
        $this->add($produktWiderrufsfrist);
        $this->add($produktSondertilgungen);
        $this->add($rkvAbschluss);

        $this->add($produktInformationen);
        $this->add($produktAnnahmerichtlinie);
        $this->add($produktGueltigSeit);
        $this->add($produktUrl);
        $this->add($produktKlickoutUrl);

        $this->add($produktLaufzeit);
        $this->add($produktNettokreditsumme);
        $this->add($produktEffektiverJahreszins);
        $this->add($produktSollzins);
        $this->add($produktGesamtbetrag);

        $this->add($modus);

        $this->add($produktKtofuehrKostFllg);
        $this->add($produktWiderrufsfristZeiteinh);
    }

    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
    }

    public function setObjectManager(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager() {
        return $this->objectManager;
    }

}
