<?php
/**
 * 
 * @author Andrey Solonovich
 *
 */
class Default_Service_Imdb
{
    public static $url = 'http://www.imdb.com/chart/top';
    protected $_application;
    protected $_movieTable;
    
    public function __construct(Zend_Application $application)
    {
        $this->_application = $application;
        $this->_movieTable = new Default_Model_DbTable_Movies();
    }
    
    public function updateMovies()
    {
        $client = new Zend_Http_Client(self::$url,
            array(
                'maxredirects' => 0,
                'timeout'      => 30
                )
          );
        $request = $client->request(Zend_Http_Client::GET);
        
        if($request->getStatus() == 200){
            $html = $request->getBody();
            $dom = new Zend_Dom_Query($html);
            
            $result = $dom->query('div#main table[border="1"][cellspacing="0"][cellpadding="4"] tr');
            
            $date = new Zend_Date();
            
            foreach($result as $trLine => $row){
                // Remove first line
                if($trLine != 0){
                    $xpath = new DOMXPath($row->parentNode->ownerDocument);
                    $line = $xpath->query('td', $row);
                    
                    $toAdd = 0;
                    $movie = array();
                    $movie['date'] = $date->toString('yyyy-MM-dd');
                    foreach($line as $tdNumber => $td){
                        switch ($tdNumber){
                            case 0:
                                if(preg_match('/^\d{1,3}/', $td->nodeValue, $rank)){
                                    $movie['rank'] = $rank[0];
                                    $toAdd++;
                                }
                                break;
                            case 1:
                                $movie['rating'] = $td->nodeValue;
                                $toAdd++;
                                break;
                            case 2:
                                if(preg_match('/(.*)\s\((\d{4})\)$/', $td->nodeValue, $matches)){
                                    $movie['title'] = $matches[1];
                                    $movie['year'] = $matches[2];
                                    $toAdd++;
                                }
                                break;
                            case 3:
                                $votes = preg_replace('/,/', '', $td->nodeValue);
                                $movie['votes'] = $votes;
                                $toAdd++;
                                break;
                        }
                    }
                    
                    if($toAdd == 4){
                        $this->_movieTable->insert($movie);
                    }
                    
                }
                
            }
            
        } else {
            $log = $this->_application->getBootstrap()->getResource('Log');
            $log->log('Can\'t connect to imdb', Zend_Log::ERR, $request->getHeadersAsString());
        }
    }
}