<?php

class PDOperso extends PDO {
    function __construct(
        $host = 'localhost', 
        $dbname = 'php_poo', 
        $port = 3306, 
        $user = 'root', 
        $password = '') {
        parent::__construct(
            //Autre maniere d 'écrire : "mysql:host=$host:$port;dbname=$dbname;charset=UTF8",
            'mysql:host='.$host.':'.$port.';dbname='.$dbname.';charset=UTF8',
            $user, 
            $password
        );
        
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
?>