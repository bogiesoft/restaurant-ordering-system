<?php

header('Content-Type:text/xml; charset="iso-8859-1"');
session_start();
if(!isset($_SESSION['user'])){
header("Location:admin.php");
}
include("config.php");

require_once("database.php");
$db = new database($dbhost,$dbuser,$dbpassword,$dbname);
$result = $db->query("select id, first_name, last_name, discount from customers where id like '%" .$_GET['findcustomertext'] ."%' || first_name like '%" .$_GET['findcustomertext'] ."%' or last_name like '%" .$_GET['findcustomertext'] ."%'");
echo '<?xml version="1.0" encoding="iso-8859-1" ?>
';
?>
<customers>
<?php
while($row = mysql_fetch_row($result)){
?>
<customer>
<id><?php echo $row[0]; ?></id>
<name><?php echo htmlspecialchars($row[1] ." " .$row[2]); ?></name>
<discount><?php echo htmlspecialchars($row[3]); ?></discount>
</customer>
<?php
}
mysql_free_result($result);
$db->close();
?>
</customers>

