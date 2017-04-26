<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


echo "<br>";


$ch = curl_init();
$url = "https://login.bgoperator.ru/auth?login=flytrip&pwd=-_HLkz*E1FH9yvK3Rmy";


curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_NOBODY, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, realpath('cookie.php')); 
curl_setopt($ch, CURLOPT_COOKIEFILE, realpath('cookie.php')); 
$output = curl_exec($ch);

if ($output == FALSE) {

    echo "cURL Error: " . curl_error($ch);

}
curl_close($ch);
echo $output;

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";


/* 
  $urls = 'https://login.bgoperator.ru/auth';
$data = array(
    'login' => 'flytrip', 
    'pwd' => '-_HLkz*E1FH9yvK3Rmy'

	);

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($urls, false, $context);
if ($result === FALSE) { echo "123"; }

var_dump($result); 

echo "<br>";  */

 
$u = "https://login.bgoperator.ru/auth?login=flytrip&pwd=-_HLkz*E1FH9yvK3Rmy";


var_dump ($_COOKIE);



/* $headers = getallheaders();

foreach ($headers as $key => $value)

{
	echo $key.":      ";
	echo $value;
	echo "<br>";
}  */

$file_array = file("cookie.php");
echo "<br>";
echo "<br>";
echo "<br>";

echo $file_array[4][3];
echo "<br>";
echo "<br>";
echo "--------------------------";
echo "<br>";

foreach ($file_array as $key => $value)

{
	echo $key.":      ";
	echo $value;
	echo "<br>";
} 
 
 echo "<br>";
 echo "--------------------------";
  echo "--------------------------";
   echo "--------------------------";
 echo "http://export.bgoperator.ru/yandex?action=files&flt=100410000049&flt2=100510000863&xml=11";
 echo "--------------------------";
  echo "--------------------------";
   echo "--------------------------";
echo "<br>";
echo "<br>";
$useragent = $_SERVER['HTTP_USER_AGENT'];
$name = 'bg_countries.txt';
 $fp = fopen ($name, "w+");
 $ch = curl_init();
$url = "http://export.bgoperator.ru/yandex?action=countries";
//curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'C:\USR\www/cookie.php');
curl_setopt($ch, CURLOPT_HEADER, 0); // читать заголовок
curl_setopt($ch, CURLOPT_NOBODY, 0); // читать ТОЛЬКО заголовок без тела

//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Encoding: gzip",));
curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt ($ch, CURLOPT_AUTOREFERER, 0);

$result = curl_exec($ch);  
curl_close($ch);


/* $name_resorts = 'bg_resorts.txt';
 $fp_resorts = fopen ($name_resorts, "w+");
 $ch = curl_init();
$url = "http://export.bgoperator.ru/yandex?action=resorts";
//curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'C:\USR\www/cookie.php');
curl_setopt($ch, CURLOPT_HEADER, 0); // читать заголовок
curl_setopt($ch, CURLOPT_NOBODY, 0); // читать ТОЛЬКО заголовок без тела

//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Encoding: gzip",));
curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
curl_setopt($ch, CURLOPT_FILE, $fp_resorts);
curl_setopt ($ch, CURLOPT_AUTOREFERER, 0);

$result = curl_exec($ch);  
curl_close($ch);
 */


 /*
$name_hotels = 'bg_hotels.txt';
 $fp_hotels = fopen ($name_hotels, "w+");
 $ch = curl_init();
$url = "http://export.bgoperator.ru/yandex?action=hotels";
//curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'C:\USR\www/cookie.php');
curl_setopt($ch, CURLOPT_HEADER, 0); // читать заголовок
curl_setopt($ch, CURLOPT_NOBODY, 0); // читать ТОЛЬКО заголовок без тела

//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Encoding: gzip",));
curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
curl_setopt($ch, CURLOPT_FILE, $fp_hotels);
curl_setopt ($ch, CURLOPT_AUTOREFERER, 0);

$result = curl_exec($ch);  
curl_close($ch);

*/





echo "<br>";
echo "<br>";
echo "<br>";



//header('Accept-Encoding:gzip');
//$_SERVER["HTTP_ACCEPT_ENCODING"]="gzip";
//var_dump ($_SERVER["HTTP_ACCEPT_ENCODING"]);



//ob_start("ob_gzhandler");






$headers = getallheaders();

foreach ($headers as $key => $value)

{
	echo $key.":      ";
	echo $value;
	echo "<br>";
} 

phpinfo();

?>

</html>