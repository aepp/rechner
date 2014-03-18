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
class KreditController extends BaseController {

    /**
     * Alle Kredit-Produkte ermitteln
     */
    public function indexAction() {
        $message = null;
        $error = false;
        $produkte = array();

        try {
            $em = $this->getEntityManager();
            $produkte = $em->getRepository('Vergleichsrechner\Entity\Kredit')->findAll();
        } catch (\Exception $e) {
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
    public function editAction() {
        $forms = $this->getServiceLocator()->get('FormElementManager');
        $form = $forms->get('KreditForm');
        $produktId = null;
        $message = null;
        $error = false;

        $produkt_session = new Container('produkt');
        $produkt_session->konditionen = array();

        try {
            if ($this->params()->fromRoute('produktId')) {
                $produktId = $this->params()->fromRoute('produktId');

                $em = $this->getEntityManager();

                $produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);

                $form->setLabel('Produkt bearbeitren');
                $form->get('produktart')->setAttribute('value', $produkt->getProduktart());
                $form->get('produktName')->setAttribute('value', $produkt->getProduktName());
                $form->get('bank')->setAttribute('value', $produkt->getBank());
                $form->get('produktHasOnlineAbschluss')->setAttribute('value', $produkt->getProduktHasOnlineAbschluss());
                $form->get('zinssatz')->setAttribute('value', $produkt->getZinssatz());
                if ($produkt->getProduktMinKredit() != null)
                    $form->get('produktMinKredit')->setAttribute('value', str_replace('.', ',', $produkt->getProduktMinKredit()));
                if ($produkt->getProduktMaxKredit() != null)
                    $form->get('produktMaxKredit')->setAttribute('value', str_replace('.', ',', $produkt->getProduktMaxKredit()));
                $form->get('produktIsBonitabh')->setAttribute('value', $produkt->getProduktIsBonitabh());
                $form->get('aktion')->setAttribute('value', $produkt->getAktion());
                $form->get('produktKtofuehrKost')->setAttribute('value', str_replace('.', ',', $produkt->getProduktKtofuehrKost()));
                $form->get('produktKtofuehrKostFllg')->setAttribute('value', $produkt->getProduktKtofuehrKostFllg());
                $form->get('produktBearbeitungsgebuehr')->setAttribute('value', $produkt->getProduktBearbeitungsgebuehr());
                $form->get('produktWiderrufsfrist')->setAttribute('value', $produkt->getProduktWiderrufsfrist());
                $form->get('produktWiderrufsfristZeiteinh')->setAttribute('value', $produkt->getProduktWiderrufsfristZeiteinh());
                $form->get('produktSondertilgungen')->setAttribute('value', $produkt->getProduktSondertilgungen());
                if ($produkt->getProduktGueltigSeit() != null)
                    $form->get('produktGueltigSeit')->setAttribute('value', $produkt->getProduktGueltigSeit()->format('d.m.Y'));
                if ($produkt->getProduktCheck() != null)
                    $form->get('produktCheck')->setAttribute('value', str_replace('.', ',', $produkt->getProduktCheck()));
                $form->get('produktTipp')->setAttribute('value', $produkt->getProduktTipp());
                $form->get('produktInformationen')->setAttribute('value', $produkt->getProduktInformationen());
                $form->get('produktUrl')->setAttribute('value', $produkt->getProduktUrl());
                $form->get('produktKlickoutUrl')->setAttribute('value', $produkt->getProduktKlickoutUrl());
                $form->get('modus')->setValue('edit');
                $form->get('produktEffektiverJahreszins')->setAttribute('value', str_replace('.', ',', $produkt->getProduktEffektiverJahreszins()));
                $form->get('produktAnnahmerichtlinie')->setAttribute('value', $produkt->getProduktAnnahmerichtlinie());
                $form->get('produktSollzins')->setAttribute('value', str_replace('.', ',', $produkt->getProduktSollzins()));
                $form->get('produktGesamtbetrag')->setAttribute('value', str_replace('.', ',', $produkt->getProduktGesamtbetrag()));
                $form->get('produktNettokreditsumme')->setAttribute('value', str_replace('.', ',', $produkt->getProduktNettokreditsumme()));
                $form->get('rkvAbschluss')->setAttribute('value', $produkt->getRKVAbschluss());
                $form->get('produktLaufzeit')->setAttribute('value', $produkt->getProduktLaufzeit());

                $message = "Form erfolgreich geladen!";
            }
        } catch (Exception $e) {
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

    public function insertAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $params = $this->params();
        $error = false;

        $produkt_session = new Container('produkt');
        $produktId = $this->params()->fromRoute('produktId');

        if ($request->isXmlHttpRequest()) {
            try {
                $em = $this->getEntityManager();
                if ($produktId)
                    $produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
                else
                    $produkt = new Kredit();

                $kategorie = $params()->fromPost('kategorie');
                $produktart = $params()->fromPost('produktart');
                $produktName = $params()->fromPost('produktName');
                $bank = $params()->fromPost('bank');

                $produktHasOnlineAbschluss = $params()->fromPost('produktHasOnlineAbschluss');
                $produktMinKredit = str_replace(',', '.', $params()->fromPost('produktMinKredit'));
                $produktMaxKredit = str_replace(',', '.', $params()->fromPost('produktMaxKredit'));
                $produktBearbeitungsgebuehr = str_replace(',', '.', $params()->fromPost('produktBearbeitungsgebuehr'));
                $produktWiderrufsfrist = str_replace(',', '.', $params()->fromPost('produktWiderrufsfrist'));
                $produktWiderrufsfristZeiteinh = $params()->fromPost('produktWiderrufsfristZeiteinh');
                if ($produktWiderrufsfristZeiteinh == null)
                    $produktWiderrufsfristZeiteinh = 1;
                $produktIsBonitabh = $params()->fromPost('produktIsBonitabh');
                $produktSondertilgungen = $params()->fromPost('produktSondertilgungen');
                $produktKtofuehrKost = str_replace(',', '.', $params()->fromPost('produktKtofuehrKost'));
                $produktKtofuehrKostFllg = $params()->fromPost('produktKtofuehrKostFllg');
                if ($produktKtofuehrKostFllg == null)
                    $produktKtofuehrKostFllg = 2;
                $produktGueltigSeit = $params()->fromPost('produktGueltigSeit');
                $produktCheck = str_replace(',', '.', $params()->fromPost('produktCheck'));
                $produktTipp = $params()->fromPost('produktTipp');
                $produktInformationen = $params()->fromPost('produktInformationen');
                $produktEffektiverJahreszins = str_replace(',', '.', $params()->fromPost('produktEffektiverJahreszins'));
                $produktAnnahmerichtlinie = $params()->fromPost('produktAnnahmerichtlinie');
                $produktSollzins = str_replace(',', '.', $params()->fromPost('produktSollzins'));
                $produktGesamtbetrag = str_replace(',', '.', $params()->fromPost('produktGesamtbetrag'));
                $produktNettokreditsumme = str_replace(',', '.', $params()->fromPost('produktNettokreditsumme'));
                $produktLaufzeit = $params()->fromPost('produktLaufzeit');
                $produktUrl = $params()->fromPost('produktUrl');
                $produktKlickoutUrl = $params()->fromPost('produktKlickoutUrl');
                if ($produktKlickoutUrl != null) {
                    if (strpos($produktKlickoutUrl, 'http') === false) {
                        $produktKlickoutUrl = 'http://' . $produktKlickoutUrl;
                    }
                    $produkt->setProduktKlickoutUrl($produktKlickoutUrl);
                }

                $aktion = $params()->fromPost('aktion');
                $zinssatz = $params()->fromPost('zinssatz');
                $rkvAbschluss = $params()->fromPost('rkvAbschluss');

                if ($aktion != null)
                    $produkt->setAktion($em->find('Vergleichsrechner\Entity\Aktion', $aktion));
                if ($bank != null)
                    $produkt->setBank($em->find('Vergleichsrechner\Entity\Bank', $bank));
                if ($kategorie != null)
                    $produkt->setKategorie($em->find('Vergleichsrechner\Entity\Kategorie', $kategorie));
                if ($produktart != null)
                    $produkt->setProduktart($em->find('Vergleichsrechner\Entity\Produktart', $produktart));
                if ($produktCheck != null)
                    $produkt->setProduktCheck($produktCheck);
                if ($produktGueltigSeit != null)
                    $produkt->setProduktGueltigSeit(date_create_from_format('d.m.Y', $produktGueltigSeit));
                if ($produktHasOnlineAbschluss != null)
                    $produkt->setProduktHasOnlineAbschluss($produktHasOnlineAbschluss);
                if ($produktMaxKredit != null)
                    $produkt->setProduktMaxKredit($produktMaxKredit);
                if ($produktInformationen != null)
                    $produkt->setProduktInformationen($produktInformationen);
                if ($produktKtofuehrKost != null)
                    $produkt->setProduktKtofuehrKost($produktKtofuehrKost);
                $produkt->setProduktKtofuehrKostFllg($em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktKtofuehrKostFllg));
                if ($produktMinKredit != null)
                    $produkt->setProduktMinKredit($produktMinKredit);
                if ($produktName != null)
                    $produkt->setProduktName($produktName);
                if ($produktTipp != null)
                    $produkt->setProduktTipp($produktTipp);
                if ($zinssatz != null)
                    $produkt->setZinssatz($em->find('Vergleichsrechner\Entity\Zinssatz', $zinssatz));
                if ($rkvAbschluss != null)
                    $produkt->setRkvAbschluss($em->find('Vergleichsrechner\Entity\RKVAbschluss', $rkvAbschluss));
                if ($produktBearbeitungsgebuehr != null)
                    $produkt->setProduktBearbeitungsgebuehr($produktBearbeitungsgebuehr);
                if ($produktWiderrufsfrist != null)
                    $produkt->setProduktWiderrufsfrist($produktWiderrufsfrist);
                $produkt->setProduktWiderrufsfristZeiteinh($em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktWiderrufsfristZeiteinh));
                if ($produktSondertilgungen != null)
                    $produkt->setProduktSondertilgungen($produktSondertilgungen);
                if ($produktIsBonitabh != null)
                    $produkt->setProduktIsBonitabh($produktIsBonitabh);
                if ($produktEffektiverJahreszins != null)
                    $produkt->setProduktEffektiverJahreszins($produktEffektiverJahreszins);
                if ($produktAnnahmerichtlinie != null)
                    $produkt->setProduktAnnahmerichtlinie($produktAnnahmerichtlinie);
                if ($produktGesamtbetrag != null)
                    $produkt->setProduktGesamtbetrag($produktGesamtbetrag);
                if ($produktSollzins != null)
                    $produkt->setProduktSollzins($produktSollzins);
                if ($produktNettokreditsumme != null)
                    $produkt->setProduktNettokreditsumme($produktNettokreditsumme);
                if ($produktLaufzeit != null)
                    $produkt->setProduktLaufzeit($produktLaufzeit);
                if ($produktUrl != null)
                    $produkt->setProduktUrl($produktUrl);

                $em->persist($produkt);

                $konditionen = $produkt_session->konditionen;
                if (!empty($konditionen)) {
                    if ($produktId == null) {
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
            } catch (Exception $e) {
                $message = $e->getMessage();
                $error = true;
            }
        }
        return new JsonModel(array(
            'message' => $message,
            'produktId' => $produktId,
            'error' => $error,
            'redirect' => '/produktverwaltung/kredit'
        ));
    }

    /*
     * Delete product
     */

    public function deleteAction() {
        try {
            $em = $this->getEntityManager();
            $produktId = $this->params()->fromRoute('produktId');
            $produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
            $em->remove($produkt);
            $em->flush();

            $message = "Produkt erfolgreich gelöscht!";
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return new JsonModel(array(
            'message' => $message,
            'produktId' => 0,
        ));
    }

    public function loadAktionenAction() {
        $message = null;
        $error = false;
        $produktAktion = null;

        try {
            $em = $this->getEntityManager();
            $produktId = $this->params()->fromRoute('produktId');
            $bankId = $this->params()->fromPost('bankId');
            if ($produktId != null) {
                $produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
                $produktAktion = $produkt->getAktion();
                if ($produktAktion != null)
                    $produktAktion = $produktAktion->jsonSerialize();
            }
            $bank = $em->getRepository('Vergleichsrechner\Entity\Bank')->find($bankId);
            $aktionen = $bank->getAktionen();
            $options = array();
            foreach ($aktionen as $aktion) {
                array_push($options, $aktion->jsonSerialize());
            }
            $message = "Aktionen erfolgreich geladen!";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $error = true;
        }
        return new JsonModel(array(
            'message' => $message,
            'produktId' => $produktId,
            'error' => $error,
            'aktionen' => $options,
            'aktion' => $produktAktion,
        ));
    }

    public function loadKonditionenAction() {
        $message = null;
        $error = false;
        $konditionen = array();
        $konditionenJson = array();

        try {
            $produktId = $this->params()->fromRoute('produktId');
            if (!$produktId) {
                return new JsonModel(array(
                    'message' => 'Fehler: Keine ProduktID übermittelt',
                    'error' => true,
                ));
            }
            $em = $this->getEntityManager();
            $produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
            $konditionen = $produkt->getKonditionen();
            if (sizeof($konditionen) < 1) {
                return new JsonModel(array(
                    'message' => 'Keine Konditionen hinterlegt',
                    'error' => false,
                    'empty' => true,
                ));
            }
            $laufzeiten = array();
            $risikoklassen = array();
            $leads = array();
            $sales = array();
            $zinssaetze = array();
            $schwellen = array();

            foreach ($konditionen as $kondition) {
                $laufzeit = $kondition->getKonditionLaufzeit();
                $risikoklasse = $kondition->getKonditionRisikoklasse();
                $zinssatz = $kondition->getKonditionZinssatz();
                $lead = $kondition->getKonditionProvisionLead();
                $sale = $kondition->getKonditionProvisionSale();
                $schwelle = $kondition->getKonditionSchwelle();

                if (!in_array($schwelle, $schwellen)) {
                    array_push($schwellen, $schwelle);

                    $laufzeiten[$schwelle] = array();
                    $risikoklassen[$schwelle] = array();
                }

                if (!in_array($laufzeit, $laufzeiten[$schwelle]))
                    array_push($laufzeiten[$schwelle], $laufzeit);
                if (!in_array($risikoklasse, $risikoklassen[$schwelle]))
                    array_push($risikoklassen[$schwelle], $risikoklasse);

                if (!isset($leads[$schwelle][$laufzeit]))
                    $leads[$schwelle][$laufzeit] = $lead;
                if (!isset($sales[$schwelle][$laufzeit]))
                    $sales[$schwelle][$laufzeit] = $sale;

                $zinssaetze[$schwelle][$risikoklasse][$laufzeit] = $zinssatz;
            }

            $message = "Konditionen erfolgreich geladen!";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $error = true;
        }
        return new JsonModel(array(
            'message' => $message,
            'produktId' => $produktId,
            'error' => $error,
            'laufzeiten' => json_encode($laufzeiten),
            'risikoklassen' => json_encode($risikoklassen),
            'leads' => json_encode($leads),
            'sales' => json_encode($sales),
            'schwellen' => json_encode($schwellen),
            'zinssaetze' => json_encode($zinssaetze)
        ));
    }

    public function saveKonditionenAction() {
        $message = null;
        $error = false;
        $kondition = new KreditKondition();
        $konditionenTmp = array();
        $konditionen = array();
        $konditionenOld = array();
        $produkt = null;
        $notEqual = false;

        try {
            $em = $this->getEntityManager();

            $produktId = $this->params()->fromRoute('produktId');
            $konditionenJson = $this->params()->fromPost('konditionen');
            if ($produktId != null) {
                $produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
                $konditionenOld = $produkt->getKonditionen();
            }

            foreach (json_decode($konditionenJson) as $konditionJson):
                $kondition = new KreditKondition();
                $kondition->setKonditionLaufzeit($konditionJson->laufzeit);
                $kondition->setKonditionRisikoklasse($konditionJson->risikoklasse);
                $kondition->setKonditionZinssatz(str_replace(',', '.', $konditionJson->zinssatz));
                if ($konditionJson->lead != null)
                    $kondition->setKonditionProvisionLead(str_replace(',', '.', $konditionJson->lead));
                if ($konditionJson->sale != null)
                    $kondition->setKonditionProvisionSale(str_replace(',', '.', $konditionJson->sale));
                $kondition->setKonditionSchwelle(str_replace(',', '.', $konditionJson->schwelle));
                $kondition->setProdukt($produkt);
                array_push($konditionenTmp, $kondition);
            endforeach;

            if ($produktId != null) {
                foreach ($konditionenOld as $konditionOld):
                    $em->remove($konditionOld);
                endforeach;
            }
            foreach ($konditionenTmp as $kondition):
                $em->persist($kondition);
                array_push($konditionen, $kondition);
            endforeach;

//     		$produktIsBonitabh = $this->params()->fromPost('produktIsBonitabh');
//     		$produkt->setProduktIsBonitabh($produktIsBonitabh);

            $em->flush();

            $produkt_session = new Container('produkt');
            $produkt_session->konditionen = $konditionen;

            $message = "Konditionen erfolgreich gespeichert!";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $error = true;
        }
        return new JsonModel(array(
            'message' => $message,
            'produktId' => $produktId,
            'error' => $error,
        ));
    }

}
