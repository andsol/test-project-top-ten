<?php
class Default_Form_Date extends Zend_Form
{
    public function init()
    {
        $this->setMethod(Zend_Form::METHOD_POST);
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);
        
        $date = new Zend_Form_Element_Text('date', array(
            'required'    => true,
            'label'       => _('Select date'),
            'maxlength'   => 128,
            'validators' => array(array('Date', true, 'yyyy-MM-dd'))
        ));
        $this->addElement($date);
        
        $submit = new Zend_Form_Element_Button('display', array(
            'type' => 'submit',
            'label' => _('Display'),
            'decorators' => array('ViewHelper')
        ));
        $this->addElement($submit);      
    }
}