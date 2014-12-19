<?php
$shareUrl_job = $page_link ."?sk=app_379258938775123&app_data=" . $job->id;
$description = nl2br($job->description);
$description = str_replace("\r\n",'',$description);
$description = str_replace("\r",'',$description);
$description = str_replace("\n",'',$description);
$description = str_replace("'","\'",$description);
?>
<script type="text/javascript">
    var shareUrl_job_<?=$job->id?>="<?php echo $shareUrl_job; ?>";
		var page_id_<?=$job->id?>="<?php echo $page_id; ?>";
		var share_image_<?=$job->id?>="<?php echo $share_image; ?>";
    var job_title_<?=$job->id?>="<?=$job->title?>";
    var job_description_<?=$job->id?>='<?=strip_tags($description)?>';
</script>
<div class="entry">
    <p class="entry-top">
        <strong><?=$job->title?></strong>
    </p>
    <div class="clear"></div>
    <div class="entry-content">
      <?php if (!empty($job->image)): ?>
        <img style="float: left; margin-right: 10px;" alt="" src="<?=base_url() . 'image.php?width=200&amp;height=200&amp;image=' . base_url() . 'images/jobs/' . $job->id . '/' . $job->image?>" />
      <?php else:?>
         <img style="float: left; margin-right: 10px;"  width="90" height="56" alt="" src="<?=base_url() . 'images/img.png'?>"/>
      <?php endif; ?>  
        <p class="entry-text floated">
        <div style="padding-left: 10px; height: 92px; overflow:hidden;">
            <?=$job->description?> 
          
        </div>
          <a href="<?=base_url() . 'main/readmore/' . $job->id?>" style="text-decoration: underline; color: #3E58B7; font-size: 13px !important;">read more</a>
        </p>
    </div>
    <div class="entry-bottom">
        <div class="left">
            <span>RATE</span>
            <span style="font-size: 13px !important;"><?=$job->rate?></span>
        </div>
        <div class="right">
          <a target="_blank" href="<?php echo($job->link_to_apply)?>">apply</a>
            <a href="javascript:void(0);" onclick="postToFeed(shareUrl_job_<?=$job->id?>,share_image_<?=$job->id?>, job_title_<?=$job->id?>, job_description_<?=$job->id?>);">share</a>
            <a href="javascript:void(0);"  onclick="sendInvite(page_id_<?=$job->id?>);">tell a friend</a>
        </div>
    </div>
</div>