<?php

$mysql = new mysqli('localhost', 'root', '', 'sistema_os');
$mysql->set_charset('utf8');

if ($mysql == FALSE) {
    echo "Erro na conexão";
}
