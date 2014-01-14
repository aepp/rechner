<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Vergleichsrechner\Entity\Kredit;
use Zend\Json\Json;
use Vergleichsrechner\Entity\KreditKondition;
use Zend\Session\Container;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Kredit Controller
 * 
 * @author A. Epp
 * @version 1.0
 */
class KreditController extends BaseController
{
	/**
	 * Alle Kredit-Produkte ermitteln
	 */
    public function indexAction()
    {
		$message = null;
		$error = false;
		$produkte = array();
		
    	try{
	    	$em = $this->getEntityManager();
	    	$produkte = $em->getRepository('Vergleichsrechner\Entity\Kredit')->findAll();
    	} catch (\Exception $e){
    		$message = $e->getMessage();
    		$error = true;
    	}
    	return new ViewModel(array(
    			'produkte' => $produkte,
    			'message' => $message,
    			'error' => $error
    	));
    }
    
    /**
     * Build edit product form
     */    
    public function editAction()
    {
    	$forms = $this->getServiceLocator()->get('FormElementManager');
		$form = $forms->get('KreditForm');
		$produktId = null;
		$message = null;
		$error = false;
		
		$produkt_session = new Container('produkt');
		$produkt_session->konditionen = array();
		
		try{
			if($this->params()->fromRoute('produktId')){
				$produktId = $this->params()->fromRoute('produktId');
				
				$em = $this->getEntityManager();
				
				$produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
				
				$form->setLabel('Produkt bearbeitren');
				$form->get('produktart')->setAttribute('value', $produkt->getProduktart());
				$form->get('produktName')->setAttribute('value', $produkt->getProduktName());
				$form->get('bank')->setAttribute('value', $produkt->getBank());
				$form->get('produktHasOnlineAbschluss')->setAttribute('value', $produkt->getProduktHasOnlineAbschluss());
				$form->get('zinssatz')->setAttribute('value', $produkt->getZinssatz());
				$form->get('produktMinKredit')->setAttribute('value', str_replace( '.', ',', $produkt->getProduktMinKredit()));
				$form->get('produktMaxKredit')->setAttribute('value', str_replace( '.', ',', $produkt->getProduktMaxKredit()));
				$form->get('produktIsBonitabh')->setAttribute('value', $produkt->getProduktIsBonitabh());
				$form->get('aktion')->setAttribute('value', $produkt->getAktion());
				$form->get('produktKtofuehrKost')->setAttribute('value', $produkt->getProduktKtofuehrKost());
				$form->get('produktBearbeitungsgebuehr')->setAttribute('value', $produkt->getProduktBearbeitungsgebuehr());
				$form->get('produktWiderrufsfrist')->setAttribute('value', $produkt->getProduktWiderrufsfrist());
				$form->get('produktSondertilgungen')->setAttribute('value', $produkt->getProduktSondertilgungen());
				if($produkt->getProduktGueltigSeit() != null) 
					$form->get('produktGueltigSeit')->setAttribute('value', $produkt->getProduktGueltigSeit()->format('d.m.Y'));
				$form->get('produktCheck')->setAttribute('value', str_replace( '.', ',', $produkt->getProduktCheck()));
				$form->get('produktTipp')->setAttribute('value', $produkt->getProduktTipp());
				$form->get('produktInformationen')->setAttribute('value', $produkt->getProduktInformationen());
				$form->get('produktUrl')->setAttribute('value', $produkt->getProduktUrl());
				$form->get('produktKlickoutUrl')->setAttribute('value', $produkt->getProduktKlickoutUrl());
				$form->get('modus')->setValue('edit');
				
				$message = "Form erfolgreich geladen!";
			}
		} catch (Exception $e){
			$message = $e->getMessage();
			$error = true;
		}
		return new ViewModel(array(
				'form' => $form,
				'produktId' => $produktId,
				'message' => $message,
				'error' => $error,
		));	
    }    
    /*
     * Insert or update product
     */
    public function insertAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	$params = $this->params();
    	$error = false;
    	
    	$produkt_session = new Container('produkt');
    	$produktId = $this->params()->fromRoute('produktId');
    	
