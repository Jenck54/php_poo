<?php 

class Autoloader {

    static function start() {
        spl_autoload_register([__CLASS__,"autoload"]);
    }

    static function autoload($nomClasse) {

        if(file_exists($nomClasse . ".php")) {
            include($nomClasse.".php");
        }
    }

}