<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO categories (category) VALUES (%s)",
                       GetSQLValueString($_POST['category'], "text"));

  mysql_select_db($database_connMain, $connMain);
  $Result1 = mysql_query($insertSQL, $connMain) or die(mysql_error());

  $insertGoTo = "categories";
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE categories SET category=%s WHERE category_id=%s",
                       GetSQLValueString($_POST['category'], "text"),
                       GetSQLValueString($_POST['category_id'], "int"));

  mysql_select_db($database_connMain, $connMain);
  $Result1 = mysql_query($updateSQL, $connMain) or die(mysql_error());

  $updateGoTo = "categories";
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_GET['delete_id'])) && ($_GET['delete_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM categories WHERE category_id=%s",
                       GetSQLValueString($_GET['delete_id'], "int"));

  mysql_select_db($database_connMain, $connMain);
  $Result1 = mysql_query($deleteSQL, $connMain) or die(mysql_error());
}

mysql_select_db($database_connMain, $connMain);
$query_rsView = "SELECT * FROM categories ORDER BY category ASC";
$rsView = mysql_query($query_rsView, $connMain) or die(mysql_error());
$row_rsView = mysql_fetch_assoc($rsView);
$totalRows_rsView = mysql_num_rows($rsView);

$colname_rsEdit = "-1";
if (isset($_GET['edit_id'])) {
  $colname_rsEdit = $_GET['edit_id'];
}
mysql_select_db($database_connMain, $connMain);
$query_rsEdit = sprintf("SELECT * FROM categories WHERE category_id = %s", GetSQLValueString($colname_rsEdit, "int"));
$rsEdit = mysql_query($query_rsEdit, $connMain) or die(mysql_error());
$row_rsEdit = mysql_fetch_assoc($rsEdit);
$totalRows_rsEdit = mysql_num_rows($rsEdit);
?>

<h1>Manage Categories</h1>
<p><a href="manage">Back</a></p>
<form method="post" name="form1" action="">
  <table>
    <tr valign="baseline">
      <td nowrap align="right">Category:</td>
      <td><input type="text" name="category" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
  <h3>View Categories</h3>
  <table border="1" cellpadding="5" cellspacing="0">
    <tr>
      <td><strong>category_id</strong></td>
      <td><strong>category</strong></td>
      <td><strong>Edit</strong></td>
      <td><strong>Delete</strong></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_rsView['category_id']; ?></td>
        <td><?php echo $row_rsView['category']; ?></td>
        <td><a href="categories?edit_id=<?php echo $row_rsView['category_id']; ?>">Edit</a></td>
        <td><a href="categories?delete_id=<?php echo $row_rsView['category_id']; ?>" onClick="return confirm('do you really want to delete this category?');">Delete</a></td>
      </tr>
      <?php } while ($row_rsView = mysql_fetch_assoc($rsView)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rsEdit > 0) { // Show if recordset not empty ?>
  <h3>Edit Category Form</h3>
  <form method="post" name="form2" action="">
    <table>
      <tr valign="baseline">
        <td nowrap align="right">Category:</td>
        <td><input type="text" name="category" value="<?php echo htmlentities($row_rsEdit['category'], ENT_COMPAT, 'UTF-8'); ?>" size="32"></td>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td><input type="submit" value="Update record"></td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form2">
    <input type="hidden" name="category_id" value="<?php echo $row_rsEdit['category_id']; ?>">
  </form>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsView);

mysql_free_result($rsEdit);
?>
