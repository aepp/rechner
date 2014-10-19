<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Vergleichsrechner\Entity\Geldanlage;
use Vergleichsrechner\Entity\GeldanlageKondition;
use Zend\Session\Container;

/**
 * Geldanlage Controller
 *
 * @author A. Epp
 * @version 1.0
 */
class GeldanlageController extends BaseController {

    /**
     * Alle Geldanlage-Produkte ermitteln
     */
    public function indexAction() {
        $message = null;
        $error = false;
        $produkte = array();

        try {
            $em = $this->getEntityManager();
            $produkte = $em->getRepository('Vergleichsrechner\Entity\Geldanlage')->findAll();
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
        $form = $forms->get('GeldanlageForm');
        $produktId = null;
        $message = null;
        $error = false;

        $produkt_session = new Container('produkt');
        $produkt_session->konditionen = array();

        try {
            if ($this->params()->fromRoute('produktId')) {
                $produktId = $this->params()->fromRoute('produktId');

                $em = $this->getEntityManager();
                $produkt = $em->getRepository('Vergleichsrechner\Entity\Geldanlage')->find($produktId);

                $form->setLabel('Produkt bearbeitren');
                $form->get('produktart')->setAttribute('value', $produkt->getProduktart());
                $form->get('produktName')->setAttribute('value', $produkt->getProduktName());
                $form->get('bank')->setAttribute('value', $produkt->getBank());
                $form->get('produktHasOnlineAbschluss')->setAttribute('value', $produkt->getProduktHasOnlineAbschluss());
                $form->get('zinssatz')->setAttribute('value', $produkt->getZinssatz());
                $form->get('produktMindestanlage')->setAttribute('value', str_replace('.', ',', $produkt->getProduktMindestanlage()));
                $form->get('produktHoechstanlage')->setAttribute('value', str_replace('.', ',', $produkt->getProduktHoechstanlage()));
                $form->get('produktHasGesetzlEinlagvers')->setAttribute('value', $produkt->getProduktHasGesetzlEinlagvers());
                $form->get('einlagensicherungLand')->setAttribute('value', $produkt->getEinlagensicherungLand());
                $form->get('aktion')->setAttribute('value', $produkt->getAktion());
                $form->get('produktKtofuehrKost')->setAttribute('value', $produkt->getProduktKtofuehrKost());
                $form->get('produktKtofuehrKostFllg')->setAttribute('value', $produkt->getProduktKtofuehrKostFllg());
                $form->get('produktZinsgutschrift')->setAttribute('value', $produkt->getProduktZinsgutschrift());
                $form->get('produktVerfuegbarkeit')->setAttribute('value', $produkt->getProduktVerfuegbarkeit());
                $form->get('produktKuendbarkeit')->setAttribute('value', $produkt->getProduktKuendbarkeit());
                $form->get('produktHasOnlineBanking')->setAttribute('value', $produkt->getProduktHasOnlineBanking());
                $form->get('legitimation')->setAttribute('value', $produkt->getLegitimation());
                $form->get('produktHasAltersbeschraenkung')->setAttribute('value', $produkt->getProduktHasAltersbeschraenkung());
                $form->get('ktozugriffe')->setAttribute('value', $produkt->getKtozugriffe());
                if ($produkt->getProduktGueltigSeit() != null) {
                    $form->get('produktGueltigSeit')->setAttribute('value', $produkt->getProduktGueltigSeit()->format('d.m.Y'));
                }
                $form->get('produktCheck')->setAttribute('value', str_replace('.', ',', $produkt->getProduktCheck()));
                $form->get('produktTipp')->setAttribute('value', $produkt->getProduktTipp());
                $form->get('produktInformationen')->setAttribute('value', $produkt->getProduktInformationen());
                $form->get('produktUrl')->setAttribute('value', $produkt->getProduktUrl());
                $form->get('produktKlickoutUrl')->setAttribute('value', $produkt->getProduktKlickoutUrl());
                $form->get('modus')->setValue('edit');

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
     * Insert or update Produkt
     */

    public function insertAction() {
        $request = $this->getRequest();
        $response = $this->getResponse();
        $params = $this->params();
        $error = false;
        $redirect = '/produktverwaltung/geldanlage';

        $produkt_session = new Container('produkt');
        $produktId = $this->params()->fromRoute('produktId');

        if ($request->isXmlHttpRequest()) {
            try {
                $em = $this->getEntityManager();
                if ($produktId) {
                    $produkt = $em->getRepository('Vergleichsrechner\Entity\Geldanlage')->find($produktId);
                } else {
                    $produkt = new Geldanlage();
                }

                /** Simple properties */
                $produktName = $params()->fromPost('produktName');
                $produktHasOnlineAbschluss = $params()->fromPost('produktHasOnlineAbschluss');
                $produktMindestanlage = str_replace(',', '.', $params()->fromPost('produktMindestanlage'));
                $produktHoechstanlage = str_replace(',', '.', $params()->fromPost('produktHoechstanlage'));
                $produktHasGesetzlEinlagvers = $params()->fromPost('produktHasGesetzlEinlagvers');
                $produktKtofuehrKost = $params()->fromPost('produktKtofuehrKost');
                $produktHasOnlineBanking = $params()->fromPost('produktHasOnlineBanking');
                $produktHasAltersbeschraenkung = $params()->fromPost('produktHasAltersbeschraenkung');
                $produktGueltigSeitString = $params()->fromPost('produktGueltigSeit');
                $produktCheck = str_replace(',', '.', $params()->fromPost('produktCheck'));
                $produktTipp = $params()->fromPost('produktTipp');
                $produktInformationen = $params()->fromPost('produktInformationen');
                $produktUrl = $params()->fromPost('produktUrl');
                $produktKlickoutUrl = $params()->fromPost('produktKlickoutUrl');

                /** FK properties */
                $produktartKey = $params()->fromPost('produktart');
                $bankKey = $params()->fromPost('bank');
                $produktKtofuehrKostFllgKey = $params()->fromPost('produktKtofuehrKostFllg');
                $aktionKey = $params()->fromPost('aktion');
                $legitimationKey = $params()->fromPost('legitimation');
                $einlagensicherungLandKey = $params()->fromPost('einlagensicherungLand');
                $produktZinsgutschriftKey = $params()->fromPost('produktZinsgutschrift');
                $produktVerfuegbarkeitKey = $params()->fromPost('produktVerfuegbarkeit');
                $produktKuendbarkeitKey = $params()->fromPost('produktKuendbarkeit');
                $zinssatzKey = $params()->fromPost('zinssatz');

                /** Entity variables */
                $aktion = null;
                $bank = null;
                $einlagensicherungLand = null;
                $legitimation = null;
                $produktart = null;
                $produktGueltigSeit = null;
                $produktKtofuehrKostFllg = null;
                $produktKuendbarkeit = null;
                $produktVerfuegbarkeit = null;
                $produktZinsgutschrift = null;
                $zinssatz = null;

                /** Update geldanlage_kontozufriff Join-Table */
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


                /** Find entities for given keys */
                if ($aktionKey != null) {
                    $aktion = $em->find('Vergleichsrechner\Entity\Aktion', $aktionKey);
                }
                if ($bankKey != null) {
                    $bank = $em->find('Vergleichsrechner\Entity\Bank', $bankKey);
                }
                if ($einlagensicherungLandKey != null) {
                    $einlagensicherungLand = $em->find('Vergleichsrechner\Entity\Einlagensicherungsland', $einlagensicherungLandKey);
                }
                if ($legitimationKey != null) {
                    $legitimation = $em->find('Vergleichsrechner\Entity\Legitimation', $legitimationKey);
                }
                if ($produktartKey != null) {
                    $produktart = $em->find('Vergleichsrechner\Entity\Produktart', $produktartKey);
                }
                if ($produktGueltigSeitString != null) {
                    $produktGueltigSeit = date_create_from_format('d.m.Y', $produktGueltigSeitString);
                }
                if ($produktKtofuehrKostFllgKey != null) {
                    $produktKtofuehrKostFllg = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktKtofuehrKostFllgKey);
                }
                if ($produktKuendbarkeitKey != null) {
                    $produktKuendbarkeit = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktKuendbarkeitKey);
                }
                if ($produktVerfuegbarkeitKey != null) {
                    $produktVerfuegbarkeit = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktVerfuegbarkeitKey);
                }
                if ($produktZinsgutschriftKey != null) {
                    $produktZinsgutschrift = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktZinsgutschriftKey);
                } else {
                    $produktZinsgutschriftKey = 1;
                    $produktZinsgutschrift = $em->find('Vergleichsrechner\Entity\Zeitabschnitt', $produktZinsgutschriftKey);
                }
                if ($zinssatzKey != null) {
                    $zinssatz = $em->find('Vergleichsrechner\Entity\Zinssatz', $zinssatzKey);
                }
                if (empty($produktCheck)) {
                    $produktCheck = 0;
                }
                if (empty($produktHoechstanlage)) {
                    $produktKtofuehrKost = 0;
                }
                if (empty($produktMindestanlage)) {
                    $produktMindestanlage = 0;
                }
                if (empty($produktKtofuehrKost)) {
                    $produktKtofuehrKost = 0;
                }
                if (!empty($produktKlickoutUrl) && strpos($produktKlickoutUrl, 'http') === false) {
                    $produktKlickoutUrl = 'http://' . $produktKlickoutUrl;
                }
                if ($produktName == null) {
                    $message = 'Produktname muss gefüllt sein.';
                    $redirect = null;
                    throw new \Zend\File\Transfer\Exception\InvalidArgumentException($message);
                }

                /** Write values in the fields */
                $produkt->setProduktName($produktName);
                $produkt->setProduktCheck($produktCheck);
                $produkt->setProduktHasAltersbeschraenkung($produktHasAltersbeschraenkung);
                $produkt->setProduktHasGesetzlEinlagvers($produktHasGesetzlEinlagvers);
                $produkt->setProduktHasOnlineAbschluss($produktHasOnlineAbschluss);
                $produkt->setProduktHasOnlineBanking($produktHasOnlineBanking);
                $produkt->setProduktHoechstanlage($produktHoechstanlage);
                $produkt->setProduktMindestanlage($produktMindestanlage);
                $produkt->setProduktKtofuehrKost($produktKtofuehrKost);
                $produkt->setProduktInformationen($produktInformationen);
                $produkt->setProduktTipp($produktTipp);
                $produkt->setProduktUrl($produktUrl);
                $produkt->setProduktKlickoutUrl($produktKlickoutUrl);
                $produkt->setZinssatz($zinssatz);
                $produkt->setProduktZinsgutschrift($produktZinsgutschrift);
                $produkt->setProduktVerfuegbarkeit($produktVerfuegbarkeit);
                $produkt->setProduktKuendbarkeit($produktKuendbarkeit);
                $produkt->setProduktKtofuehrKostFllg($produktKtofuehrKostFllg);
                $produkt->setProduktGueltigSeit($produktGueltigSeit);
                $produkt->setProduktart($produktart);
                $produkt->setLegitimation($legitimation);
                $produkt->setEinlagensicherungLand($einlagensicherungLand);
                $produkt->setBank($bank);
                $produkt->setAktion($aktion);
                $produkt->setProduktIsActive(true);

                /** Save product */
                $em->persist($produkt);

                /** Save conditions */
                $konditionen = $produkt_session->konditionen;
                if (!empty($konditionen)) {
                    if ($produktId == null) {
                        foreach ($konditionen as $konditionTmp):
                            $kondition = $em->getRepository('Vergleichsrechner\Entity\GeldanlageKondition')->find($konditionTmp->getKonditionId());
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
            'redirect' => $redirect
        ));
    }

    /**
     * Delete product
     */
    public function deleteAction() {
        try {
            $em = $this->getEntityManager();
            $produktId = $this->params()->fromRoute('produktId');
            $produkt = $em->getRepository('Vergleichsrechner\Entity\Geldanlage')->find($produktId);
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
                $produkt = $em->getRepository('Vergleichsrechner\Entity\Geldanlage')->find($produktId);
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
            $produkt = $em->getRepository('Vergleichsrechner\Entity\Geldanlage')->find($produktId);
            $konditionen = $produkt->getKonditionen();

            foreach ($konditionen as $kondition) {
                array_push($konditionenJson, $kondition->jsonSerialize());
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
            'konditionen' => $konditionenJson,
        ));
    }

    public function saveKonditionenAction() {
        $message = null;
        $error = false;
        $kondition = new GeldanlageKondition();
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
                $produkt = $em->getRepository('Vergleichsrechner\Entity\Geldanlage')->find($produktId);
                $konditionenOld = $produkt->getKonditionen();
            }

            foreach (json_decode($konditionenJson) as $konditionJson):
                $kondition = new GeldanlageKondition();
                $kondition->setKonditionLaufzeit($konditionJson->laufzeit);
                $kondition->setKonditionEinlageVon(str_replace(',', '.', $konditionJson->von));
                $kondition->setKonditionEinlageBis(str_replace(',', '.', $konditionJson->bis));
                $kondition->setKonditionZinssatz(str_replace(',', '.', $konditionJson->zinssatz));
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

    public function toggleProduktStatusAction() {
        $produktId = $this->params()->fromRoute('produktId');
        try {
            $produkt = null;
            $em = $this->getEntityManager();
            $produktStatus = $this->params()->fromPost('produktStatus');
            if ($produktId != null && $produktStatus != null) {
                $produkt = $em->getRepository('Vergleichsrechner\Entity\Geldanlage')->find($produktId);
                /* @var $produkt Geldanlage */
                $produkt->setProduktIsActive($produktStatus === "true" ? true : false);
                /** Save product */
                $em->persist($produkt);
                $em->flush();
                return new JsonModel(array(
                    'message' => 'Status updated: ' . $produkt->getProduktName(),
                    'produktId' => $produktId
                ));
            }
        } catch (Exception $e) {
            return new JsonModel(array(
                'message' => 'Error occured: ' . $e,
                'produktId' => $produktId
            ));
        }
    }

}
