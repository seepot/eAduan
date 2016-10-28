<?php 

class Spt_Form_SubForm extends Zend_Form_SubForm {

	public function loadDefaultDecorators() {
		if ($this->loadDefaultDecoratorsIsDisabled()) {
			return;
		}

		$decorators = $this->getDecorators();
		if (empty($decorators)) {
			$this->addDecorator('FormElements');
		}
	}
}

?>