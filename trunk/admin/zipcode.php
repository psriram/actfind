<?php
if (!empty($_GET['q'])) {
  $content = curlget(HTTPPATH.'/api/geo/zip?q='.$_GET['q']);
  $result = json_decode($content, 1);
}
?>
<h1>Zipcode Lookup</h1>
<p><a href="manage">Back</a></p>
<form id="form1" name="form1" method="get">
  <label for="q">Enter Zipcode or partial zipcode:</label>
  <input type="text" name="q" id="q">
  <input type="submit" name="submit" id="submit" value="Submit">
</form>
<p>&nbsp;</p>
<?php
if (!empty($result)) {
  if ($result['success'] == 0) {
    echo $result['msg'];
  } else {
    foreach ($result['data'] as $k => $v) {
      echo $str = $v['zipcode'].' '.$v['city'].', '.$v['state'].', '.$v['country'];
      echo '<br>';
    }
  }
}
?>