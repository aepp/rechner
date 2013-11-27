<?php

namespace Vergleichsrechner\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Vergleichsrechner\Entity\Produkt;
use DoctrineORMModuleTest\Assets\Entity\Date;
use Doctrine\Common\Collections;

/**
 * ProductController
 * 
 * @author A. Epp
 * @version 1.0
 */
class ProduktController extends BaseController
{
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
     	// TODO Auto-generated ProduktController::indexAction() default action
    	return new ViewModel();
    }
    
    public function addAction()
    {
    	$forms = $this->getServiceLocator()->get('FormElementManager');
		$form = $forms->get('AddProductForm', array('name' => 'formName', 'options' => array()));
		return new ViewModel(array(
				'form' => $form,
		));
    }    
    public function insertAction()
    {
    	$request = $this->getRequest();
    	$response = $this->getResponse();
    	
    	$success = true;
    	
    	if ($request->isPost()) {
    		try{
	    		$em = $this->getEntityManager();
	    		
	    		$produkt = new Produkt();
	    		
	    		$_POST['aktion'] = 24;
	    		$_POST['kategorie'] = 1;
	    		$_POST['produktart'] = 1;
	    		$_POST['produktame'] = 1;
	    		$_POST['bank'] = 14;
	    		$_POST['produktHasOnlineAbschluss'] = false;
	    		$_POST['produktMindestanlage'] = 0;
	    		$_POST['produktHoechstanlage'] = 0;
	    		$_POST['produktHasGesetzlEinlagvers'] = true;
	    		$_POST['einlagensicherungLand'] = 1;
	    		$_POST['produktKtofuehrKost'] = 100;
	    		$_POST['produktKtofuehrKostFllg'] = 1;
	    		$_POST['produktZinsgutschrift'] = 1;
	    		$_POST['produktVerfuegbarkeit'] = 1;
	    		$_POST['produktKuendbarkeit'] = 1;
	    		$_POST['produktHasOnlineBanking'] = true;
	    		$_POST['legitimation'] = 1;
	    		$_POST['produktHasAltersbeschraenkung'] = false;
	    		$_POST['produktGueltigSeit'] = new \DateTime("2012-12-12");
	    		$_POST['produktCheck'] = 1.1;
	    		$_POST['produktTipp'] = true;
	    		$_POST['produktInformationen'] = "BLA";
	    		$_POST['produktUrl'] = "www.foo";
	    		$_POST['produktKlickoutUrl'] = "www.bar";
	    		$_POST['produktName'] = "test";
	    		$_POST['ktozugriffe'] = [1, 2];
	    		
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
				$produktGueltigSeit = $_POST['produktGueltigSeit'];
				$produktCheck = $_POST['produktCheck'];
				$produktTipp = $_POST['produktTipp'];
				$produktInformationen = $_POST['produktInformationen'];
				$produktUrl = $_POST['produktUrl'];
				$produktKlickoutUrl = $_POST['produktKlickoutUrl'];
				$ktozugriffe = $_POST['ktozugriffe'];
				
				
				foreach($ktozugriffe as $id):
					$ktozugriff = $em->find('Vergleichsrechner\Entity\Kontozugriff', $id);
					$produkt->addKtozugriff($ktozugriff);
					$em->persist($ktozugriff);
				endforeach;

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
				
    		} catch (Exception $e){
    			$success = false;
    		}
    	}
    	return new JsonModel(array(
            'result'=> $success,
        ));
    }
    
}