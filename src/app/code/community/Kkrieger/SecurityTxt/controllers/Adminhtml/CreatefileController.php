<?php

class Kkrieger_SecurityTxt_Adminhtml_CreatefileController extends Mage_Adminhtml_Controller_Action
{


    public function createfileAction()
    {
        $fileCreation = Mage::getModel('securitytxt/securityTxtFile');
        //$fileCreation->create();
        $this->getResponse()->setBody($fileCreation->create());
    }

    /**
     * Check is allowed access to action
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/config/security');
    }
}