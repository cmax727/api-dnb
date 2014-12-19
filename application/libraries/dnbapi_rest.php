<?php
/**
* http://dnbdirect-api.dnb.com/DnBAPI-12/dnbAPI/dnbAPI.wsdl
* http://dnbdirect-api.dnb.com/DnBAPI-12/rest/application.wadl
*/
class dnbapi_rest{
    

    var $COMPANY_ID = 13193000000000;
    var $OFFICIAL_ID = 1240058000000000;
    var $NOTE_TEXT = 'Sample Note Text';
    var $NOTE_DATE = '2010-05-21';
    var $NOTE_ID = 48135481;
    //var $BASE_URL = "http://dnbdirect-sandbox.dnb.com/DnBAPI-12";
    var $BASE_URL = "http://dnbdirect-api.dnb.com/DnBAPI-12";
    
    var $REST_ENDPOINT = "";//$BASE_URL . "/rest/";
    var $WSDL_ENDPOINT = "";//$BASE_URL . "/dnbAPI/dnbAPI.wsdl";
    var $username = 'api7344';
    var $password = 'welcome';

    var $headers = array();
    var $api_key = "y435fs2zq7tg9wg85duf234v";
    
    public function __construct(){
        $this->REST_ENDPOINT = $this->BASE_URL . "/rest/";
        $this->WSDL_ENDPOINT = $this->BASE_URL . "/dnbAPI/dnbAPI.wsdl";
    }            
    
    public function toJson($jsonStr){
      $cc = preg_replace('/("\w+"):([\d\.]+)/', '\\1:"\\2"', $jsonStr);
      $jsonObj = json_decode($cc, true); 
      return $jsonObj;
    }
    /**
    * find company by name
/search/company/{keyword}?
    duns_from={duns_from}
    &duns_to={duns_to}
    &hit_offset={hit_offset}
    &max_records={max_records}
    &sort_direction={sort_direction}
    &search_by={search_by}
    &order_by={order_by}
    &return_search_navigation={return_search_navigation} 
    * 
    * @param mixed $key
    * @param mixed $maxLimit
    */
    function FindCompanyByKeywordSimple($key, $maxLimit=10) {
        $request = $this->REST_ENDPOINT ."search/company/$key?max_records=$maxLimit";
        return $this->do_get($request);
    }
    /**
    * /company/{unique_id}/competitors?top_competitor={top_competitor} 
    * 
    */
    function FindCompanyCompetitors($unique_id, $top_competitor=false) {
        $request = $this->REST_ENDPOINT ."company/$unique_id/competitors?top_competitor=$top_competitor";
        return $this->do_get($request);
                        
    }
    /**
    * put your comment there...
    * 
    */
    function GetCompanyDetailSimpleREST($unique_id) {
        $request = $this->REST_ENDPOINT ."company/$unique_id?view=simple";
        return $this->do_get($request);
    }
    /**
    * put your comment there...
    * 
    */
    function GetCompanyDetail($unique_id) {
        $request = $this->REST_ENDPOINT ."company/$unique_id?view=full";
        return $this->do_get($request);
                
    }
    //Call the chosen web service
    function GetFamilyTree(){
        $request = $this->REST_ENDPOINT . 'company/familytree/13193000000000';
        $content = '{"city": ["Round Rock"], "state" : ["TX"], "country": [ "United States" ], "locationType": ["HEADQUARTERS"] }';
        
        return $this->do_post($request, $content);
        
    }
    

    function GetPersonDetail() {
                $request = $this->REST_ENDPOINT ."person/13193000000000/1240089000000000?connectMail=false&convertCurrencyTo=USD&view=full";
                $response = file_get_contents($request,false, $context);
                return $this->do_dump($response);
                
    }
    
    
    function FindCompanyByKeyword($key, $maxLimit=10){
                $request = $this->REST_ENDPOINT ."search/company/$key?max_records=$maxLimit";
                $content = '{"locationTypeSearchNavigation":{"locationTypeSearchNavigationValue":["2"]}}';
                return $this->do_post($request, $content);
                
    }
    function AdvancedCompanySearch() {
                $request = $this->REST_ENDPOINT . "search/company/advanced?sort_direction=ascending&order_by=company_name&max_records=10";
                $content = '{"specialtyCriteria":{"companyKeyword":"Dell"}}';
                return $this->do_post($request, $content);
                
    }
    function AdvancedPersonSearch(){
                $request = $this->REST_ENDPOINT . "search/person/advanced?order_by=company_name&max_records=10";
                $content = '{"specialtyCriteria":{"companyKeyword":"Dell"}}';
                return $this->do_post($request, $content);
                
            } 
    
    
    
    function do_get($request) {
        $username = $this->username;
        $password = $this->password;
        $opts = array(
              'http'=>array(
                'method'=>"GET",
                'header'=>"username: " . $username . "\r\n" .
                          "password: " . $password . "\r\n" .
                          "API-KEY: $this->api_key\r\n"
              )
            );
        $context = stream_context_create($opts);

        $response = file_get_contents($request,false, $context);
        return $response;
        //do_dump($response);
    }

