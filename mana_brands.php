<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['admin'])){
header("Location:manager.php");
}


?>
<div class="admin_content">
<?php
if(isset($_GET['edit'])){

}
else{
?>
<form action="manager.php?action=brands" method="POST">
<?php ?>
</form>
<br>
<table cellspacing="0">
<TR><TH width="300"><?php echo HDR_BRAND; ?></TH></TR>
<?php
$sql = "select * from brands";
$result = $db->query($sql);
while($row = mysql_fetch_row($result)){
?><TR><TD class="btvalue"><a
href="manager.php?action=products&brand=<?php echo $row[0]; ?>"><?php
echo htmlspecialchars($row[1]); ?></a></TD><?php
}
?>
<TR><TD></TD></TR>
</table>
<?php
}
?>
</div>
