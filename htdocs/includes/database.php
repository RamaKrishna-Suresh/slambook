<?php
include_once("config.php");
$dbh = null;
try
{
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
    exit("Error: " . $e->getMessage());
}


/*
 * Works for both insert and update
 */
function save($sql, $params) {
    global $dbh;
    $query= $dbh->prepare($sql);

    foreach ($params as $param_name => $param_value) {
        $query->bindParam($param_name, $param_value);
    }

    return PDOStatement::rowCount();
}

?>