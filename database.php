<?php

class database{

var $conn = null;

function database($server, $username, $password, $database){
    $this->conn = mysql_connect($server, $username, $password);
    if ($this->conn) mysql_select_db($database);
  }

  function close() {
    mysql_close($this->conn);
  }

  function query($query) {
    $result = mysql_query($query, $this->conn);
    return $result;
  }

  function getConnection(){
    return $this->conn;
  }
}
?>
