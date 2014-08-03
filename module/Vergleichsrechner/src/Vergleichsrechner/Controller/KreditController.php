<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Vergleichsrechner\Entity\Kredit;
use Vergleichsrechner\Entity\KreditKondition;
use Zend\Session\Container;

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
                $em = $this->getEntityManager();

                $produktId = $this->params()->fromRoute('produktId');
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
                $form->get('legitimation')->setAttribute('value', $produkt->getLegitimation());
                $form->get('ktozugriffe')->setAttribute('value', $produkt->getKtozugriffe());

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
                if ($produktId) {
                    $produkt = $em->getRepository('Vergleichsrechner\Entity\Kredit')->find($produktId);
                } else {
                    $produkt = new Kredit();
                }

                /** Simple properties */
                $produktName = $params()->fromPost('produktName');
                $produktHasOnlineAbschluss = $params()->fromPost('produktHasOnlineAbschluss');
                $produktMinKredit = str_replace(',', '.', $params()->fromPost('produktMinKredit'));
                $produktMaxKredit = str_replace(',', '.', $params()->fromPost('produktMaxKredit'));
                $produktBearbeitungsgebuehr = str_replace(',', '.', $params()->fromPost('produktBearbeitungsgebuehr'));
                $produktWiderrufsfrist = str_replace(',', '.', $params()->fromPost('produktWiderrufsfrist'));
                $produktIsBonitabh = $params()->fromPost('produktIsBonitabh');
                $produktSondertilgungen = $params()->fromPost('produktSondertilgungen');
                $produktKtofuehrKost = str_replace(',', '.', $params()->fromPost('produktKtofuehrKost'));
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

                /** FK properties */
                $produktartKey = $params()->fromPost('produktart');
                $bankKey = $params()->fromPost('bank');
                $produktWiderrufsfristZeiteinhKey = $params()->fromPost('produktWiderrufsfristZeiteinh');
                $produktKtofuehrKostFllgKey = $params()->fromPost('produktKtofuehrKostFllg');
                $aktionKey = $params()->fromPost('aktion');
                $zinssatzKey = $params()->fromPost('zinssatz');
                $rkvAbschlussKey = $params()->fromPost('rkvAbschluss');
                $legitimationKey = $params()->fromPost('legitimation');

                /** Date fields */
                $produktGueltigSeitString = $params()->fromPost('produktGueltigSeit');
                $produktGueltigSeit = null;

                /** Entity variables */
                $aktion = null;
                $bank = null;
                $legitimation = null;
                $produktart = null;
                $produktKtofuehrKostFllg = null;
                $zinssatz = null;
                $rkvAbschluss = null;
                $produktWiderrufsfristZeiteinh = null;

                /** Update kredit_kontozufriff Join-Table */
                $ktozugriffeNew = $params()->fromPost('ktozugriffe');

                $ktozugriffeOld = $produkt->getKtozugriffe();
                if ($ktozugriffeOld) {
                    foreach ($ktozugriffeOld as $id):
                        $ktozugriff = $em->find('Vergleichsrechner\Entity\Kontozugriff', $id);
                        $produkt->removeKtozugriff($ktozugriff);
                    endforeach;
                }
                if ($ktozugriffeNew) {
                    foreach ($ktozugriffeNew as $id):
                        $ktozugriff = $em->find('Vergleichsrechner\Entity\Kontozugriff', $id);
                        $produkt->addKtozugriff($ktozugriff);
                    endforeach;
                }


                if ($produktKlickoutUrl != null) {
                    if (strpos($produktKlickoutUrl, 'http') === false) {
                        $produktKlickoutUrl = 'http://' . $produktKlickoutUrl;
                    }
                }

                /** Find entities for given keys */
                if ($aktionKey != null) {
                    $aktion = $em->find('Vergleichsrechner\Entity\Aktion', $aktionKey);
                }
                if ($produktWiderrufsfristZeiteinhKey != null) {
                    $produktWiderrufsfristZeiteinh = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktWiderrufsfristZeiteinhKey);
                } else {
                    $produktWiderrufsfristZeiteinhKey = 1;
                    $produktWiderrufsfristZeiteinh = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktWiderrufsfristZeiteinhKey);
                }
                if ($produktKtofuehrKostFllgKey != null) {
                    $produktKtofuehrKostFllg = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktKtofuehrKostFllgKey);
                } else {
                    $produktKtofuehrKostFllgKey = 2;
                    $produktKtofuehrKostFllg = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktKtofuehrKostFllgKey);
                }
                if ($bankKey != null) {
                    $bank = $em->find('Vergleichsrechner\Entity\Bank', $bankKey);
                } else {
                    $message = 'Bank-Feld kann nicht leer sein.';
                    $redirect = null;
                    throw new \InvalidArgumentException($message);
                }
                if ($produktartKey != null) {
                    $produktart = $em->find('Vergleichsrechner\Entity\Produktart', $produktartKey);
                } else {
                    $message = 'Produktart-Feld kann nicht leer sein.';
                    $redirect = null;
                    throw new \InvalidArgumentException($message);
                }
                if ($aktionKey != null) {
                    $aktion = $em->find('Vergleichsrechner\Entity\Aktion', $aktionKey);
                }
                if ($legitimationKey != null) {
                    $legitimation = $em->find('Vergleichsrechner\Entity\Legitimation', $legitimationKey);
                }
                if ($produktGueltigSeitString != null) {
                    $produktGueltigSeit = date_create_from_format('d.m.Y', $produktGueltigSeitString);
                }
                if ($produktKtofuehrKostFllgKey != null) {
                    $produktKtofuehrKostFllg = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktKtofuehrKostFllgKey);
                }
                if ($zinssatzKey != null) {
                    $zinssatz = $em->find('Vergleichsrechner\Entity\Zinssatz', $zinssatzKey);
                }
                if ($rkvAbschlussKey != null) {
                    $rkvAbschluss = $em->find('Vergleichsrechner\Entity\RKVAbschluss', $rkvAbschlussKey);
                }
                if (empty($produktCheck)) {
                    $produktCheck = 0;
                }
                if (empty($produktMaxKredit)) {
                    $produktMaxKredit = 0;
                }
                if (empty($produktMinKredit)) {
                    $produktMinKredit = 0;
                }
                if (empty($produktKtofuehrKost)) {
                    $produktKtofuehrKost = 0;
                }
                if (empty($produktBearbeitungsgebuehr)) {
                    $produktBearbeitungsgebuehr = 0;
                }
                if (empty($produktWiderrufsfrist)) {
                    $produktWiderrufsfrist = 0;
                }
                if (empty($produktEffektiverJahreszins)) {
                    $produktEffektiverJahreszins = 0;
                }
                if (empty($produktGesamtbetrag)) {
                    $produktGesamtbetrag = 0;
                }
                if (empty($produktSollzins)) {
                    $produktSollzins = 0;
                }
                if (empty($produktNettokreditsumme)) {
                    $produktNettokreditsumme = 0;
                }
                if (empty($produktLaufzeit)) {
                    $produktLaufzeit = 0;
                }
                if (!empty($produktKlickoutUrl) && strpos($produktKlickoutUrl, 'http') === false) {
                    $produktKlickoutUrl = 'http://' . $produktKlickoutUrl;
                }
                if ($produktName == null) {
                    $message = 'Produktname muss gefüllt sein.';
                    $redirect = null;
                    throw new \InvalidArgumentException($message);
                }

                /** Write values in the fields */
                $produkt->setProduktName($produktName);
                $produkt->setAktion($aktion);
                $produkt->setProduktTipp($produktTipp);
                $produkt->setZinssatz($zinssatz);
                $produkt->setRkvAbschluss($rkvAbschluss);
                $produkt->setProduktBearbeitungsgebuehr($produktBearbeitungsgebuehr);
                $produkt->setProduktWiderrufsfrist($produktWiderrufsfrist);
                $produkt->setProduktWiderrufsfristZeiteinh($produktWiderrufsfristZeiteinh);
                $produkt->setProduktSondertilgungen($produktSondertilgungen);
                $produkt->setProduktIsBonitabh($produktIsBonitabh);
                $produkt->setProduktEffektiverJahreszins($produktEffektiverJahreszins);
                $produkt->setProduktAnnahmerichtlinie($produktAnnahmerichtlinie);
                $produkt->setProduktGesamtbetrag($produktGesamtbetrag);
                $produkt->setProduktSollzins($produktSollzins);
                $produkt->setProduktNettokreditsumme($produktNettokreditsumme);
                $produkt->setProduktLaufzeit($produktLaufzeit);
                $produkt->setProduktUrl($produktUrl);
                $produkt->setProduktKlickoutUrl($produktKlickoutUrl);
                $produkt->setProduktCheck($produktCheck);
                $produkt->setProduktGueltigSeit($produktGueltigSeit);
                $produkt->setProduktHasOnlineAbschluss($produktHasOnlineAbschluss);
                $produkt->setProduktMaxKredit($produktMaxKredit);
                $produkt->setProduktInformationen($produktInformationen);
                $produkt->setProduktKtofuehrKost($produktKtofuehrKost);
                $produkt->setProduktKtofuehrKostFllg($produktKtofuehrKostFllg);
                $produkt->setProduktMinKredit($produktMinKredit);
                $produkt->setZinssatz($zinssatz);
                $produkt->setProduktart($produktart);
                $produkt->setLegitimation($legitimation);
                $produkt->setBank($bank);
                $produkt->setProduktIsActive(true);

                /** Save product */
                $em->persist($produkt);

                /** Save conditions */
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
            } catch (\InvalidArgumentException $e) {
                $message = $e->getMessage();
                $error = true;
                return new JsonModel(array(
                    'message' => $message,
                    'produktId' => $produktId,
                    'error' => $error,
                ));
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
