<?php



if (isset($data["app_data"]) && $firstTime == 1)
    {
    // show post.php with ID = $job_id
    // break
      redirect(base_url() . 'main/readmore/' . $job_id);
    }
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">

    <head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <link rel="stylesheet" href="<?=base_url()?>css/style.css" type="text/css" media="screen" title="default" />
    <script src="<?=base_url()?>js/jquery/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>js/jquery.blockui.js" type="text/javascript" ></script>
        
    <script type="text/javascript">
        (function($){
            $(document).ready(function(){
              //$.blockUI();
              $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
            });
        }) (window.jQuery);
        
        function processCompany($companyId){
            $.ajax({
                 type: 'POST',
                 url: "<?=base_url()?>/processCompany",
                 data: {compid:$companyId},
                 success: function(result){ /*unblock*/ },
                 error: function (xhr, ajaxOptions, thrownError){ /*unblock*/ }
                
            })
            
            href="<?=base_url()?>/main/process-company?compid="+$companyId;
        }
    </script>
    
    <link rel="stylesheet" href="<?=base_url()?>css/style.css" type="text/css" />
        
        <style>
        table td{
            border: dotted 1px;
        }
        </style>
    </head>
    <body > 
        
        <div id="container" class="home">
          <div id="search-bar">
            <h1>Find Company</h1>
            <form id="search-filter" method="post">
                <label> Keyword:
                    <input type="text" value="<?php echo $keyword?>" name="keyword" />
                </label>
                <input type="submit" value="search"/>
            </form>
          </div>  
          
          <div id="content">
          <table style="border: solid 1px;">
          <thead>
            <tr>
                <th>No</th>
                <th>Company Name</th>
                <th>DUNS number</th>
                <th>Company ID</th>
                <th>Action</th>
                
            </tr>
          </thead>
          
          <?php
               $companies = $data['resultSet']['hit'];
               $idx = 0;
               foreach($companies as $comp){
                   $idx++;
                   $duns = number_format($comp['companyResults']['duns'], 0, '', '');
                   $compId = number_format($comp['companyResults']['companyId'],  0, '', '');
                   $htm = "          
                    <tr>
                        <td>{$idx}</td> 
                        <td>{$comp['companyResults']['companyName']}</td>
                        <td>$duns</td>
                        <td>$compId </td>
                        <!-- <td><a href='#' onclick='processCompany(\"$compId\")'>process</a></td> -->
                        <td><a href='".base_url() ."main/processCompany?compid=$compId' >process</a></td>
                        
                    </tr>    
                   ";
                   echo $htm;
               }
          ?>  
          </table>
          </div>
    </body>
</html>
