<?php

session_start();
include("config.php");
include("languages/" . POS_DEFAULT_LANGUAGE .".php");

require_once("database.php");
$db = new database($dbhost,$dbuser,$dbpassword,$dbname);

//Logout
if(isset($_GET['action']) && $_GET['action']=="logout"){
	if(isset($_SESSION['admin'])){
		session_destroy();
		header("Location:admin.php");
	}
	else{
		session_destroy();
		header("Location:index.php");
	}
}

//Login
if(isset($_POST['userlogin'])){
	$result = $db->query("select * from users where username='" .trim($_POST['username']) ."' and password='" .md5(trim($_POST['userpassword'])) ."'");
	//IF LOGIN OK
	if($result && mysql_num_rows($result)){
	  $row = mysql_fetch_row($result);
	  $_SESSION['user'] = $row[0];;
	}
}

//Submit sale
if(isset($_POST['total'])){

  if(isset($_POST['customer_id'])){
     $customer_id = $_POST['customer_id'];
  } else {
  $customer_id = 0;
  }

  $subtotal = $_POST['subtotal'];
  $total = $_POST['total'];
  $tax = $_POST['tax'];
  $items = $_POST['items'];
  $itemsname = $_POST['items_name'];
  $itemsqty = $_POST['itemsqty'];
  $itemstax = $_POST['itemstax'];
  $itemstotaltax = $_POST['itemstotaltax'];
  $itemsbprice = $_POST['itemsbprice'];
  $itemsuprice = $_POST['itemsuprice'];
  $itemsprice = $_POST['itemsprice'];
  $itemstotalprice = $_POST['itemstotalprice'];

  $sql = "INSERT INTO `sales`(`date`, `customer_id`, `sale_sub_total`, `sale_total_cost`, `items_purchased`, `sold_by`) VALUES ('" .date("Y-m-d") ."'," .$customer_id .",'" .$subtotal ."','" .$total ."'," .(sizeof($items)) ."," .(isset($_SESSION['admin'])?"0":$_SESSION['user']) .")";
  $result = $db->query($sql);
  $sale_id = mysql_insert_id($db->getConnection());  

  if ($_POST["order_id"] <> "") {
     $sql = "SELECT `orders_items`.`item_id`, `orders_items`.`id` AS order_item_id, `orders_items`.`quantity_ordered` AS quantity_ordered,`orders_items`.`quantity_delivered` AS quantity_delivered , `items`.`item_name` AS item_name, `items`.`tax_percent`, `items`.`total_cost` AS item_cost, `items`.`buy_price`, `items`.`unit_price`, `orders_items`.`status` AS status FROM `orders_items`, `items` WHERE `orders_items`.`item_id` = `items`.`id` AND `orders_items`.`order_id` = " . $_POST['order_id'];
     $result = $db->query($sql);
     $order_items = array();
     while($order_items[] = mysql_fetch_assoc($result));
  }
  
  $tmp_itemsqty = $itemsqty;
  
  //Insert each item for this sale
  for($i=0;$i<sizeof($items);$i++){
    $sql = "INSERT INTO `sales_items` (`sale_id`, `item_id`, `quantity_purchased`, `item_unit_price`, `item_buy_price`, `item_tax_percent`, `item_total_tax`,  `item_total_cost`) VALUES(" .$sale_id ."," .$items[$i] ."," .$itemsqty[$i] .",'" .$itemsuprice[$i] ."','" .$itemsbprice[$i] ."','" .$itemstax[$i] ."','" .$itemstotaltax[$i] ."','" .$itemstotalprice[$i] ."')";
    $db->query($sql);
        
    if ($_POST["order_id"] <> "") {
      foreach($order_items as &$order_item) {
	if ($order_item["item_id"] == $items[$i]) {
	  $rest = $order_item["quantity_ordered"] - $order_item["quantity_delivered"];
	  if ($rest > 0 && $tmp_itemsqty[$i] > 0) {
	    if ($tmp_itemsqty[$i] < $rest) {
	      $order_item["quantity_delivered"] = $order_item["quantity_delivered"] + $tmp_itemsqty[$i];
	      $order_item["status"] = "PARTIALLY DELIVERED";
	      $tmp_itemsqty[$i] = 0;
	    } else {
	      $tmp_itemsqty[$i] -= $rest;
	      $order_item["quantity_delivered"] = $order_item["quantity_ordered"];
	      $order_item["status"] = "FULL DELIVERED";
	    }
	    $order_item["Modificated"] = "YES";
	  }
	}
      }
    }
  }

  foreach($order_items as &$order_item) {
    if (isset($order_item["Modificated"])) {
      $sql = "UPDATE `orders_items` SET `quantity_delivered` = " . $order_item["quantity_delivered"] . ", `status` = '" . $order_item["status"] . "' WHERE `orders_items`.`id` = " . $order_item["order_item_id"];
      $db->query($sql);
      unset($order_item["Modificated"]);
    }
  }
  
  if ($_POST["order_id"] <> "") {
    // TODO: If the order items are all in "full shipped" status, then close the order.
  }
  
  ?><script language="javascript">window.open("sale.php?id=<?php echo $sale_id; ?>","","width=500,height=300,toolbars=0");</script><?php
}

