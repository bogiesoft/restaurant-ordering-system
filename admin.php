<?php

//error_reporting(E_ALL);
//ini_set('display_errors', true);

session_start();
include("config.php");
include("languages/" .POS_DEFAULT_LANGUAGE .".php");

require_once("database.php");
$db = new database($dbhost,$dbuser,$dbpassword,$dbname);

//Logout
if(isset($_GET['action']) && $_GET['action']=="logout"){
	session_destroy();
	header("Location:admin.php");
}

//Login
if(isset($_POST['adminlogin'])){
	//IF LOGIN OK
	if($adminname == trim($_POST['adminname']) && $adminpassword == (trim($_POST['adminpassword']))){
		$_SESSION['admin'] = trim($_POST['adminname']);
		$_SESSION['user'] = trim($_POST['adminname']);
	}
}

?>

<html>
<head>
  <title>Supplier Login</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="pos.css" rel="StyleSheet" type="text/css">
  <script language="javascript" src="general.js"></script>
</head>
<body>
<table width="100%" height="100%" cellspacing="0" cellpadding="0">
<TR height="20"><TD>
<?php
require_once("header.php");
?>
</TD></TR>
<TR><TD valign="top">
<?php
if(!isset($_SESSION['admin'])){
?>
<br><br>
<center><b class="blt"><?php echo LOGIN_WELCOM; ?></b></center>
<form action="admin.php?action=login" method="POST" class="loginform">
<table align="center" class="tlogin">
<TR><TD align="right" width="40%"><?php echo LOGIN_ADMIN; ?></TD><TD width="60%"><input type="text" name="adminname"></TD></TR>
<TR><TD align="right" width="40%"><?php echo LOGIN_PASSWORD; ?></TD><TD width="60%"><input type="password" name="adminpassword"></TD></TR>
<TR><TD colspan="2" align="center"><input type="submit" name="adminlogin" value="<?php echo LOGIN_SUBMIT; ?>"></TD></TR>
</table>
</form>
<center><a href="manager.php" class = "stronglink">Manager</a>&nbsp;|&nbsp;<a href="index.php" class="stronglink">Cashier</a>&nbsp;|&nbsp;<a href="admin.php" class="stronglink">Supplier</a></center>
<?php
}
else{
//MAIN ADMIN AREA
?>
<div id="adminmenu">
<table>
<TR>
<TD><a href="admin.php?action=brands" onmouseover="UpdateHelpTip(1)" onmouseout="UpdateHelpTip(0)"><?php echo ADMINMENU_BRANDS; ?></a></TD>
<TD><a href="admin.php?action=categories" onmouseover="UpdateHelpTip(2)" onmouseout="UpdateHelpTip(0)"><?php echo ADMINMENU_CATEGORIES; ?></a></TD>
<TD><a href="admin.php?action=clients" onmouseover="UpdateHelpTip(3)" onmouseout="UpdateHelpTip(0)"><?php echo ADMINMENU_RESTAURANT; ?></a></TD>
<TD><a href="admin.php?action=products" onmouseover="UpdateHelpTip(4)" onmouseout="UpdateHelpTip(0)"><?php echo ADMINMENU_PRODUCTS; ?></a></TD>
<TD><a href="admin.php?action=reports" onmouseover="UpdateHelpTip(9)" onmouseout="UpdateHelpTip(0)"><?php echo ADMINMENU_REPORTS; ?></a></TD>
<TD><a href="admin.php?action=logout" onmouseover="UpdateHelpTip(11)" onmouseout="UpdateHelpTip(0)"><?php echo ADMINMENU_LOGOUT; ?></a></TD>
</TR>
</table>
</div>

<?php
if(!isset($_GET['action']) || $_GET['action']=="login"){
?><div class="admin_content"><?php
echo ADMIN_WELCOM_TEXT;
?></div><?php
}


if($_GET['action']=="brands"){
	require_once("brands.php");	
}


if($_GET['action']=="categories"){
	require_once("categories.php");
}

if($_GET['action']=="clients"){
require_once("clients.php");
}

if($_GET['action']=="products"){
require_once("products.php");
}

if($_GET['action']=="orders"){
require_once("orders.php");
}

if($_GET['action']=="suppliers"){
require_once("suppliers.php");
}

if($_GET['action']=="users"){
require_once("users.php");
}

if($_GET['action']=="reports"){
require_once("reports.php");
}

if($_GET['action']=="setup"){
require_once("setup.php");
}

?>

<?php
}
?>
</TD></TR>
<TR height="16"><TD>
<?php require_once("footer.php"); ?>
</TD></TR>
</table>
</body>
</html>
