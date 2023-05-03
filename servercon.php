<?php
require "libs/Rcon.php";

$data = $_POST;

$host = '135.181.126.156';    // Server host name or IP
$port = 25892;         // Port rcon is listening on
$password = 'fbrtyu'; // rcon.password setting set in server.properties
$timeout = 3;        // How long to timeout.

use Thedudeguy\Rcon;

$rcon = new Rcon($host, $port, $password, $timeout);

if ($rcon->connect())
{
  $rcon->sendCommand($data['command']);
  require('index.php');
}
?>