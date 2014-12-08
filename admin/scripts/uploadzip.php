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

$file = SITEDIR.'/admin/scripts/files/zip_code_database.csv';
$line = array();
$row = -1;
$county = '';
$start = false;
exit;
if (($handle = fopen($file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $row++;
        if ($row == 0) continue;
        if ($data[0] == '99573') {
          $start = true;
        }
        if (!$start) {
          continue;
        }
        if (!empty($data[6])) {
          $county = $data[6];
        }
        $insertSQL = sprintf("INSERT INTO geo_zipcodes (zipcode, city, `state`, county, z_lat, z_lon, country, area_codes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($data[0], "text"),
                       GetSQLValueString($data[2], "text"),
                       GetSQLValueString($data[5], "text"),
                       GetSQLValueString($county, "text"),
                       GetSQLValueString($data[9], "double"),
                       GetSQLValueString($data[10], "double"),
                       GetSQLValueString($data[12], "text"),
                       GetSQLValueString($data[8], "text"));
echo $insertSQL;
echo ";<br>";

          mysql_select_db($database_connMain, $connMain);
          $Result1 = @mysql_query($insertSQL, $connMain);
    }
    fclose($handle);
}
exit;
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO geo_zipcodes (zipcode, city, `state`, county, z_lat, z_lon, country, area_codes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['zipcode'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['county'], "text"),
                       GetSQLValueString($_POST['z_lat'], "double"),
                       GetSQLValueString($_POST['z_lon'], "double"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['area_codes'], "text"));

  mysql_select_db($database_connMain, $connMain);
  $Result1 = mysql_query($insertSQL, $connMain) or die(mysql_error());
}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Zipcode:</td>
      <td><input type="text" name="zipcode" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">City:</td>
      <td><input type="text" name="city" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">State:</td>
      <td><input type="text" name="state" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">County:</td>
      <td><input type="text" name="county" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Z_lat:</td>
      <td><input type="text" name="z_lat" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Z_lon:</td>
      <td><input type="text" name="z_lon" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Country:</td>
      <td><input type="text" name="country" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Area_codes:</td>
      <td><input type="text" name="area_codes" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>