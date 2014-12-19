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
		<script src="<?=base_url()?>js/jquery/jquery.validate.min.js" type="text/javascript" ></script>
		<link rel="stylesheet" href="<?=base_url()?>css/style.css" type="text/css" />
	</head>
	<body onload="framesetsize(810,1500);document.getElementById('hdn').focus();"> <!--specify the height and width for resize-->
		<div id="fb-root"></div> <!--this div is required by the Javascript SDK-->
		
		<div id="container">
                    <input type="text" style="height: 1px;width:1px;position: relative;top: 0px;" id="hdn" />
                    <div id="job-top">
                        <a href="<?=base_url()?>main">back</a>
                    </div>
                    <div class="entry">
                        <p class="entry-top">
                            post a job
                        </p>
                        <div class="clear"></div>
                        <div class="entry-content">
                            <p>
                               Hi! Just so you know by filling out this form the job will be sent to ProductionNotices@gmail.com so we can screen it first to make sure it's all good. If we have any questions we will contact you before posting. After that it will get posted right away! </p>
                            <p>
                                Keep in mind that Castings get submitted to PNCastingNotices@gmail.com, thanks! 
                            </p>
                            <form action="<?=base_url()?>main/sendmail" method="post" id="form">
                              <input type="hidden" name="lastpage" value="<?=substr($lastpage,0,strpos($lastpage, '&'))?>" />
                                <div class="field">
                                    <label>City and State the Job is in<span class="req">*</span></label>
                                    <input type="text" name="city" class="text required" />
                                </div>
                                <div class="field">
                                    <label>Job title<span class="req">*</span></label>
                                    <input type="text" name="job" class="text required" />
                                </div>
                                <div class="field">
                                    <label>Start Date (approx):<span class="req">*</span></label>
                                    <select class="select1 required" name="year">
                                        <option value="default">Year</option>
                                        <?php for($i = 2012; $i <= 2018; $i++):?>
                                          <option value="<?=$i ?>"><?=$i?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <select class="select1 required" name="month">
                                        <option value="default">Month</option>
                                         <?php for($i = 1; $i <= 12; $i++):?>
                                          <option value="<?=$i ?>"><?=$i?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <select class="select1 required" name="date">
                                        <option value="default">Date</option>
                                         <?php for($i = 1; $i <= 31; $i++):?>
                                          <option value="<?=$i ?>"><?=$i?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="field">
                                    <label>Duration</label>
                                    <input type="text" name="duration" class="text" />
                                </div>
                                <div class="field">
                                    <label>Rate<span class="req">*</span></label>
                                    <select class="select2 required" name="rate">
                                        <option value="default">Select...</option>
                                        <option value="FULLY PAID">FULLY PAID</option>
                                        <option value="LOW BUDGET">LOW BUDGET</option>
                                        <option value="UNPAID">UNPAID</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label>Approximate Daily rate</label>
                                    <input type="text" class="text" name="dailyrate" />
                                </div>
                                <div class="field">
                                    <label>Contact E-mail address to apply<span class="req">*</span></label>
                                    <input type="text" class="text required" name="emailapply" />
                                </div>
                                <div class="field">
                                    <label>Contact E-mail address for you<span class="req">*</span></label>
                                    <input type="text" class="text required" name="emailyou" />
                                </div>
                                <p>
                                    (Just in case we have any questions, this email address will NOT be added in the post)
                                </p>
                                <div class="field">
                                    <label>Job description<span class="req">*</span></label>
                                    <textarea rows="5" cols="5" class="required" name="desc"></textarea>
                                </div>
                                <p>
                                   Please include as many details as possible about the Job. If this is a Low Budget listing, please include how much you're offering for each position so this works smoother all around. 
                                </p>
                                <fieldset>
                                    <legend>captcha</legend>
                                    <p>
                                        This question is for..
                                    </p>
                                    <div class="field">
                                        <label>Math question<span class="req">*</span></label>
                                        <span>9 + 6 = </span>
                                        <input type="text" class="textsmall text required" name="captcha" id ="captcha" />
                                    </div>
                                    <p>
                                        Solve this simple math problem and enter the result
                                    </p>
                                </fieldset>
                            </form>
                        </div>
                        <div class="entry-bottom">
                            <div class="right">
                                <a href="javascript:void(0)" id="submit">post</a>
                                <a href="<?=base_url()?>index.php">back</a>
                            </div>
                        </div>
                    </div>
		</div>
                <script type="text/javascript">
$(document).ready(function(){
//                        $.validator.addMethod("valueNotEquals", function(value, element, arg){
//  return "default" != value;
// }, "Select an item");
//jQuery.validator.setDefaults({
//    errorPlacement: function(error, element) {
//        $('span.jqInvalid',element.parent()).remove();
//        $('<span class="jqInvalid">(This is a required field)</span>').insertAfter($('span.req',element.parent()));
//    }
//});
// // configure your validation
// $("#form").validate({
//  rules: {
//   year: { valueNotEquals: "default" },
//   month: { valueNotEquals: "default" },
//   date: { valueNotEquals: "default" },
//   rate: { valueNotEquals: "default" }
//  } ,
//  errorClass: 'jqInvalid'
// });
//    $('#submit').click(function(){
//        $('span.jqInvalid').remove();
//        $('#form').submit();
//    }) 
$('#form').validate({
      submitHandler: function(form) {
        if ($('#captcha').val() == 15){
          alert('Thank you! We have recerived your information');
          form.submit();
        }else{
          alert('Sorry, wrong captcha');
        }
      },
      rules: {
        city : 'required',
        job: 'required',
        year: 'number',
        month: 'number',
        date: 'number',
        duration: 'required',
        rate: 'required',
        dailyrate: 'required',
        emailapply: {
          required : true,
          email : true,
        },
        emailyou: {
          required : true,
          email : true,
        },
        desc: 'required',
        captcha: 'required'
      },
        messages: {
        title : '',
        city : '',
        job: '',
        duration: '',
        rate: '',
        dailyrate: '',
        emailapply: '',
        emailyou: '',
        desc: '',
        captcha: '',
        year: '',
        month: '',
        date: '',
     },
     errorClass: 'jqInvalid'
});   


  $('#submit').click(function(){
    $('#form').trigger('submit');
  });
})
                </script>
		<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
	</body>
</html>
