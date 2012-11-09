<?php
class Default_Model_Mapper_Movies
{
    protected $_movieTable;
    protected $_cache;
    
    public function __construct(Bootstrap $application)
    {
        $this->_movieTable = new Default_Model_DbTable_Movies();
        $this->_cache = $application->getResource('cache');
    }
    
    public function getByDate($date)
    {
        $id = str_replace('-', '_', $date) . '_movies';
        if(($result = $this->_cache->load($id)) === false ) {
            $result = $this->_movieTable->getByDate($date);
            $this->_cache->save($result, $id);
        }
        return $result;
    }
}