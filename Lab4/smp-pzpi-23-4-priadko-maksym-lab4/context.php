<?php
function getDbConnection(): PDO {
    $db = new PDO('sqlite:' . __DIR__ . '/phpstore.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}
?>