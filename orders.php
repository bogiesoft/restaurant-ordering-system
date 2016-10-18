<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['admin'])){
header("Location:admin.php");
}

//Delete item
if(isset($_GET['delete'])){
    $db->query("DELETE FROM `orders_items` WHERE `orders_items`.`order_id`=" .$_GET['delete']);
    $db->query("DELETE FROM `orders` WHERE `orders`.`id`=" .$_GET['delete']);
}

?>
<div class="admin_content">

<input type="button" onclick="document.location.href='neworder.php'" value="<?php echo TXT_ADD_ORDER; ?> ">

</br></br>
<table cellspacing="0">
<?php

$sql = "SELECT SQL_CALC_FOUND_ROWS `id`, `date`, `customer_id`, `order_total`, `items_ordered`, `sold_by` FROM `orders` LIMIT " . (isset($_GET['page']) ? ($_GET['page']-1)*ITEMS_PER_PAGE : 0) ."," .ITEMS_PER_PAGE;;

$result = $db->query($sql);
//The total of items that this query would return without the limit clause
$found_rows = $db->query("SELECT FOUND_ROWS()");
$total_num_items = mysql_fetch_row($found_rows);
$npages = ceil($total_num_items[0] / ITEMS_PER_PAGE);
?>
<TR>
<TH colspan="2" align="left"> page <?php echo (isset($_GET['page']) ? $_GET['page'] : 1); ?> of <?php echo $npages; ?></TH>
<TH align="right">
<div id="pageset">&nbsp;</div>
</TH>
<?php
if($npages > 1){
?>
<script language="javascript">setPages(<?php echo $npages; ?>,<?php echo (isset($_GET['page']) ? $_GET['page'] : 1); ?>);</script>
<?php
}
?>
</TH></TR>
</table>
<script language="JavaScript">
  function delete_order(item){
    op = confirm("Do you really want to delete this order?");
    if(op)document.location.href="admin.php?action=orders&delete=" + item;
  }
</script>
<table cellspacing="0">
<TR>
<TH width="40"><?php echo TXT_ORDERNUMBER ?></TH>
<TH width="100" align="left"><?php echo TXT_DATE; ?></TH>
<TH align="left" width="300"><?php echo TXT_CUSTOMER; ?></TH>
<TH width="30"><?php echo TXT_ITEMSORDERED; ?></TH>
<TH width="30"><?php echo TXT_TOTAL; ?></TH>
<TH width="150"><?php echo TXT_SOLDBY; ?></TH>
<TH><?php echo TXT_EDIT; ?></TH>
<TH><?php echo TXT_BILL; ?></TH>
<TH><?php echo TXT_DELETE; ?></TH>
</TR>
<?php while ($row = mysql_fetch_assoc($result)) {

$customer_name = mysql_fetch_assoc($db->query("SELECT `first_name`, `last_name` FROM `customers` WHERE `customers`.`id` = " . $row["customer_id"]));

if ($row["sold_by"] == 0) {
    $solder_name = LOGIN_ADMIN;
} else {
    $solder_name = mysql_fetch_assoc($db->query("SELECT `first_name`, `last_name`, `username` FROM `users` WHERE `customers`.`id` = " . $row["sold_by"]));
    $solder_name = $solder_name["first_name"] . $solder_name["last_name"] . " - " . $solder_name["username"];
}
?>
<TR>
<TD width="40" class="btvalue"><?php echo htmlspecialchars($row["id"]); ?></TD>
<TD width="100" class="btvalue"><?php echo htmlspecialchars($row["date"]); ?></TD>
<TD class="tvalue" width="300"><?php echo htmlspecialchars($customer_name["first_name"]  . " " . $customer_name["last_name"]); ?></TD>
<TD width="30" class="tvalue"><?php echo htmlspecialchars($row["items_ordered"]); ?></TD>
<TD width="30" class="tvalue"><?php echo htmlspecialchars($row["order_total"]); ?></TD>
<TD width="150" class="tvalue"><?php echo htmlspecialchars($solder_name); ?></TD>
<TD class="tvalue" align="center"><A href="neworder.php?id=<?php echo $row["id"]; ?> "><img height="20" src="images/edit.png"></A></TD>
<TD class="tvalue" align="center"><A href="index.php?order_id=<?php echo $row["id"]; ?> "><img height="20" src="images/cart.png"></A></TD>
<TD class="tvalue" align="center"><A href="javascript:delete_order(<?php echo $row["id"]; ?>)"><img height="20" src="images/delete.png"></A></TD>
</TR>
<?php };?>
</table>
</div>
