<?php

namespace Vergleichsrechner\Controller;

use Zend\View\Model\JsonModel;

abstract class ProduktController extends BaseController {

    protected function updateProductStatus($entityClass) {
        $produktId = $this->params()->fromRoute('produktId');
        $message = null;
        try {
            $produkt = null;
            $produktStatus = $this->params()->fromPost('produktStatus');
            if ($produktId != null && $produktStatus != null) {
                $em = $this->getEntityManager();
                $produkt = $em->getRepository($entityClass)->find($produktId);
                /* @var $produkt \Vergleichsrechner\Entity\Produkt */
                $produkt->setProduktIsActive($produktStatus === 'true');
                /** Save product */
                $em->persist($produkt);
                $em->flush();
                $message = $produkt->getBank()->getBankName() . " "
                        . $produkt->getProduktart()->getProduktartName()
                        . ($produktStatus === 'true' ? " activated" : " deactivated")
                        . " succesfully.";
            }
        } catch (Exception $e) {
            $message = "Error occured while updating product status: $e";
        }
        return new JsonModel(array(
            'message' => $message,
            'produktId' => $produkt
        ));
    }

    protected function updateProductInterest($entityClass) {
        $produktId = $this->params()->fromRoute('produktId');
        $message = null;
        try {
            $produkt = null;
            $produktInterest = $this->params()->fromPost('produktInterest');
            if ($produktId != null && $produktInterest != null) {
                $em = $this->getEntityManager();
                $produkt = $em->getRepository($entityClass)->find($produktId);
                /* @var $produkt \Vergleichsrechner\Entity\Produkt */
                $produkt->setProduktInterest($produktInterest === 'true');
                /** Save product */
                $em->persist($produkt);
                $em->flush();
                $message = $produkt->getBank()->getBankName()
                        . " " . $produkt->getProduktart()->getProduktartName()
                        . " interest updated"
                        . " succesfully.";
            }
        } catch (Exception $e) {
            $message = "Error occured while updating product interest: $e";
        }
        return new JsonModel(array(
            'message' => $message,
            'produktId' => $produktId
        ));
    }

    abstract function toggleProduktInterestAction();

    abstract function toggleProduktStatusAction();
}