if (isset($_GET['order_id'])) {
    $sql = "SELECT `customers`.`id` AS customer_id, `customers`.`first_name`, `customers`.`last_name`, `customers`.`discount`, `orders`.`order_total`, `orders`.`items_ordered`, `orders`.`sold_by` FROM `orders`, `customers` WHERE `customers`.`id` = `orders`.`customer_id` AND `orders`.`id`=" . $_GET['order_id'];
    $result = $db->query($sql);
    $order_info = mysql_fetch_assoc($result);
};

?>

<html>
<head>
  <title>Casher Login</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="pos.css" rel="StyleSheet" type="text/css">
  <script language="javascript" src="general.js"></script>
  <?php if (isset($_GET['order_id'])) { ?>
  <script language="javascript">
function chargeData() {
    setCustomer(<?php echo $order_info["customer_id"]; ?> , "<?php echo $order_info["first_name"] . " " . $order_info["last_name"]; ?> ", <?php echo $order_info["discount"]; ?>);
    document.getElementsByName('order_id')[0].value=<?php echo $_GET["order_id"]; ?>;
    
    <?php
    $sql = "SELECT `orders_items`.`item_id`, `orders_items`.`quantity_ordered` - `orders_items`.`quantity_delivered` AS quantity, `orders_items`.`quantity_delivered`, `items`.`item_name` AS item_name, `items`.`tax_percent`, `items`.`total_cost` AS item_cost, `orders_items`.`quantity_ordered`, `items`.`buy_price`, `items`.`unit_price` FROM `orders_items`, `items` WHERE `orders_items`.`item_id` = `items`.`id` AND `orders_items`.`order_id` = " . $_GET['order_id'] . " AND `orders_items`.`status` != 'FULL DELIVERED'";
    $result = $db->query($sql);
    $i=0;
    while($order_items = mysql_fetch_assoc($result)){
    ?>
    addItem(<?php echo $order_items["item_id"]; ?>, "<?php echo $order_items["item_name"]; ?> ", <?php echo $order_items["tax_percent"]; ?>, "<?php echo $order_items["buy_price"]; ?>", "<?php echo $order_items["unit_price"]; ?>", "<?php echo $order_items["item_cost"]; ?>", true, "<?php echo $order_items["quantity_delivered"] . " " . ORDER_QTY_FROM . " " . $order_items["quantity_ordered"]; ?>"); 
    document.getElementsByName('itemsqty[]')[<?php echo $i++; ?>].value+=<?php echo $order_items["quantity"]; ?>;
<?php
    }
?>
    calcS();
}
  </script>  
<?php
    }
?>
</head>
<body <?php if (isset($_GET['order_id'])) { echo "onload=\"chargeData()\""; }; ?>>

