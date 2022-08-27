<?php

function conectarDB() : mysqli {
    $db=  new mysqli('localhost', 'root', '', 'bienesraices_crud');
    if(!$db){
        echo 'No se puedo conectar con la base de datos';
        exit;
    }

    return $db;
}