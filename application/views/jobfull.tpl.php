<?php
$data = $_SESSION['data'];
$baseUrl = base_url();

$job_id= isset($data["app_data"]) ? $data["app_data"] : false;
$page_id=$data["page"]["id"];
$page_data = json_decode(file_get_contents("https://graph.facebook.com/$page_id"));
$page_link=$page_data->link;


$share_image = $baseUrl . "images/img.png";
$shareUrl_main = $page_link ."?sk=app_379258938775123";
//$shareUrl_job = $page_link ."?sk=app_379258938775123&app_data="; // put job id
//echo "Page ID=" .$page_id . "<br/>page link =". $shareUrl_main . "<br/>job id =". $job_id;

///if (isset($data["app_data"]))
//	{
//	// show post.php with ID = $job_id
//	// break
//      redirect(base_url() . 'main/postjobform');
//	}
$shareUrl_job = $page_link ."?sk=app_379258938775123&app_data=" . $job->id;
$description = nl2br($job->description);
$description = str_replace("\r\n",'',$description);
$description = str_replace("\r",'',$description);
$description = str_replace("\n",'',$description);
$description = str_replace("'","\'",$description);
?>
<script type="text/javascript">
    var shareUrl_job="<?php echo $shareUrl_job; ?>";
		var page_id="<?php echo $page_id; ?>";
		var share_image="<?php echo $share_image; ?>";
    var job_title="<?=$job->title?>";
    var job_description="<?=strip_tags($description)?>";
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<script type="text/javascript">
			function framesetsize(w,h)
			{
			var obj =   new Object;
			obj.width=w;
			obj.height=h;
			FB.Canvas.setSize(obj);
			}
		</script>
		<link rel="stylesheet" href="<?=base_url()?>css/style.css" type="text/css" />
		<script src="<?=base_url()?>js/jquery/jquery-1.7.1.min.js" type="text/javascript"></script>
		<script src="<?=base_url()?>js/fb-functions.js" type="text/javascript" ></script>
	</head>
	<body onload="framesetsize(810,1500);document.getElementById('hdn').focus();"> <!--specify the height and width for resize-->
		<div id="fb-root"></div> <!--this div is required by the Javascript SDK-->
		
		<div id="container">
                    <input type="text" style="height: 1px;width:1px;position: relative;top: 0px;" id="hdn" />
                    <div id="job-top">
                        <a target="_blank" href="<?php echo($job->link_to_apply)?>">apply</a>
                        <a href="<?=base_url()?>main/postjobform">post a job </a>
                        <a href="<?=base_url()?>main/index">Job Board</a>
                    </div>
                    <div class="entry">
                        <p class="entry-top">
                            <strong><?=$job->title?></strong>
                        </p>
                        <div class="clear"></div>
                        <div class="entry-content" style="padding:20px; width: 728px !important;">
                            <?=$job->description?>
                            <?php /*
                            <p>City and State: <?=$job->country_state?> <br />
                            Start Date: <?=$job->day . '/' . $job->month . '/' .$job->year ?> <br />
                            Duration: <?=$job->duration?>
                            </p>
                             <?php */ ?>
                        </div>
                        <div class="entry-bottom">
                            <div class="left">
                                <span>RATE</span>
                                <span style="font-size: 13px !important;"><?=$job->rate?></span>
                            </div>
                            <div class="right">
                                <a target="_blank" href="<?php echo($job->link_to_apply)?>">apply now</a>
                                <a href="<?=base_url()?>main/index">Job Board</a>
                                <a href="javascript:void(0)" onclick="sendMessage(shareUrl_job,share_image, job_title, job_description);">send</a>
                                <a href="javascript:void(0);" onclick="postToFeed(shareUrl_job,share_image, job_title, job_description);">share</a>
                                <a href="javascript:void(0);"  onclick="sendInvite(page_id);">tell a friend</a>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($job->image)): ?>
                      <img alt="" src="<?=base_url() . 'image.php?width=500&amp;height=300&amp;image=' . base_url() . 'images/jobs/' . $job->id . '/' . $job->image?>" class="center" />
                    <?php else: ?>
                      <img width="344" height="125" alt="" src="<?=base_url() . 'images/img2.png'?>" class="center" />
                    <?php endif; ?>    
    </div>          
		<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
	</body>
</html>
