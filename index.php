          <?php
    if( $_GET["degree"] != null &&$_GET["address"] != null && $_GET["city"] != null && $_GET["state"] != "select" )
    {
$s = "https://maps.google.com/maps/api/geocode/xml?&address=".$_GET["address"].",".$_GET["city"].",".$_GET["state"]."&key=yourkeyhere";
       
     $xml = simplexml_load_file($s);

$forecast =  "https://api.forecast.io/forecast/yourkeyhere/"
.$xml->result->geometry->location->lat.",".$xml->result->geometry->location->lng."?units=".$_GET["degree"]."&exclude=flags"; 

        
        
  
        
        
$json = json_decode(file_get_contents($forecast));
        
        
        
$timezone =  $json->timezone;
       date_default_timezone_set($timezone) ;

          
            
      
            
       $arr_8 = array();     
        
          for( $i = 0; $i< 8; $i ++){
              

        $sunriseTime1= $json->daily->data[$i]->sunriseTime;
        
$sunriseTime =new DateTime("@$sunriseTime1");
        $sunriseTime->setTimezone(new DateTimeZone($timezone));
$sunsetTime1 = $json->daily->data[$i]->sunsetTime;
$sunsetTime = new DateTime("@$sunsetTime1");
        $sunsetTime->setTimezone(new DateTimeZone($timezone));
              array_push($arr_8,  $sunriseTime->format("h:i:A") ,  $sunsetTime->format("h:i:A") );



              
              

              
          }
                  for( $i = 0; $i< 48; $i ++){
              
              $time= $json->hourly->data[$i]->time;

        
$time =new DateTime("@$time");
        $time->setTimezone(new DateTimeZone($timezone));

              array_push($arr_8,  $time->format("h:i:A"));



              
              

              
          }
        
        
        
        
        
        
                

      $json_arr = (array)$json;
        
                      array_unshift($json_arr,$arr_8);

 $json = json_encode($json_arr); 

        header('Content-type: application/x-javascript');

        
        
 echo $json;  exit();
    }
?>
