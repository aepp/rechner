<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Vergleichsrechner\Entity\Produkt;
use Zend\Json\Json;

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
		$produktId = 0;
		$message = null;
		$error = false;
		
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
				$form->get('produktGueltigSeit')->setAttribute('value', $produkt->getProduktGueltigSeit()->format('d.m.Y'));
				$form->get('produktCheck')->setAttribute('value', $produkt->getProduktCheck());
				$form->get('produktTipp')->setAttribute('value', $produkt->getProduktTipp());
				$form->get('produktInformationen')->setAttribute('value', $produkt->getProduktInformationen());
				$form->get('produktUrl')->setAttribute('value', $produkt->getProduktUrl());
				$form->get('produktKlickoutUrl')->setAttribute('value', $produkt->getProduktKlickoutUrl());
				$form->get('saveChanges')->setLabel('Änderungen speichern');
				$form->get('discardChanges')->setLabel('Änderungen verwerfen');
				
				$message = "Successful";
			}
		} catch (Exception $e){
			$message = $e->getMessage();
			$error = true;
		}
		return new ViewModel(array(
				'form' => $form,
				'produktId' => $produktId,
				'message' => $message,
				'error' => $error
		));	
    }    
    /*
     * Insert or update product
     */
    public function insertAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	$error = false;

    	if ($request->isXmlHttpRequest()) {
    		try{
    			$em = $this->getEntityManager();
    			$produkt = new Produkt();
	    		
				$kategorie = $em->find('Vergleichsrechner\Entity\Kategorie', $_POST['kategorie']);
				$produktart = $em->find('Vergleichsrechner\Entity\Produktart', $_POST['produktart']);
				$produktName = $_POST['produktName'];
				$bank = $em->find('Vergleichsrechner\Entity\Bank', $_POST['bank']);
				$produktHasOnlineAbschluss = $_POST['produktHasOnlineAbschluss'];
				$produktMindestanlage = $_POST['produktMindestanlage'];
				$produktHoechstanlage = $_POST['produktHoechstanlage'];
				$produktHasGesetzlEinlagvers = $_POST['produktHasGesetzlEinlagvers'];
				$einlagensicherungLand = $em->find('Vergleichsrechner\Entity\EinlagensicherungLand', $_POST['einlagensicherungLand']);
				$aktion = $em->find('Vergleichsrechner\Entity\Aktion', $_POST['aktion']);
				$produktKtofuehrKost = $_POST['produktKtofuehrKost'];
// 				$produktKtofuehrKostFllg = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $_POST['produktKtofuehrKostFllg']);
				$produktZinsgutschrift = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $_POST['produktZinsgutschrift']);
				$produktVerfuegbarkeit = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $_POST['produktVerfuegbarkeit']);
				$produktKuendbarkeit = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $_POST['produktKuendbarkeit']);
				$produktHasOnlineBanking = $_POST['produktHasOnlineBanking'];
				$legitimation = $em->find('Vergleichsrechner\Entity\Legitimation', $_POST['legitimation']);
				$produktHasAltersbeschraenkung = $_POST['produktHasAltersbeschraenkung'];
				$produktGueltigSeit = date_create_from_format('d.m.Y', $_POST['produktGueltigSeit']);
				$produktCheck = $_POST['produktCheck'];
				$produktTipp = $_POST['produktTipp'];
				$produktInformationen = $_POST['produktInformationen'];
				$produktUrl = $_POST['produktUrl'];
				$produktKlickoutUrl = $_POST['produktKlickoutUrl'];
				$ktozugriffeNew = $_POST['ktozugriffe'];
				
				$produktId = $this->params()->fromRoute('produktId');
				if($produktId){
					$produkt = $em->getRepository('Vergleichsrechner\Entity\Produkt')->find($produktId);
					$ktozugriffeOld = $produkt->getKtozugriffe();
					
					if($ktozugriffeOld != $ktozugriffeNew){
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
				} else {
					foreach($ktozugriffeNew as $id):
						$ktozugriff = $em->find('Vergleichsrechner\Entity\Kontozugriff', $id);
						$produkt->addKtozugriff($ktozugriff);
						$em->persist($ktozugriff);
					endforeach;
				}

				$produkt->setAktion($aktion);
				$produkt->setBank($bank);
				$produkt->setEinlagensicherungLand($einlagensicherungLand);
				$produkt->setKategorie($kategorie);
				$produkt->setLegitimation($legitimation);
				$produkt->setProduktart($produktart);
				$produkt->setProduktCheck($produktCheck);
				$produkt->setProduktGueltigSeit($produktGueltigSeit);
				$produkt->setProduktHasAltersbeschraenkung($produktHasAltersbeschraenkung);
				$produkt->setProduktHasGesetzlEinlagvers($produktHasGesetzlEinlagvers);
				$produkt->setProduktHasOnlineAbschluss($produktHasOnlineAbschluss);
				$produkt->setProduktHasOnlineBanking($produktHasOnlineBanking);
				$produkt->setProduktHoechstanlage($produktHoechstanlage);
				$produkt->setProduktInformationen($produktInformationen);
				$produkt->setProduktKlickoutUrl($produktKlickoutUrl);
				$produkt->setProduktKtofuehrKost($produktKtofuehrKost);
// 				$produkt->setProduktKtofuehrKostFllg($produktKtofuehrKostFllg);
				$produkt->setProduktKuendbarkeit($produktKuendbarkeit);
				$produkt->setProduktMindestanlage($produktMindestanlage);
				$produkt->setProduktName($produktName);
				$produkt->setProduktTipp($produktTipp);
				$produkt->setProduktUrl($produktUrl);
				$produkt->setProduktVerfuegbarkeit($produktVerfuegbarkeit);
				$produkt->setProduktZinsgutschrift($produktZinsgutschrift);
				
				$em->persist($produkt);
				$em->flush();
				
				$produktId = $produkt->getProduktId();
	    		$message = "Successful!";
	    		
    		} catch (Exception $e){
    			$message = $e->getMessage();
    			$error = true;
    		}
    	}
    	return new JsonModel(array(
            'message'=> $message,
			'produktId' => $produktId,
    		'error' => $error
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

	    	$message = "Successful!";
    	} catch (Exception $e){
    		$message = $e->getMessage();
    	}
    	return new JsonModel(array(
			'message'=> $message,
			'produktId' => 0,
    	));
    }
}