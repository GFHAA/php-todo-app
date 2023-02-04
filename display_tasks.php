<?php

require_once 'db.php';
var_dump($db->select(["*"],"tasks"));

?>