<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Vergleichsrechner\Entity\Produkt;
use Zend\Json\Json;
use Vergleichsrechner\Entity\Kondition;
use Zend\Session\Container;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProductController
 * 
 * @author A. Epp
 * @version 1.0
 */
class ProduktController extends BaseController
{
	/**
	 * List all products
	 */
    public function indexAction()
    {
		$message = null;
		$error = false;
		$produkte = array();
		
    	try{
	    	$em = $this->getEntityManager();
	    	$produkte = $em->getRepository('Vergleichsrechner\Entity\Produkt')->findAll();
    	} catch (\Exception $e){
    		$message = $e->getMessage();
    		$error = true;
    	}
    	return new ViewModel(array(
    			'produkte' => $produkte,
    			'message' => $message,
    			'error' => $error
    	));
//     	    	return new ViewModel();
    }
    
    /**
     * Build edit product form
     */    
    public function editAction()
    {
    	$forms = $this->getServiceLocator()->get('FormElementManager');
		$form = $forms->get('ProduktForm');
		$produktId = null;
		$message = null;
		$error = false;
		
		$produkt_session = new Container('produkt');
		$produkt_session->konditionen = array();
		
		try{
			if($this->params()->fromRoute('produktId')){
				$produktId = $this->params()->fromRoute('produktId');
				
				$em = $this->getEntityManager();
				$produkt = $em->getRepository('Vergleichsrechner\Entity\Produkt')->find($produktId);
				
				$form->setLabel('Produkt bearbeitren');
				$form->get('kategorie')->setAttribute('value', $produkt->getKategorie());
				$form->get('produktart')->setAttribute('value', $produkt->getProduktart());
				$form->get('produktName')->setAttribute('value', $produkt->getProduktName());
				$form->get('bank')->setAttribute('value', $produkt->getBank());
				$form->get('produktHasOnlineAbschluss')->setAttribute('value', $produkt->getProduktHasOnlineAbschluss());
				$form->get('zinssatz')->setAttribute('value', $produkt->getZinssatz());
				$form->get('produktMindestanlage')->setAttribute('value', $produkt->getProduktMindestanlage());
				$form->get('produktHoechstanlage')->setAttribute('value', $produkt->getProduktHoechstanlage());
				$form->get('produktHasGesetzlEinlagvers')->setAttribute('value', $produkt->getProduktHasGesetzlEinlagvers());
				$form->get('einlagensicherungLand')->setAttribute('value', $produkt->getEinlagensicherungLand());
				$form->get('aktion')->setAttribute('value', $produkt->getAktion());
				$form->get('produktKtofuehrKost')->setAttribute('value', $produkt->getProduktKtofuehrKost());
				$form->get('produktZinsgutschrift')->setAttribute('value', $produkt->getProduktZinsgutschrift());
				$form->get('produktVerfuegbarkeit')->setAttribute('value', $produkt->getProduktVerfuegbarkeit());
				$form->get('produktKuendbarkeit')->setAttribute('value', $produkt->getProduktKuendbarkeit());
				$form->get('produktHasOnlineBanking')->setAttribute('value', $produkt->getProduktHasOnlineBanking());
				$form->get('legitimation')->setAttribute('value', $produkt->getLegitimation());
				$form->get('produktHasAltersbeschraenkung')->setAttribute('value', $produkt->getProduktHasAltersbeschraenkung());
				$form->get('ktozugriffe')->setAttribute('value', $produkt->getKtozugriffe());
				if($produkt->getProduktGueltigSeit() != null) 
					$form->get('produktGueltigSeit')->setAttribute('value', $produkt->getProduktGueltigSeit()->format('d.m.Y'));
				$form->get('produktCheck')->setAttribute('value', $produkt->getProduktCheck());
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
    				$produkt = $em->getRepository('Vergleichsrechner\Entity\Produkt')->find($produktId);
    			else 
    				$produkt = new Produkt();
	    		
				$kategorie = $params()->fromPost('kategorie');
				$produktart = $params()->fromPost('produktart');
				$produktName = $params()->fromPost('produktName');
				$bank = $params()->fromPost('bank');
				
				$produktHasOnlineAbschluss = $params()->fromPost('produktHasOnlineAbschluss');
				$produktMindestanlage = $params()->fromPost('produktMindestanlage');
				$produktHoechstanlage = $params()->fromPost('produktHoechstanlage');
				$produktHasGesetzlEinlagvers = $params()->fromPost('produktHasGesetzlEinlagvers');
				$produktKtofuehrKost = $params()->fromPost('produktKtofuehrKost');
				$produktHasOnlineBanking = $params()->fromPost('produktHasOnlineBanking');
				$produktHasAltersbeschraenkung = $params()->fromPost('produktHasAltersbeschraenkung');
				$produktGueltigSeit = $params()->fromPost('produktGueltigSeit');
				$produktCheck = $params()->fromPost('produktCheck');
				$produktTipp = $params()->fromPost('produktTipp');
				$produktInformationen = $params()->fromPost('produktInformationen');
				$produktUrl = $params()->fromPost('produktUrl');
				$produktKlickoutUrl = $params()->fromPost('produktKlickoutUrl');
				$ktozugriffeNew = $params()->fromPost('ktozugriffe');
				
				$aktion = $params()->fromPost('aktion');
				$legitimation = $params()->fromPost('legitimation');
				$einlagensicherungLand = $params()->fromPost('einlagensicherungLand');
				$produktZinsgutschrift = $params()->fromPost('produktZinsgutschrift');
				$produktVerfuegbarkeit = $params()->fromPost('produktVerfuegbarkeit');
				$produktKuendbarkeit = $params()->fromPost('produktKuendbarkeit');
				$zinssatz = $params()->fromPost('zinssatz');

				if($ktozugriffeNew){
					$ktozugriffeOld = $produkt->getKtozugriffe();
			
					if($ktozugriffeOld){
						foreach($ktozugriffeOld as $id):
							$ktozugriff = $em->find('Vergleichsrechner\Entity\Kontozugriff', $id);
							$produkt->removeKtozugriff($ktozugriff);
							$em->persist($ktozugriff);
						endforeach;
						foreach($ktozugriffeNew as $id):
							$ktozugriff = $em->find('Vergleichsrechner\Entity\Kontozugriff', $id);
							$produkt->addKtozugriff($ktozugriff);
							$em->persist($ktozugriff);
						endforeach;
					}
				}
				
				if($aktion != null) $produkt->setAktion($em->find('Vergleichsrechner\Entity\Aktion', $aktion));
				if($bank != null) $produkt->setBank($em->find('Vergleichsrechner\Entity\Bank', $bank));
				if($einlagensicherungLand != null) $produkt->setEinlagensicherungLand($em->find('Vergleichsrechner\Entity\EinlagensicherungLand', $einlagensicherungLand));
				if($kategorie != null) $produkt->setKategorie($em->find('Vergleichsrechner\Entity\Kategorie', $kategorie));
				if($legitimation != null) $produkt->setLegitimation($em->find('Vergleichsrechner\Entity\Legitimation', $legitimation));
				if($produktart != null) $produkt->setProduktart($em->find('Vergleichsrechner\Entity\Produktart', $produktart));
				if($produktCheck != null) $produkt->setProduktCheck($produktCheck);
				if($produktGueltigSeit != null) $produkt->setProduktGueltigSeit(date_create_from_format('d.m.Y', $produktGueltigSeit));
				if($produktHasAltersbeschraenkung != null) $produkt->setProduktHasAltersbeschraenkung($produktHasAltersbeschraenkung);
				if($produktHasGesetzlEinlagvers != null) $produkt->setProduktHasGesetzlEinlagvers($produktHasGesetzlEinlagvers);
				if($produktHasOnlineAbschluss != null) $produkt->setProduktHasOnlineAbschluss($produktHasOnlineAbschluss);
				if($produktHasOnlineBanking != null) $produkt->setProduktHasOnlineBanking($produktHasOnlineBanking);
				if($produktHoechstanlage != null) $produkt->setProduktHoechstanlage($produktHoechstanlage);
				if($produktInformationen != null) $produkt->setProduktInformationen($produktInformationen);
				if($produktKlickoutUrl != null) $produkt->setProduktKlickoutUrl($produktKlickoutUrl);
				if($produktKtofuehrKost != null) $produkt->setProduktKtofuehrKost($produktKtofuehrKost);
				if($produktKuendbarkeit != null) $produkt->setProduktKuendbarkeit($em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktKuendbarkeit));
				if($produktMindestanlage != null) $produkt->setProduktMindestanlage($produktMindestanlage);
				if($produktName != null) $produkt->setProduktName($produktName);
				if($produktTipp != null) $produkt->setProduktTipp($produktTipp);
				if($produktUrl) $produkt->setProduktUrl($produktUrl);
				if($produktVerfuegbarkeit != null) $produkt->setProduktVerfuegbarkeit($em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktVerfuegbarkeit));
				if($produktZinsgutschrift != null) $produkt->setProduktZinsgutschrift($em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktZinsgutschrift));
				if($zinssatz != null) $produkt->setZinssatz($em->find('Vergleichsrechner\Entity\Zinssatz', $zinssatz));

