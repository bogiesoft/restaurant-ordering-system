<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

session_start();
include("config.php");
include("languages/" . POS_DEFAULT_LANGUAGE .".php");

require_once("database.php");
$db = new database($dbhost,$dbuser,$dbpassword,$dbname);

//Logout
if(isset($_GET['action']) && $_GET['action']=="logout"){
        if(isset($_SESSION['admin'])){
                session_destroy();
                header("Location:manager.php");
        }
        else{
                session_destroy();
                header("Location:index.php");
        }
}


//Login
if(isset($_POST['userlogin'])){
	$result = $db->query("select * from users where username='" .trim($_POST['username']) ."' and password='" .md5(trim($_POST['userpassword'])) ."' and type='1'");
        //IF LOGIN OK
        if($result && mysql_num_rows($result)){
          $row = mysql_fetch_row($result);
          $_SESSION['admin'] = $row[0];;
        
	}
}

?>

<html>
<head>
  <title>Manager Login</title>
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
<form action="manager.php?action=login" method="POST" class="loginform">
<table align="center" class="tlogin">
<TR><TD align="right" width="40%"><?php echo MANAGER_ADMIN; ?></TD><TD width="60%"><input type="text" name="username"></TD></TR>
<TR><TD align="right" width="40%"><?php echo LOGIN_PASSWORD; ?></TD><TD width="60%"><input type="password" name="userpassword"></TD></TR>
<TR><TD colspan="2" align="center"><input type="submit" name="userlogin" value="<?php echo LOGIN_SUBMIT; ?>"></TD></TR>
</table>
</form>
<center><a href="manager.php" class="stronglink">Manager</a>&nbsp;|&nbsp;<a href="index.php" class="stronglink">Cashier</a>&nbsp;|&nbsp;<a href="admin.php" class="stronglink">Supplier</a></center>
<?php
}
else{
//MAIN ADMIN AREA
?>
<div id="managermenu">
<table>
<TR>
<TD><a href="manager.php?action=brands" onmouseover="UpdateHelpTip(1)" onmouseout="UpdateHelpTip(0)"><?php echo MANAMENU_BRANDS; ?></a></TD>
<TD><a href="manager.php?action=categories" onmouseover="UpdateHelpTip(2)" onmouseout="UpdateHelpTip(0)"><?php echo MANAMENU_CATEGORIES; ?></a></TD>

<TD><a href="manager.php?action=products" onmouseover="UpdateHelpTip(4)" onmouseout="UpdateHelpTip(0)"><?php echo MANAMENU_PRODUCTS; ?></a></TD>
<TD><!--<a href="manager.php?action=suppliers" onmouseover="UpdateHelpTip(5)" onmouseout="UpdateHelpTip(0)"><?php echo MANAMENU_SUPPLIERS; ?></a></TD>-->
<TD><a href="manager.php?action=users" onmouseover="UpdateHelpTip(6)" onmouseout="UpdateHelpTip(0)"><?php echo MANAMENU_USERS; ?></a></TD>
<TD><!--<a href="manager.php?action=orders" onmouseover="UpdateHelpTip(7)" onmouseout="UpdateHelpTip(0)"><?php echo MANAMENU_ORDERS; ?></a></TD>-->

<TD><a href="manager.php?action=reports" onmouseover="UpdateHelpTip(9)" onmouseout="UpdateHelpTip(0)"><?php echo MANAMENU_REPORTS; ?></a></TD>
<TD><a href="manager.php?action=logout" onmouseover="UpdateHelpTip(11)" onmouseout="UpdateHelpTip(0)"><?php echo MANAMENU_LOGOUT; ?></a></TD>
</TR>
</table>
</div>

<?php
if(!isset($_GET['action']) || $_GET['action']=="login"){
?><div class="manager_content"><?php
echo MANA_WELCOM_TEXT;
?></div><?php
}

if($_GET['action']=="brands"){
require_once("mana_brands.php");
}

if($_GET['action']=="categories"){
require_once("mana_categories.php");
}

if($_GET['action']=="products"){
require_once("mana_products.php");
}

if($_GET['action']=="users"){
require_once("users.php");
}

if($_GET['action']=="reports"){
require_once("mana_reports.php");
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

