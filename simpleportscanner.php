<?php


//timeout ms
$num_ports=intval($argv[2]);//num of ports to scan of remote host
$timeout = floatval($argv[3]);//timeout in seconds or ms (ie:0.001 s)

//Instance of array of port in variable $ports
$ports=array();
$host = $argv[1];$ip = gethostbyname($host);
if(!filter_var($ip, FILTER_VALIDATE_IP)) {echo $ip." is a non format ip address".PHP_EOL;return;}

$response="Results Scanning...".$host." of ".$num_ports." ports and timeout:".$timeout.PHP_EOL;
echo $response;$response="";
//code scanning ports
for ($i=0; $i<=$num_ports; $i++)

{
  
$time_start = microtime(true);
//open a tcp connection with host on port 
$connection=@fsockopen("tcp://".$ip, $i, $errno, $errstr, $timeout);
if (is_resource($connection))
{ 

    
    $status_=socket_get_status($connection); 
    if($status_){$time_end=microtime(true);$ttl_=$time_end-$time_start;}
    $serv_=getservbyport($i, 'tcp');//service of tcp protocol of associated port
 
    if($serv_!='')
    {
      $response.= ' ' .' tcp  port '. $i . ' is open with service  ' . $serv_.' and time to live seconds '.$ttl_.PHP_EOL ; 
//$connection_proto=@fsockopen($serv_."://".$ip, $i, $errno, $errstr, $timeout);
//if($connection_proto){
//$buff=@fgets($connection_proto,128);if($buff) echo $buff;}
    }
     else continue;

 
   
 fclose($connection);


}else {
$time_start1 = microtime(true);
//open a udp connection to host on ports
 $connection1 = @fsockopen("udp://".$ip,$i, $errno, $errstr, $timeout);

 
  
  if (is_resource($connection1))
  
  {   
    $serv=getservbyport($i, 'udp');//service of udp associated port
 

 $status=socket_get_status($connection1); 
    if(!$status['timed_out']){echo $status['timed_out'];$time_end1=microtime(true);$ttl1_=$time_end1-$time_start1;}
    if($serv!='')
    {
        $response.=  ' ' .' udp  port '. $i . ' is open with service  ' . $serv .' and time to live seconds '.$ttl1_.PHP_EOL ;

}
      else continue;
fclose($connection1);

}
}
   
}   

echo $response;









?>