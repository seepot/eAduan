<?php 

class Spt_Form_Decorator_Label extends Zend_Form_Decorator_Label {
	/**
	* Render a label (WITHOUT the tag)
	*
	* @param  string $content
	* @return string
	*/
	public function render($content) {
		$tag = $this->getTag(); // save tag
		$this->setTag(null);
		$retval = parent::render($content);
		$this->setTag($tag);
		return $retval;
	}
}

?>