<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
<TR height="20"><TD><?php require_once("header.php"); ?></TD></TR>
<TR><TD valign="top">
<?php
if(!isset($_SESSION['admin']) && !isset($_SESSION['user']) ){
?>
<br><br>
<center><b class="blt"><?php echo LOGIN_WELCOM; ?></b></center>
<form action="index.php?action=login" method="POST" class="loginform">
<table align="center" class="tlogin">
<TR><TD align="right" width="40%"><?php echo LOGIN_USER; ?></TD><TD width="60%"><input type="text" name="username"></TD></TR>
<TR><TD align="right" width="40%"><?php echo LOGIN_PASSWORD; ?></TD><TD width="60%"><input type="password" name="userpassword"></TD></TR>
<TR><TD colspan="2" align="center"><input type="submit" name="userlogin" value="<?php echo LOGIN_SUBMIT; ?>"></TD></TR>
</table>
</form>
<center><a href="manager.php" class="stronglink">Manager</a>&nbsp;|&nbsp;<a href="index.php" class="stronglink">Cashier</a>&nbsp;|&nbsp;<a href="admin.php" class="stronglink">Supplier</a></center>
<?php
}
else{

//MAIN CONTENT TABLE

?>
<table width="100%" height="100%" cellspacing="0" border="0">

<tr><td colspan="2" height="20">
<div align="left">&nbsp;&nbsp;&nbsp;<?php if(isset($_SESSION['admin'])){ ?><a href="admin.php"><?php echo TXT_ADMINISTRATION; ?></a> | <?php } ?><a href="index.php?action=logout"><?php echo TXT_LOGOUT; ?></a></div>
</td></tr>

<tr>
  <td valign="top" height="230">
    <table id="fe_sales" width="100%" cellspacing="0">
    <tr>
      <td valign="top">
	
	 <table width="100%">
	  <tr height="16"><td>

	      <!-- CUSTOMER INFO -->
		  <TABLE cellspacing="0" cellpadding="0">
		  <TR>
	            <TD>
	              <div id="customerDiv0">&nbsp;</div>
	              <div id="customerDiv1">
	                <div id="customer_menu"><a href="javascript:showCustomerDiv(0)"><?php echo TXT_CLOSE; ?></a>
	                </div>
		        <table><tr><td><input type="text" id="findcustomertext"></td><td><input type="button" value="<?php echo TXT_FIND; ?>" onClick="javascript:loadXMLDoc('','getCustomers')"></td></tr></table>
			<table id="findcustomerstable"><tr><td></td></tr></table>
			<div id="findCustomersDiv"></div>
		      </div>
		      <div id="customerDiv2"> 
			<div id="customer_menu"><a href="javascript:showCustomerDiv(0)"><?php echo TXT_CLOSE; ?></a>
	                </div>
			<!-- Add Customer -->
			<form name="fe_addcustomer_form">
			<table>
			<TR><TD><?php echo TXT_FIRSTNAME; ?></TD><TD><input type="text" name="firstname" size="40"></TD></TR>
			<TR><TD><?php echo TXT_LASTNAME; ?></TD><TD><input type="text" name="lastname" size="40"></TD></TR>
			<TR><TD><?php echo TXT_ACCOUNT_NUMBER; ?></TD><TD><input type="text" name="account_number" size="30"></TD></TR>
			<TR><TD><?php echo TXT_ADDRESS; ?></TD><TD><input type="text" size="60" name="address"></TD></TR>
			<TR><TD><?php echo TXT_CITY; ?></TD><TD><input type="text" size="40" name="city"></TD></TR>
			<TR><TD><?php echo TXT_PCODE; ?></TD><TD><input type="text" size="20" name="pcode"></TD></TR>
			<TR><TD><?php echo TXT_STATE; ?></TD><TD><input type="text" size="40" name="state"></TD></TR>
			<TR><TD><?php echo TXT_COUNTRY; ?></TD><TD><input type="text" size="50" name="country"></TD></TR>
			<TR><TD><?php echo TXT_PHONE; ?></TD><TD><input type="text" size="20" name="phone_number"></D></TR>
			<TR><TD><?php echo TXT_EMAIL; ?></TD><TD><input type="text" size="60" name="email"></TD></TR>
			<TR><TD><?php echo TXT_DISCOUNT; ?></TD><TD><input type="text" size="3" name="email" style="text-align: right;"></TD></TR>
			<TR><TD valign="top"><?php echo TXT_COMMENTS; ?></TD><TD><textarea rows="5" cols="50" name="comments"></textarea></TD></TR>
			<TR><TD colspan="2"><input type="button" value="<?php echo CUSTOMER_SUBMIT; ?>" onClick="javascript:loadXMLDoc('','addCustomer')"></TD></TR>
			</table>
			</form>
		      </div>
		    </TD>
		    <TD valign="top"><INPUT id="customerButton" TYPE="button" onClick="showCustomerDiv(1)" value="<?php echo TXT_CUSTOMER; ?>">
		    </TD>
		  </TR>
		  </TABLE>

		  <div id="customerData">&nbsp;</div>
	      <!-- END CUSTOMER INFO -->

	  </td></tr>
	  <tr><td>
	    <form action="index.php" method="post" name="frm_sale">
		<input type="hidden" name="order_id" value="">
		<input type="hidden" name="customer_id" value="0">
	    <div id="sales_items">
	      <table width="100%" id="tbl_sitems" cellspacing="0">
                <tr>
		    <th><?php echo TXT_ITEM; ?></th>
		    <?php if (isset($_GET['order_id'])) { ?>
		    <th width="10%" align="right"><?php echo TXT_ORDERED; ?></th>
		    <?php } ?>
		    <th width="10%" align="right"><?php echo TXT_QTY; ?></th>
		    <th width="10%" align="right"><?php echo TXT_TAX; ?></th>
		    <th width="10%" align="right"><?php echo TXT_PRICE; ?></th>
		    <th width="16px" align="center">D</th>
                </tr>
                </table>
	    </div>
	  </td></tr>
	  <tr height="16"><td align="right">
	    <table>
		<TR><TD><?php echo TXT_DISCOUNT; ?>: </TD><TD class="scurrency1"><input type="text" name="discount" id="vdiscount" class="sale_value" value="0" size="3" style="text-align: right;" readonly> %</TD><TD><?php echo TXT_TAX; ?>: </TD><TD><?php echo CURRENCY; ?></TD><TD class="scurrency1"><input type="text" name="tax" id="vtax" class="sale_value" value="0" readonly></TD><TD><?php echo TXT_SUBTOTAL; ?>: </TD><TD><?php echo CURRENCY; ?></TD><TD class="scurrency1"><input type="text" name="subtotal" id="vsubtotal" class="sale_value" value="0" readonly></TD></TR>
	        <TR><TD><?php echo TXT_DISCOUNT; ?>: </TD><TD class="scurrency1"><input type="text" name="discountvalue" id="vdiscountvalue" class="sale_value" value="0" readonly></TD><TD colspan="4" align="right"><?php echo TXT_TOTAL; ?>: </TD><TD><?php echo CURRENCY; ?></TD><TD class="scurrency2"><input type="text" name="total" id="vtotal" class="sale_value" value="0" readonly></TD></TR>
	    </table>
	  </td></tr>
	 </table>
	</form>
      </td>
      <td width="392">
	<!-- KEYBOARD -->
	<table cellspacing="1">
	<tr><td class="keybn" onClick="setQuantity(document.getElementById('tbl_sitems'),'1')" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">1</td><td class="keybn" onClick="setQuantity(document.getElementById('tbl_sitems'),'2')" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">2</td><td class="keybn" onClick="setQuantity(document.getElementById('tbl_sitems'),'3')" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">3</td><td class="keybn" onClick="setQuantity(document.getElementById('tbl_sitems'),'4')" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">4</td><td class="keybn" onClick="keyboardUP(document.getElementById('tbl_sitems'))" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">UP</td><td  class="keybv" onClick="checkout()" onMouseDown="this.className='keybv_click'" onMouseUp="this.className='keybv'" rowspan="2">CHECKOUT</td></tr>
	<tr><td class="keybn" onClick="setQuantity(document.getElementById('tbl_sitems'),'5')" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">5</td><td class="keybn" onClick="setQuantity(document.getElementById('tbl_sitems'),'6')" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">6</td><td class="keybn" onClick="setQuantity(document.getElementById('tbl_sitems'),'7')" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">7</td><td class="keybn" onClick="setQuantity(document.getElementById('tbl_sitems'),'8')" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">8</td><td class="keybn" onClick="keyboardDOWN(document.getElementById('tbl_sitems'))" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">DW</td></tr>
	<tr><td class="keybn" onClick="setQuantity(document.getElementById('tbl_sitems'),'9')" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">9</td><td class="keybn" onClick="setQuantity(document.getElementById('tbl_sitems'),'0')" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">0</td><td class="keybn" onClick="keyboardDEL(document.getElementById('tbl_sitems'))" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">DEL</td><td class="keybn" onClick="keyboardCLEAR(document.getElementById('tbl_sitems'))" onMouseDown="this.className='keybn_click'" onMouseUp="this.className='keybn'">CLEAR</td><td class="keybh" onClick="calcS()" onMouseDown="this.className='keybh_click'" onMouseUp="this.className='keybh'" colspan="2">ENTER</td></tr>
	</table>
	<!-- END KEYBOARD -->
      </td>
    </tr>
    </table>
  </td>
</tr>

<tr>
  <td>
  <!-- CATEGORIES AND ITEMS -->
  <table width="100%" height="100%" cellspacing="0">
    <tr>
    <td width=350 height="100%" valign="top">
      <div id="fe_categories">
      <?php
	$sql = "select * from categories";
	$result = $db->query($sql);
	while($row = mysql_fetch_row($result)){
	?>
	  <table class="tabcategory" onClick="javascript:loadXMLDoc('getItems.php?category=<?php echo $row[0]; ?>','getItems')"><tr><td><img src="<?php echo $row[2]; ?>"></td></tr><tr><td><?php echo htmlspecialchars($row[1]); ?></td></tr></table>
	<?php
	}
	?>
      </div>
    </td>
    <td height="100%" valign="top">
      <div id="fe_items">
&nbsp;      </div>
    </td>
  </tr></table>
  <!-- END CATEGORIES AND ITEMS -->
  </td>
</tr>

</table>
<?php

//END MAIN CONTENT TABLE

}
?>
</TD></TR>
<TR height="16"><TD><?php require_once("footer.php"); ?></TD></TR>
</table>

</body>
</html>