				$em->persist($produkt);
				
				$konditionen = $produkt_session->konditionen;
				if(!empty($konditionen)){
					if($produktId == null){
						foreach ($konditionen as $konditionTmp):
							$kondition = $em->getRepository('Vergleichsrechner\Entity\Kondition')->find($konditionTmp->getKonditionId());
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
    	$config = $this->getServiceLocator()->get('config');
    	return new JsonModel(array(
            'message'=> $message,
			'produktId' => $produktId,
    		'error' => $error,
    		'redirect' => $config['redirect_to_produktUebersicht']
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
	    	$produkt = $em->getRepository('Vergleichsrechner\Entity\Produkt')->find($produktId);
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
    			$produkt = $em->getRepository('Vergleichsrechner\Entity\Produkt')->find($produktId);
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
			$produkt = $em->getRepository('Vergleichsrechner\Entity\Produkt')->find($produktId);
			$konditionen = $produkt->getKonditionen();
			
    		foreach ($konditionen as $kondition){
    			array_push($konditionenJson, $kondition->jsonSerialize());
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
    		'konditionen' => $konditionenJson,
    	));
    }

    public function saveKonditionenAction()
    {
    	$message = null;
    	$error = false;
    	$kondition = new Kondition();
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
				$produkt = $em->getRepository('Vergleichsrechner\Entity\Produkt')->find($produktId);
				$konditionenOld = $produkt->getKonditionen();
    		}

    		foreach (json_decode($konditionenJson) as $konditionJson):
    			$kondition = new Kondition();
    			$kondition->setKonditionLaufzeit($konditionJson->laufzeit);
    			$kondition->setKonditionEinlageVon(str_replace( ',', '.', $konditionJson->von));
    			$kondition->setKonditionEinlageBis(str_replace( ',', '.', $konditionJson->bis));
    			$kondition->setKonditionZinssatz(str_replace( ',', '.', $konditionJson->zinssatz));
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