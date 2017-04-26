<?php
function pegasCounrty ($string_country){

$wsdl_path = "https://api-ext-test.pegasys.pegast.com/StaticReferenceData.svc?singleWsdl";

$soapClient = new SoapClient($wsdl_path, array('trace' => 1));

$headers = array();
$headers[] = new SoapHeader('http://pegast.com/pegasys/api', 'PreferredLanguageCode', 'ru');
$headers[] = new SoapHeader('http://pegast.com/pegasys/api', 'ApiUserKey', "9TlZqTw1+D9MbeDai7SZjQ==");
$soapClient->__setSoapHeaders($headers);



$params = array (
					'Parameters' => array(
						'DataTypes' => array(
					'StaticReferenceDataType' => 'Countries'
					)
		)
	);


$response = $soapClient->GetStaticReferenceData($params);


//$str_value = serialize($response);
//$test = file_put_contents("pegas_list_country.txt", $str_value); // Çàïèñü â ôàéë



$file = file_get_contents("pegas_list_country.txt");

$value = unserialize($file);


//var_dump ($value);


//echo $value->Result->Countries->Country[1]->Name;

$arr   =  $value->Result->Countries->Country;
$return = NULL;
 $i=0;
	foreach ($arr as $key){
		
		
if ($string_country == $key->Name)

		{
$return = $key->Id;
break;
		}

		$i++;
	}
		return $return;
		
	}

//echo pegasCounrty ("Кипр");

?>