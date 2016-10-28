<?php 

class Spt_Dojo_Form extends Zend_Dojo_Form
{
    /**
     * Set form name
     *
     * @param  string $name
     * @return Zend_Form
     */
    public function setName($name)
    {
        parent::setName($name);
        $this->getView()->validateDojoForm($this->getName());
        return $this;
    }
}

?>