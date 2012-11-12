<?php
/**
 * 
 * @author Andrey Soonovich
 *
 */
class IndexController extends Zend_Controller_Action
{
    protected $_moviesMapper;
    
    public function init()
    {
        $this->_moviesMapper = new Default_Model_Mapper_Movies($this->getInvokeArg('bootstrap'));
    }

    public function indexAction()
    {
        
        $date = new Zend_Date();
        $currentDate = $date->toString('yyyy-MM-dd');
        $form = new Default_Form_Date();
        $form->getElement('date')->setDescription($this->view->translate('Date format is %1$s', $currentDate));
        
        $this->view->movies = false;
        if($this->getRequest()->isPost() || $this->getRequest()->isXmlHttpRequest()){
            if($form->isValid($this->_getAllParams())){
                $this->view->movies = $this->_moviesMapper->getByDate($form->getValue('date'));
            }
        } else {
            $form->getElement('date')->setValue($currentDate);
            $this->view->movies = $this->_moviesMapper->getByDate($currentDate);
        }
        $this->view->form = $form;
        if($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->json(array('form' => $form->render(), 'table' => $this->view->render('table.phtml')));
        }
    }
}