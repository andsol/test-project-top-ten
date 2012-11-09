<?php

    require_once realpath(dirname(__FILE__)) . '/../bootstrap.php';
        
    $imdb = new Default_Service_Imdb($application);
    $imdb->updateMovies();