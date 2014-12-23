<?php
$layoutStructure = 'autoTimeline';
?>
<div class="row">
  <div class="[ col-xs-12 col-sm-offset-0 col-sm-12 ]">
    <ul class="event-list">
      <?php foreach ($rsView as $key => $rowResult) {

//decryption
foreach ($resultModuleFields as $k => $v) {
  if (!empty($rowResult[$v['field_name']]) && $v['encrypted'] == 1) {
    $rowResult[$v['field_name']] = decryptText($rowResult[$v['field_name']]);
  }
}
//decryption

//point system
$id = !empty($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';
$id2 = $rowResult['uid'];
$pointSystem = updatePoints($id, $id2);
$points = '';
$points_result = '';

if (!empty($pointSystem)) {
  
    $points = $pointSystem[$id][$id2]['points'];
    $points_result = $pointSystem[$id][$id2]['results'];
}
//point system ends
//image
$image = $rowResult['picture'];
if (!empty($rowResult[$imageFieldName])) {
  $images = json_decode($rowResult[$imageFieldName], 1);
  if (!empty($images)) {
    $image = $images[0];
  }
}
//image

$dt = !empty($rowResult['display_date']) ? $rowResult['display_date'] : $rowResult['rc_created_dt'];
$title = !empty($rowResult['title']) ? $rowResult['title'] : '';

$address = '';
if (!empty($rowResult['showAddress'])) {
  $address = !empty($rowResult['address2']) ? $rowResult['address2'] : $rowResult['address'];
}



$tmp = explode(' ', $dt);
$date = $tmp[0];
$time = $tmp[1];
$tmp = explode('-', $date);
$year = $tmp[0];
$month = $tmp[1];
$day = $tmp[2];

?>
<li>
<time datetime="<?php echo $dt; ?>">
  <span class="day"><?php echo $day; ?></span>
  <span class="month"><?php echo monthString($month); ?></span>
  <span class="year"><?php echo $year; ?></span>
  <span class="time"><?php echo $time; ?></span>
</time>
<img src="<?php echo $image; ?>" />
<div class="info">
    <?php $detailURL = $currentURL.'/auto/detail?module_id='.$colname_rsModule.'&id='.$rowResult['id']; ?>
    <h2 class="title"><?php echo $title; ?></h2>
    <p class="desc" style="font-size:11px">
        <strong>Date: </strong><?php echo $dt; ?><?php if (!empty($rowResult['distance']) && !empty($rowResult['showAddress'])) { ?><span class="pull-right"><strong>Distance: </strong><?php echo $rowResult['distance']; ?> mi</span><?php } ?><br>
        <?php if (!empty($rowResult['showAddress'])) { ?>
        <?php echo $address; ?><br>
        <?php } ?>
        By <?php echo $rowResult['fullname']; ?><br>
        <?php if (!empty($points) && $resultModule['user_points_matching'] == 1) { ?>
            <strong>User Matching Points *:</strong> <?php echo $points; ?> (<?php echo $points_result; ?>)
        <?php } ?>
        <i><?php echo ($rowResult['rc_status'] == 1) ? '' : '(InActive)'; ?></i>
        <i><?php echo ($rowResult['rc_approved'] == 1) ? '' : '(Approval Pending)'; ?></i>
    </p>
    <?php if (!empty($rowResult['showAddress'])) { ?>
        <script language="javascript">
            var latlng = new google.maps.LatLng(<?php echo $rowResult['latitude']; ?>, <?php echo $rowResult['longitude']; ?>);
            marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: '<?php echo $title; ?>'
            });
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.setContent('<h3><?php echo $title; ?></h3><p style="font-size:11px"><strong>Date: </strong><?php echo $dt; ?></p><p style="font-size:11px"><?php echo $rowResult['address']; ?></p><p style="font-size:11px">By <a href="<?php echo HTTPPATH.'/users/detail?uid='.$rowResult['link']; ?>" rel="nofollow" target="_blank"><?php echo $rowResult['fullname']; ?></a></p>');
                infowindow.open(map, this);
            });
        </script>
    <?php } ?>
    <ul>
    <!--<?php //echo $get_rsView;?>&pageNum_rsView=<?php //echo $pageNum_rsView; ?>-->
        <li style="width:33%;"><a href="<?php echo $currentURL; ?>/auto/detail?id=<?php echo $rowResult['id']; ?>&module_id=<?php echo $colname_rsModule; ?>&my=<?php echo $my; ?>"><span class="fa fa-globe"></span> Details</a></li>
    <?php if (!empty($_SESSION['user']['id']) && $_SESSION['user']['id'] == $rowResult['uid']) { ?>
        <li style="width:33%;"><a href="<?php echo $currentURL; ?>/auto/edit?id=<?php echo $rowResult['id']; ?>&module_id=<?php echo $colname_rsModule; ?>&my=<?php echo $my; ?>"><span class="fa fa-globe"></span> Edit</a></li>
        <li style="width:33%;"><a href="<?php echo $currentURL; ?>/auto/delete?module_id=<?php echo $colname_rsModule; ?>&id=<?php echo $rowResult['id']; ?>&my=<?php echo $my; ?>" onClick="var a = confirm('do you really want to delete this record. you wont be able to recover it again.'); return a;"><span class="fa fa-times"></span> Delete</a></li>
    <?php } ?>
    </ul>
</div>
<div class="social">
  <ul>
    <li class="facebook" style="width:33%;"><a href="javascript:;" onClick="fb('<?php echo $currentURL; ?>/history/detail?id=<?php echo $rowResult['history_id']; ?>');"><span class="fa fa-facebook"></span></a></li>
    <li class="twitter" style="width:34%;"><a href="javascript:;" onClick="MM_openBrWindow('https://twitter.com/home?status=<?php echo urlencode($rowResult['history_title'].' at '.$detailURL); ?>','twitter','location=yes,status=yes,scrollbars=yes,resizable=yes,width=400,height=300')"><span class="fa fa-twitter"></span></a></li>
    <li class="google-plus" style="width:33%;"><a href="javascript:;" onClick="MM_openBrWindow('https://plus.google.com/share?url=<?php echo urlencode($detailURL); ?>','twitter','location=yes,status=yes,scrollbars=yes,resizable=yes,width=400,height=300')"><span class="fa fa-google-plus"></span></a></li>
  </ul>
</div>
</li>








<?php
        } 
      ?>
    </ul>
  </div>
</div>
