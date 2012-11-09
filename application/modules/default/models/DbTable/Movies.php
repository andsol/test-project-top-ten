<?php

/**
 * Movies
 *  
 * @author Andrey Solonovich
 * @version 
 */

class Default_Model_DbTable_Movies extends Zend_Db_Table_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'movies';
    
    
    public function getByDate($date)
    {
        return $this->fetchAll(array('date = ?' => $date), 'rank ASC', 10);
    }
}
