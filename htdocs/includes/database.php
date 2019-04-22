<?php
include_once("config.php");
include_once("queries.php");

$dbh = null;
try {
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
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
    echo $query->queryString;
    $query->execute();

    return PDOStatement::rowCount();
}

function fetch($sql, $params) {
    global $dbh;
    $query= $dbh->prepare($sql);

    foreach ($params as $param_name => $param_value) {
        $query->bindParam($param_name, $param_value);
    }
    debug_to_console($query->queryString);

    $query->execute();
    return $query->fetchAll();
}

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);
    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

?>