    	if ($request->isXmlHttpRequest()) {
    		try{
    			$em = $this->getEntityManager();
    			if($produktId)
    				$produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
    			else 
    				$produkt = new Kredit();
	    		
				$kategorie = $params()->fromPost('kategorie');
				$produktart = $params()->fromPost('produktart');
				$produktName = $params()->fromPost('produktName');
				$bank = $params()->fromPost('bank');
				
				$produktHasOnlineAbschluss = $params()->fromPost('produktHasOnlineAbschluss');
				$produktMinKredit = str_replace( ',', '.', $params()->fromPost('produktMinKredit'));
				$produktMaxKredit = str_replace( ',', '.', $params()->fromPost('produktMaxKredit'));
				$produktBearbeitungsgebuehr = str_replace( ',', '.', $params()->fromPost('produktBearbeitungsgebuehr'));
				$produktWiderrufsfrist = str_replace( ',', '.', $params()->fromPost('produktWiderrufsfrist'));
				$produktIsBonitabh = $params()->fromPost('produktIsBonitabh');
				$produktSondertilgungen = $params()->fromPost('produktSondertilgungen');
				$produktKtofuehrKost = $params()->fromPost('produktKtofuehrKost');
				$produktGueltigSeit = $params()->fromPost('produktGueltigSeit');
				$produktCheck = str_replace( ',', '.', $params()->fromPost('produktCheck'));
				$produktTipp = $params()->fromPost('produktTipp');
				$produktInformationen = $params()->fromPost('produktInformationen');
    			$produktUrl = $params()->fromPost('produktUrl');
    			if($produktUrl != null){
					if (strpos($produktUrl,'http') === false) {
						$produktUrl = 'http://'.$produktUrl;
					}
					$produkt->setProduktUrl($produktUrl);
    			}
				$produktKlickoutUrl = $params()->fromPost('produktKlickoutUrl');
				if($produktKlickoutUrl != null){
					if (strpos($produktKlickoutUrl,'http') === false) {
						$produktKlickoutUrl = 'http://'.$produktKlickoutUrl;
					}
					$produkt->setProduktKlickoutUrl($produktKlickoutUrl);
				}
				
				$aktion = $params()->fromPost('aktion');
				$zinssatz = $params()->fromPost('zinssatz');

				if($aktion != null) $produkt->setAktion($em->find('Vergleichsrechner\Entity\Aktion', $aktion));
				if($bank != null) $produkt->setBank($em->find('Vergleichsrechner\Entity\Bank', $bank));
				if($kategorie != null) $produkt->setKategorie($em->find('Vergleichsrechner\Entity\Kategorie', $kategorie));
				if($produktart != null) $produkt->setProduktart($em->find('Vergleichsrechner\Entity\Produktart', $produktart));
				if($produktCheck != null) $produkt->setProduktCheck($produktCheck);
				if($produktGueltigSeit != null) $produkt->setProduktGueltigSeit(date_create_from_format('d.m.Y', $produktGueltigSeit));
				if($produktHasOnlineAbschluss != null) $produkt->setProduktHasOnlineAbschluss($produktHasOnlineAbschluss);
				if($produktMaxKredit != null) $produkt->setProduktMaxKredit($produktMaxKredit);
				if($produktInformationen != null) $produkt->setProduktInformationen($produktInformationen);
				if($produktKtofuehrKost != null) $produkt->setProduktKtofuehrKost($produktKtofuehrKost);
				if($produktMinKredit != null) $produkt->setProduktMinKredit($produktMinKredit);
				if($produktName != null) $produkt->setProduktName($produktName);
				if($produktTipp != null) $produkt->setProduktTipp($produktTipp);
				if($zinssatz != null) $produkt->setZinssatz($em->find('Vergleichsrechner\Entity\Zinssatz', $zinssatz));
				if($produktBearbeitungsgebuehr != null) $produkt->setProduktBearbeitungsgebuehr($produktBearbeitungsgebuehr);
				if($produktWiderrufsfrist != null) $produkt->setProduktWiderrufsfrist($produktWiderrufsfrist);
				if($produktSondertilgungen != null) $produkt->setProduktSondertilgungen($produktSondertilgungen);
				if($produktIsBonitabh != null) $produkt->setProduktIsBonitabh($produktIsBonitabh);
				
				$em->persist($produkt);
				
				$konditionen = $produkt_session->konditionen;
				if(!empty($konditionen)){
					if($produktId == null){
						foreach ($konditionen as $konditionTmp):
							$kondition = $em->getRepository('Vergleichsrechner\Entity\KreditKondition')->find($konditionTmp->getKonditionId());
							$kondition->setProdukt($produkt);
							$em->persist($kondition);
						endforeach;			
					} 
				}
				
				$em->flush();
				$produktId = $produkt->getProduktId();
	    		$message = "Änderungen erfolgreich gespeichert! Sie werden nun zur Produktübersicht weitergeleitet...";
	    		
    		} catch (Exception $e){
    			$message = $e->getMessage();
    			$error = true;
    		}
    	}
    	return new JsonModel(array(
            'message'=> $message,
			'produktId' => $produktId,
    		'error' => $error,
    		'redirect' => '/produktverwaltung/kredit'
        ));
    }
    
    /*
     * Delete product
     */
    public function deleteAction()
    {
    	try{
	    	$em = $this->getEntityManager();
	    	$produktId = $this->params()->fromRoute('produktId');
	    	$produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
	    	$em->remove($produkt);
	    	$em->flush();

	    	$message = "Produkt erfolgreich gelöscht!";
    	} catch (Exception $e){
    		$message = $e->getMessage();
    	}
    	return new JsonModel(array(
			'message'=> $message,
			'produktId' => 0,
    	));
    }
    
    public function loadAktionenAction()
    {
    	$message = null;
    	$error = false;
    	$produktAktion = null;
    	
    	try{
    		$em = $this->getEntityManager();
    		$produktId = $this->params()->fromRoute('produktId');
    		$bankId = $this->params()->fromPost('bankId');
    		if($produktId != null){
    			$produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
    			$produktAktion = $produkt->getAktion();
    			if($produktAktion != null) $produktAktion = $produktAktion->jsonSerialize();
    		}
    		$bank = $em->getRepository('Vergleichsrechner\Entity\Bank')->find($bankId);
    		$aktionen = $bank->getAktionen();
    		$options = array();
    		foreach ($aktionen as $aktion){
    			array_push($options, $aktion->jsonSerialize());
    		}
    		$message = "Aktionen erfolgreich geladen!";
    	} catch (Exception $e){
    		$message = $e->getMessage();
    		$error = true;
    	}
    	return new JsonModel(array(
			'message'=> $message,
			'produktId' => $produktId,
 			'error' => $error,
   			'aktionen' => $options,
    		'aktion' => $produktAktion,
    	));
    }

    public function loadKonditionenAction()
    {
    	$message = null;
    	$error = false;
    	$konditionen = array();
    	$konditionenJson = array();
    	
    	try{
    		$produktId = $this->params()->fromRoute('produktId');
    		if(!$produktId){
    			return new JsonModel(array(
    					'message'=> 'Fehler: Keine ProduktID übermittelt',
    					'error' => true,
    			));
    		}
			$em = $this->getEntityManager();
			$produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
			$konditionen = $produkt->getKonditionen();
			if(sizeof($konditionen) < 1){
				return new JsonModel(array(
						'message'=> 'Keine Konditionen hinterlegt',
						'error' => false,
						'empty'=> true,
				));
			}
			$laufzeiten = array();
			$risikoklassen = array();
			$leads = array();
			$sales = array();
			$zinssaetze = array();
			
    		foreach ($konditionen as $kondition){
    			$laufzeit = $kondition->getKonditionLaufzeit();
    			$risikoklasse = $kondition->getKonditionRisikoklasse();
    			$zinssatz = $kondition->getKonditionZinssatz();
    			$lead = $kondition->getKonditionProvisionLead();
    			$sale = $kondition->getKonditionProvisionSale();
    			
    			if(!in_array($laufzeit, $laufzeiten)) array_push($laufzeiten, $laufzeit);
    			if(!in_array($risikoklasse, $risikoklassen)) array_push($risikoklassen, $risikoklasse);
    			if(!isset($leads[$laufzeit])) $leads[$laufzeit] = $lead;
    			if(!isset($sales[$laufzeit])) $sales[$laufzeit] = $sale;
    			$zinssaetze[$risikoklasse][$laufzeit] = $zinssatz;
    		}

    		$message = "Konditionen erfolgreich geladen!";
    	} catch (Exception $e){
    		$message = $e->getMessage();
    		$error = true;
    	}
    	return new JsonModel(array(
			'message'=> $message,
			'produktId' => $produktId,
 			'error' => $error,
    		'laufzeiten' => json_encode($laufzeiten),
    		'risikoklassen' => json_encode($risikoklassen),
    		'leads' => json_encode($leads),
    		'sales' => json_encode($sales),
    		'zinssaetze' => json_encode($zinssaetze),
    	));
    }

    public function saveKonditionenAction()
    {
    	$message = null;
    	$error = false;
    	$kondition = new KreditKondition();
    	$konditionenTmp = array();
    	$konditionen = array();
    	$konditionenOld = array();
    	$produkt = null;
    	$notEqual = false;
    	
    	try{
    		$em = $this->getEntityManager();
    		
    		$produktId = $this->params()->fromRoute('produktId');
    		$konditionenJson = $this->params()->fromPost('konditionen');
    		if($produktId != null){
				$produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
				$konditionenOld = $produkt->getKonditionen();
    		}

    		foreach (json_decode($konditionenJson) as $konditionJson):
    			$kondition = new KreditKondition();
    			$kondition->setKonditionLaufzeit($konditionJson->laufzeit);
    			$kondition->setKonditionRisikoklasse($konditionJson->risikoklasse);
    			$kondition->setKonditionZinssatz(str_replace( ',', '.', $konditionJson->zinssatz));
    			$kondition->setKonditionProvisionLead(str_replace( ',', '.', $konditionJson->lead));
    			$kondition->setKonditionProvisionSale(str_replace( ',', '.', $konditionJson->sale));
    			$kondition->setProdukt($produkt);
    			array_push($konditionenTmp, $kondition);
    		endforeach;
    		
    		if($produktId != null){
				foreach ($konditionenOld as $konditionOld):
    				$em->remove($konditionOld);
    			endforeach;
    		}
    		foreach ($konditionenTmp as $kondition):
    			$em->persist($kondition);
    			array_push($konditionen, $kondition);
    		endforeach;
    		
    		$produktIsBonitabh = $this->params()->fromPost('produktIsBonitabh');
    		$produkt->setProduktIsBonitabh($produktIsBonitabh);
    		
    		$em->flush();
    		
    		$produkt_session = new Container('produkt');
    		$produkt_session->konditionen = $konditionen;
    		   
    		$message = "Konditionen erfolgreich gespeichert!";
    	} catch (Exception $e){
    		$message = $e->getMessage();
    		$error = true;
    	}
    	return new JsonModel(array(
			'message'=> $message,
			'produktId' => $produktId,
 			'error' => $error,
    	));
    }
}