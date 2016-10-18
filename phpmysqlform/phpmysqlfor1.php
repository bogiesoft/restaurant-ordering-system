<?php
 
class phpmysqlform{

  function phpmysqlform(){

  }

  function print_input($field_descriptor, $field_name,$value) {
    echo '<input name="' . $field_name . '" value="' . htmlspecialchars($value) . '" '; 

    if (array_key_exists("show", $field_descriptor)) {
      echo 'type="';
      switch ($field_descriptor["show"]) {
        case "hide":
	  echo 'hidden';
	  break;
	case "text";
	  echo 'text';
	  break;
      }
      echo '" ';
    }

    if (array_key_exists("size", $field_descriptor)) {
      echo 'size="' . $field_descriptor["size"] . '" ';
    }

    echo '/>';
  }
  
  function forms($fields_descriptor, $field_values, $form_title, $button_title) {
    echo '
    <div class="admin_content">
    <h1>' . $form_title . '</H1>
    <form action="" method="POST">
    ';
    foreach ($field_descriptor  as $field_name => $field_data) {
      print_input ($field_data, $field_name, $field_values[$field_name]);
    }
    echo '<input type="submit" name="edit" value="' . $button_title . '">
  </form>';
  }
  
  echo "<div>";
  forms($fields_descriptor, $field_values, $form_title["edit_form_title"], $button_title["edit_form_button"]);
  echo "</div>
  <div>";
  forms($fields_descriptor, $field_values, $form_title["add_new_item_title"], $button_title["add_new_item_buttom"]);
  echo '</div>
<table cellspacing="0">
<TR>";
    foreach ($fields_descriptor as $descriptor) {
	if  ($descriptor['show'] <> "hide") {
	    echo '<TH>' . $descriptor['label'] . '</TH>';
	}
    }

    echo "</TR>";

    foreach ($field_values as $row) {
	foreach ($row as $value) {
	echo '<TR><TD class="btvalue">' . $value . '</TD>';
	}
	echo '<TD><a>"><img height="20" src="images/edit.png"></a></TD><TD><a><img height="20" src="images/delete.png"></a></TD></TR>';
    }

?>
<TR><TD></TD></TR>
</table>
