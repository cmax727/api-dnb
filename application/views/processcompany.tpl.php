<?php



    if (isset($data["app_data"]) && $firstTime == 1)
    {
    // show post.php with ID = $job_id
    // break
      redirect(base_url() . 'main/readmore/' . $job_id);
    }
    
    function print_tree($treeData){
        
        $htm = "<div class='comp-item'>"  
        . "<div class='com-detail'>
            <span class='comp-name'> Company Name: </span>{$treeData['companyName']} <br />
            <span class='comp-duns'> DUNS Number : </span>{$treeData['duns']} <br />
            <span class='comp-id'> Company Id: </span>{$treeData['companyId']} </span> <br />
            </div>
        ";
        
        $treeHtml = "";
        foreach ($treeData['competitors'] as $tree){
            $treeHtml .= print_tree($tree);
        }   
        if ( isset($treeData['competitors'])){
            $htm .= "<div class='com-competitors-wrapper'>
                <span class='competitors-label'>Competitors:</span><br />"
                . "<div class='com-competitors'>" . $treeHtml ."</div>"
                ."</div>";
        }
            $htm .= "</div>";
        return $htm;
    }
    
    $render = print_tree($data);
    
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
            
            $(document).ready(function() {
                $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
                
                //$('.com-competitors').hide();
                $('.competitors-label').click(
                    function() {
                        var openMe = $(this).next().next();
                        
                        if (openMe.is(':visible')) {
                            openMe.slideUp('normal');  
                        } else {
                            //mySiblings.slideUp('normal');  
                            openMe.slideDown('normal');
                        }
                      }
                );
            })

        }) (window.jQuery);
        
        function processCompany($companyId){
            
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
        <div id="header">
            <ul> <li><h1><a href="<?=base_url()?>">Home</a></h1></li>
        </ul>
        </div>
        <div id="container">
          <div id="comp-tree">
             <?= $render?>
          </div>
    </body>
</html>
