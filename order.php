<?php
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION['admin']) && !isset($_SESSION['user'])){
header("Location:index.php");
}

include("config.php");
include("languages/" .POS_DEFAULT_LANGUAGE .".php");
require_once("database.php");
$db = new database($dbhost,$dbuser,$dbpassword,$dbname);

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
*{font-family:arial, helvetica, sans-serif;font-size:12px;}
@media print{#top{display:none;}}
small{font-size:10px;color:#788;}
body{margin:0px;background:#f5f9ff;}
th{background:248;color:fff;}
#top {background:#9cf;border-bottom:solid 1px #248;}
#menu td{border-left:solid 1px #788;width:60px;cursor:hand;
text-align:center;color:248;font-weight:bold;}
#sale_info{margin-top:10px;height:220px;overflow:auto;}
#sale_info td{}
#total b{color:#922;font-size:14px;}
</style>

</head>
<body>
<table id="top" width="100%" cellpadding=0">
<tr>
<td>&nbsp;</td>
<td align="right">
<table id="menu"><tr><td onClick="window.print()">Print</td><td onClick="window.close()">Close</td></tr></table>
</td>
</tr>
</table>

<?php
$sql = "SELECT `orders`.`date`, `orders`.`customer_id`, `customers`.`first_name`, `customers`.`last_name`, `orders`.`order_total`, `orders`.`items_ordered`, `orders`.`sold_by` FROM `orders`, `customers` WHERE `customers`.`id` = `orders`.`customer_id` AND `orders`.`id`=" . $_GET['id'];
$result = $db->query($sql);
$order_info = mysql_fetch_assoc($result);
?>
<div id="sale_info">
<?php echo $order_info["date"]; ?></br>
<?php echo $order_info["customer_id"] . " - " . $order_info["first_name"] . " " . $order_info["last_name"]; ?></br>
<?php 
if ($order_info["sold_by"] == 0) {
    echo LOGIN_ADMIN;
} else {
    $solder_name = mysql_fetch_assoc($db->query("SELECT `first_name`, `last_name`, `username` FROM `users` WHERE `customers`.`id` = " . $order_info["sold_by"]));
    echo $solder_name["first_name"] . $solder_name["last_name"] . " - " . $solder_name["username"];
}; ?></br>
<hr>
<table width="100%" cellspacing="0">
<tr><td width="40" align="left"><strong><?php echo TXT_QTY; ?></strong></td><td align="left"><strong><?php echo TXT_ITEM; ?></strong></td><td width="50" align="right"><strong><?php echo TXT_UNIT_PRICE; ?></strong></td><td width="50" align="right"><strong><?php echo TXT_SUBTOTAL; ?></strong></td></tr>
<?php
$sql = "SELECT `orders_items`.`quantity_ordered` AS quantity, `items`.`item_name` AS item_name, `items`.`total_cost` AS item_cost FROM `orders_items`, `items` WHERE `orders_items`.`item_id` = `items`.`id` AND `orders_items`.`order_id` = " .$_GET['id'];
$result = $db->query($sql);
while($order_items = mysql_fetch_assoc($result)){
?><tr><td width="40" align="left"><?php echo $order_items["quantity"]; ?></td><td align="left"><?php echo $order_items["item_name"]; ?></td><td width="50" align="right"><?php echo $order_items["item_cost"]; ?></td><td width="50" align="right"><?php echo ($order_items["item_cost"] * $order_items["quantity"]); ?></td></tr><?php
}
?>
</table>
</div>
<hr>
<table width="100%" cellpadding=0">
<tr>
<td id="total" align="right"><?php echo TXT_TOTAL; ?>: <b><?php echo $order_info["order_total"]; ?></b></td>
</tr>
</table>
</body>
</html>
