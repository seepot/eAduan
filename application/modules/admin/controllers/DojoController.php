<?php

class Admin_DojoController extends Spt_Controller_Action
{
    public function formAction()
    {
		$form = new Spt_Form_TestDojo;
		
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
    }
}