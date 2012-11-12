<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }
    
    public function testIndexPage()
    {
        $this->request->setMethod('GET');
        $this->dispatch('/');
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertModule('default');
        $this->assertResponseCode(200);
    }

    public function testAjaxDate()
    {
        $this->request->setQuery(array(
                'date' => '2012-11-10',
        ));
        $this->request->setMethod('GET');
        $this->request->setHeader('X-Requested-With', 'XmlHttpRequest');
        $this->dispatch('/');
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertModule('default');
        $this->assertResponseCode(200);
    }
    
    public function testPostDate()
    {
        $this->request->setQuery(array(
                'date' => '2012-11-9',
        ));
        $this->request->setMethod('POST');
        $this->dispatch('/');
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertModule('default');
        $this->assertResponseCode(200);
    }
}