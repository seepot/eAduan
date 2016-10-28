<?php 

class Spt_Form extends Zend_Form {

	public function loadDefaultDecorators() {
		if ($this->loadDefaultDecoratorsIsDisabled()) {
			return;
		}

		$decorators = $this->getDecorators();
		if (empty($decorators)) {
			$this->addDecorator('FormElements')
				->addDecorator('HtmlTag', array('tag' => 'span', 'class' => 'zend_form'))
				->addDecorator('Form');
		}
	}
}

?>