    function do_post($request, $content) {
        print($request);
        $username = $_POST['username'];
        $password = $_POST['password'];
        $opts = array(
            'http' => array(
              'method' => "POST",
              'ignore_errors' => true,
              'header' => "Accept: application/json\r\n" .
                          "Content-type: application/json\r\n" .
                          "username: " . $username . "\r\n" .
                          "password: " . $password. "\r\n" .
                          "API-KEY: $this->api_key\r\n",
              'content' => $content
            )
        );
        $context  = stream_context_create($opts);
        $fp = fopen($request, 'rb', false, $context);
        if (!$fp) {
            $response = "There was a problem calling the service.";
        } else {
            $response = stream_get_contents($fp);
        }
        //do_dump($response);
        return $response;
       /* 
        $ch = curl_init($request);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array("username: $username", "password: $password",
             "Content-type: application/json",
             "API-KEY: $api_key",
             "Accept: application/json"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , TRUE);
        curl_setopt($ch, CURLOPT_POST , TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        
        
        $data = curl_exec($ch); 
        
        @curl_close($ch ); */
    }

    /////////////////
    // Much thanks to the group on php.net
    // Specific code taken from http://us3.php.net/manual/en/function.var-dump.php#80288
    ////////////////

    ////////////////////////////////////////////////////////
    // Function:         dump
    // Inspired from:     PHP.net Contributions
    // Description: Helps with php debugging

    function dump(&$var, $info = FALSE)
    {
        $scope = false;
        $prefix = 'unique';
        $suffix = 'value';

        if($scope) $vals = $scope;
        else $vals = $GLOBALS;

        $old = $var;
        $var = $new = $prefix.rand().$suffix; $vname = FALSE;
        foreach($vals as $key => $val) if($val === $new) $vname = $key;
        $var = $old;

        echo "<pre style='margin: 0px 0px 10px 0px; display: block; background: white; color: black; font-family: Verdana; border: 1px solid #cccccc; padding: 5px; font-size: 10px; line-height: 13px;'>";
        if($info != FALSE) echo "<b style='color: red;'>$info:</b><br>";
        do_dump($var, '$'.$vname);
        echo "</pre>";
    }

    ////////////////////////////////////////////////////////
    // Function:         do_dump
    // Inspired from:     PHP.net Contributions
    // Description: Better GI than print_r or var_dump

    function do_dump(&$var, $var_name = NULL, $indent = NULL, $reference = NULL)
    {
        $do_dump_indent = "<span style='color:#eeeeee;'>|</span> &nbsp;&nbsp; ";
        $reference = $reference.$var_name;
        $keyvar = 'the_do_dump_recursion_protection_scheme'; $keyname = 'referenced_object_name';

        if (is_array($var) && isset($var[$keyvar]))
        {
            $real_var = &$var[$keyvar];
            $real_name = &$var[$keyname];
            $type = ucfirst(gettype($real_var));
            echo "$indent$var_name <span style='color:#a2a2a2'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
        }
        else
        {
            $var = array($keyvar => $var, $keyname => $reference);
            $avar = &$var[$keyvar];

            $type = ucfirst(gettype($avar));
            if($type == "String") $type_color = "<span style='color:green'>";
            elseif($type == "Integer") $type_color = "<span style='color:red'>";
            elseif($type == "Double"){ $type_color = "<span style='color:#0099c5'>"; $type = "Float"; }
            elseif($type == "Boolean") $type_color = "<span style='color:#92008d'>";
            elseif($type == "NULL") $type_color = "<span style='color:black'>";

            if(is_array($avar))
            {
                $count = count($avar);
                echo "$indent" . ($var_name ? "$var_name => ":"") . "<span style='color:#a2a2a2'>$type ($count)</span><br>$indent(<br>";
                $keys = array_keys($avar);
                foreach($keys as $name)
                {
                    $value = &$avar[$name];
                    do_dump($value, "['$name']", $indent.$do_dump_indent, $reference);
                }
                echo "$indent)<br>";
            }
            elseif(is_object($avar))
            {
                echo "$indent$var_name <span style='color:#a2a2a2'>$type</span><br>$indent(<br>";
                foreach($avar as $name=>$value) do_dump($value, "$name", $indent.$do_dump_indent, $reference);
                echo "$indent)<br>";
            }
            elseif(is_int($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
            elseif(is_string($avar)){
                 if($var_name != 'report') {
                      echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color\"$avar\"</span><br>";
                 } else {
                       $ourFileName = "/MarketAnalysisReport.PDF";
                       echo "PDF File Location:" .$ourFileName;
                       $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
                       fwrite( $ourFileHandle, $avar);
                       fclose($ourFileHandle);
                 }
             }
            elseif(is_float($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color$avar</span><br>";
            elseif(is_bool($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $type_color".($avar == 1 ? "TRUE":"FALSE")."</span><br>";
            elseif(is_null($avar)) echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> {$type_color}NULL</span><br>";
            else echo "$indent$var_name = <span style='color:#a2a2a2'>$type(".strlen($avar).")</span> $avar<br>";

            $var = $var[$keyvar];
        }
    }
}
?>
