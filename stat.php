<?php
$mysqli = new mysqli('mysql4.joinserver.xyz', 'u104809_1n9k34mc9b', 'gFnCD7pn5@wSJAiy+p=Jc8Uf', 's104809_users');
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$exp = "EXP";
$id = "51642619-7f0b-378a-84e5-6011cfff15a3";

$sql = "UPDATE TNE_BALANCES SET balance=888 WHERE uuid='$id' and currency = '$exp'";

if ($mysqli->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $mysqli->error;
}
$mysqli->close();

//$mysqli->query("UPDATE TNE_BALANCES SET balance = 445 WHERE uuid = $id and currency = $exp");

//var_dump(PDO::getAvailableDrivers());
//mysql_connect('mysql4.joinserver.xyz', 'u104809_1n9k34mc9b', 'gFnCD7pn5@wSJAiy+p=Jc8Uf') or die(mysql_error());
//mysql_select_db('s104809_users') or die(mysql_error());

//$result = mysql_query("UPDATE TNE_BALANCES SET balance = ? WHERE uuid = ? and currency = ?", [555, $id, $exp])
//or die(mysql_error());

//var_dump(PDO::getAvailableDrivers());
//require "connect.php";
//R::setup('mysql:host=mysql4.joinserver.xyz:3306; dbname=s104809_users', 'u104809_1n9k34mc9b', 'gFnCD7pn5@wSJAiy+p=Jc8Uf' );
//R::setup('mysql:host=mysql4.joinserver.xyz; dbname=s104809_users', 'u104809_1n9k34mc9b', 'gFnCD7pn5@wSJAiy+p=Jc8Uf' );

//while(1) {
    //$users = R::getAll( 'SELECT uuid FROM TNE_USERS' );
    //$stat = R::getAll( 'SELECT * FROM TNE_BALANCES' );
    //$c = count($users);
    //while($n <= $c){
        //if($stat[0]['uuid'] == $users[0]['uuid']){
            //R::exec('UPDATE TNE_BALANCES SET balance = ? WHERE uuid = ? and currency = ?', [444, $id, $exp]);
            //sleep(1000);
        //}
    //}
//}
?>