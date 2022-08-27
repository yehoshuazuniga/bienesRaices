<?php

require 'funciones.php';
require 'config/database.php';
require __DIR__.'/../vendor/autoload.php';


//conexion a la bbdd

$db =conectarDB();

//use App\Propiedad;
use Model\ActiveRecord;

ActiveRecord::setDB($db);