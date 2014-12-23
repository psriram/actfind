<?php
try {
$layoutFile = 'layouts/templateSelf';
  if (!empty($_GET['my'])) {
    $my = true;
  }
if (empty($my)) {
  $my = false;
}

if (!empty($my)) {
  check_login();
}

$layoutStructure = 'autoTimeline';

$colname_rsModule = "1";
if (isset($_GET['module_id'])) {
  $colname_rsModule = $_GET['module_id'];
}

$t = (3600*24);

$query = "SELECT * FROM z_modules WHERE module_id = ?";
$resultModule = $modelGeneral->fetchRow($query, array($colname_rsModule), $t);
if (empty($resultModule)) {
  throw new Exception('Could not find the module');
}

if ($resultModule['module_status'] == 0) {
  throw new Exception('module is inactive');
}

if ($resultModule['browse_page'] == 0 && !$my) {
  throw new Exception('browse page is not accessible');
}

if ($resultModule['my_page'] == 0 && $my) {
  throw new Exception('my page is not accessible');
}

$tablename = 'auto_'.$resultModule['module_name'];

$query = "SELECT * FROM z_modules_fields WHERE module_id = ? ORDER BY sorting ASC";
$resultModuleFields = $modelGeneral->fetchAll($query, array($colname_rsModule), $t);
if (empty($resultModuleFields)) {
  throw new Exception('Could not find the module fields');
}
//pr($resultModuleFields);

//getting records
$mutilselectFrom = '';
$locationBox = false;
$cacheTime = 300;
$maxRows_rsView = 25;
$pageNum_rsView = 0;
if (isset($_GET['pageNum_rsView'])) {
  $pageNum_rsView = $_GET['pageNum_rsView'];
}
$startRow_rsView = $pageNum_rsView * $maxRows_rsView;
$distanceFrom = '';
$distanceWhere = '';
$searchCriteria = '';
if (!empty($my)) {
  $cacheTime = 0;
  $searchCriteria .= ' AND a.rc_deleted = 0 AND a.user_id = '.$modelGeneral->qstr($_SESSION['user']['id']);
} else {
    $searchCriteria .= ' AND a.rc_approved = 1 AND a.rc_status = 1 AND a.rc_deleted = 0';
}
$orderBy = ' ORDER BY a.id DESC';

//image field name
$imageFieldName = 'images';
//image field name ends

foreach ($resultModuleFields as $k => $v) {
  //image field name
  if ($v['field_type'] === 'images') {
    $imageFieldName = $v['field_name'];
  }
  //searchable
  if ($v['searchable'] == 0) {
    continue;
  }
  if ($v['field_type'] == 'double' || $v['field_type'] == 'int') {
    if (!empty($_GET[$v['field_name']]['min'])) {
      $value = $_GET[$v['field_name']]['min'];
      $searchCriteria .= ' AND a.'.$v['field_name'].' >= '.GetSQLValueString($value, 'double');
    }
    if (!empty($_GET[$v['field_name']]['max'])) {
      $value = $_GET[$v['field_name']]['max'];
      $searchCriteria .= ' AND a.'.$v['field_name'].' <= '.GetSQLValueString($value, 'double');
    }
  } else if ($v['field_type'] == 'addressbox' && !empty($_GET['lat']) && !empty($_GET['lng'])) {
    $locationBox = true;
    if (empty($_GET['radius'])) {
      $_GET['radius'] = 30;
    }
    $distanceFrom = ", (ROUND(DEGREES(ACOS(SIN(RADIANS(".GetSQLValueString($_GET['lat'], 'double').")) * SIN(RADIANS(a.clatitude)) + COS(RADIANS(".GetSQLValueString($_GET['lat'], 'double').")) * COS(RADIANS(a.clatitude)) * COS(RADIANS(".GetSQLValueString($_GET['lng'], 'double')." -(a.clongitude)))))*60*1.1515,2)) as distance";
    $orderBy = ' ORDER BY distance DESC, a.id DESC';
    if (empty($_GET['wholeworld'])) {
      $distanceWhere = " AND (ROUND(DEGREES(ACOS(SIN(RADIANS(".GetSQLValueString($_GET['lat'], 'double').")) * SIN(RADIANS(a.clatitude)) + COS(RADIANS(".GetSQLValueString($_GET['lat'], 'double').")) * COS(RADIANS(a.clatitude)) * COS(RADIANS(".GetSQLValueString($_GET['lng'], 'double')." -(a.clongitude)))))*60*1.1515,2)) <= ".GetSQLValueString($_GET['radius'], 'int');
    }
  } else if ($v['field_type'] == 'selectbox') {
    if (!empty($_GET[$v['field_name']])) {
      $tmp = array();
      foreach ($_GET[$v['field_name']] as $sel => $value) {
        $tmp[] = $value;
      }
      $value = "'".implode("','", $tmp)."'";
      $searchCriteria .= ' AND a.'.$v['field_name'].' IN ('.$value.')';
    }
  } else if ($v['field_type'] == 'multipleselectbox') {
    $mutilselectFrom = ' LEFT JOIN auto_pre_multiselectcats as mc ON a.id = mc.id';
    if (!empty($_GET[$v['field_name']])) {
      $tmp = array();
      foreach ($_GET[$v['field_name']] as $sel => $value) {
        $tmp[] = '(mc.col_name = \''.$v['field_name'].'\' AND mc.category_id = \''.$value.'\')';
      }
      $value = implode(" OR ", $tmp);
      $searchCriteria .= ' AND ('.$value.')';
    }
  } else if ($v['field_type'] == 'checkbox') {
    if (isset($_GET[$v['field_name']])) {
      $searchCriteria .= " AND a.".$v['field_name']." = ".GetSQLValueString($_GET[$v['field_name']], 'int');
    }
  } 
}

$tagsTable = '';
$tagsWhere = '';
if (!empty($_GET['keyword'])) {
    $tmp = array();
    $tmp2 = array();
    foreach ($resultModuleFields as $k => $v) {
      if ($v['searchable'] == 1 && ($v['field_type'] == 'varchar' || $v['field_type'] == 'text')) {
        $tagsTable = ' LEFT JOIN auto_pre_tags as tg ON a.id = tg.id';
        $tmp[] = "a.".$v['field_name']." LIKE ".GetSQLValueString('%'.$_GET['keyword'].'%', 'text');
        $tmp2[] = "tg.tag = ".GetSQLValueString($_GET['keyword'], 'text');
      }
    }
    if (!empty($tmp)) {
      $tmp2[] = implode(' OR ', $tmp);
    }
    if (!empty($tmp2)) {
      $tagsWhere = ' AND ('.implode(' OR ', $tmp2).')';
    }
}

$query_rsView = "SELECT a.*, u.name as fullname, u.* $distanceFrom FROM $tablename as a LEFT JOIN auth as u ON a.user_id = u.user_id $mutilselectFrom $tagsTable WHERE a.module_id = ".$colname_rsModule." $searchCriteria $distanceWhere $tagsWhere $orderBy";
$query_limit_rsView = sprintf("%s LIMIT %d, %d", $query_rsView, $startRow_rsView, $maxRows_rsView);
log_log($query_limit_rsView);
$rsView = $modelGeneral->fetchAll($query_limit_rsView, array(), $cacheTime);
log_log($rsView);
//echo $query_rsView;
//pr($rsView);

//getting rowCount
$queryTotalRows = "SELECT COUNT(*) as cnt FROM $tablename as a LEFT JOIN auth as u ON a.user_id = u.user_id $mutilselectFrom $tagsTable WHERE a.module_id = ".$colname_rsModule." $searchCriteria $distanceWhere $tagsWhere";
if (isset($_GET['totalRows_rsView'])) {
  $totalRows_rsView = $_GET['totalRows_rsView'];
} else {
  $rowCountResult = $modelGeneral->fetchRow($queryTotalRows, array(), 300);
  $totalRows_rsView = $rowCountResult['cnt'];
}
$totalPages_rsView = ceil($totalRows_rsView/$maxRows_rsView)-1;

//getString
$get_rsViewRaw = getString(array('pageNum_rsView', 'totalRows_rsView'));
$get_rsView = sprintf("&totalRows_rsView=%d%s", $totalRows_rsView, $get_rsViewRaw);
log_log($get_rsView, 'get_rsView');
//getString Ends

if (!empty($_GET['clear'])) {
  $modelGeneral->clearCache($query_limit_rsView, array());
  $modelGeneral->clearCache($queryTotalRows, array());
  $getURL = getString(array('totalRows_rsView', 'clear'));
  if ($my)
    header("Location: ".HTTPPATH.'/my?'.$getURL);
  else
    header("Location: ".HTTPPATH.'/browse?'.$getURL);
  exit;
}

//end browse

//search box
ob_start();
//include(SITEDIR.'/mods/auto/searchbox.php');
$search_box = ob_get_clean();
//search box ends
//include(SITEDIR.'/libraries/addresses/nearbyforcity.php');
$pageTitle = 'Search/Browse '.$resultModule['menu_display_name'];

?>
<?php if ($totalRows_rsView > 0) { // Show if recordset not empty ?>
<!--Display List Starts Here -->

<?php
include(SITEDIR.'/display_list_template/'.$resultModule['display_list_template'].'.php');
?>

<p><strong>Records <?php echo ($startRow_rsView + 1) ?> to <?php echo min($startRow_rsView + $maxRows_rsView, $totalRows_rsView) ?> of <?php echo $totalRows_rsView ?></strong>
</p>
<ul class="pager">
  <?php if ($pageNum_rsView > 0) { // Show if not first page ?>
  <li class="previous"><a href="<?php printf("%s?pageNum_rsView=%d%s", $currentURL.'/auto/browse', max(0, $pageNum_rsView - 1), $get_rsView); ?>">&larr; Previous</a></li>
  <?php } // Show if not first page ?>
  <?php if ($pageNum_rsView < $totalPages_rsView) { // Show if not last page ?>
  <li class="next"><a href="<?php printf("%s?pageNum_rsView=%d%s", $currentURL.'/auto/browse', min($totalPages_rsView, $pageNum_rsView + 1), $get_rsView); ?>">Next &rarr;</a></li>
  <?php } // Show if not last page ?>
</ul>

<!--Display List Ends Here -->
<?php } // Show if recordset not empty ?>

<?php if ($totalRows_rsView == 0) { // Show if recordset empty ?>
<div>No Record Found.</div>
<?php } // Show if recordset empty ?>


<?php } catch (Exception $e) {
  ?>
  <h3>Error!!</h3>
  <?php
  echo $e->getMessage();
}
?>