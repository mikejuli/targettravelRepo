<?php



function bg_find_tour ($city,$land,$nightmin,$nightmax,$minprice,$maxprice,$data1,$data2,$town, $hotels){


if(empty($minprice))
{

	$minprice  = 1000;  // дефолтное значение
}

if(empty($maxprice)){
$maxprice = 500000; //дефолтное значение
}


if ($minprice > $maxprice || $minprice<0 ||  $maxprice<0 ){

	$minprice  = 1000;
	$maxprice = 500000;
}



if ($maxprice>1000 && $minprice>0 && $maxprice > $minprice){

	$maxprice_bg = $maxprice;
	$minprice_bg = $minprice;
}else{
	$minprice_bg  = 1000;
	$maxprice_bg = 500000;	
}



// с количеством ночей сделать тоже самое!


// дописать проверку на проверку если заходит разница в днях больше чем 7.  между $data1 и $data2  //проверка на count массива
if ($data1){
$year = substr($data1, 0, -6);
$month = substr($data1, 5, -3);
$day = substr($data1, 8, 2);
$data1 = $day.".".$month.".".$year;

for ($i=0; $i<5 ; $i++) { 
$date_cange1 = date('d.m.Y', mktime(0, 0, 0, $month, $day + $i, $year));
$arr_date[] = $date_cange1; 
}
}



if (!$data1){	
for ($i=0; $i<5; $i++) { 
$date_cange = date('d.m.Y', mktime(0, 0, 0, date('m'), date('d') + $i, date('Y')));
$arr_date[] = $date_cange; 	

}

};


//var_dump($arr_date);


//если нету $data1  
//то присваеваем $data1 = сегоднешнее число формата ДД.ММ.ГГГГ  и делаем массив array_date = сегоднешнее число по $data1+4 дней
//если есть внутри $data1 значение, то мы делаем массив array_date = $data1 по $data1+4 дней
//если есть $data2 то делаем массив array_data = $data1, ... , $data2 .
// ПРОВЕРКА НА КОЛИЧЕСТВО элементов массива array_data не больше 15 !!! если больше 15 то превращаем в первые 15 элементов.




$file_resorts = file_get_contents("bg_resorts.txt");
$json_resorts = $file_resorts;
$cart_resorts = json_decode( $json_resorts );
$arr_resorts = $cart_resorts;


//делаем строку из городов прилёта
$string_town ="";
$arr_town = explode(",", $town);
$coun_element = count($arr_town);
$u =0;

foreach ($arr_town as $key){	
	$j=0;
foreach($arr_resorts as $key){
$l = $arr_resorts[$j]->title_ru;
if ($l == $arr_town[$u])
{
	$idTown = $arr_resorts[$j]->id;
break;
}
$j++;
}
	$u++;
	@$string_town .= "&f1=".$idTown ;
	}

//echo $string_town;

//делаем строку из отелей для отдыха 
$string_hotels = "";
$arr_hotels = explode(",", $hotels);
$coun_element = count($arr_hotels);
$ut =0;
foreach ($arr_hotels as $key){	
	$js = 0;
$xmlss = simplexml_load_file ('bg_hotels.txt');

foreach ($xmlss->hotel as $key){
if($arr_hotels[$ut] == $key["name"]){
	$idhotels = $key["key"];
	//echo $idhotels;
break;
}
$js++;
}
	$ut++;
	@$string_hotels .= "&F4=".$idhotels ;
	}
//echo $string_hotels;



$full_string = $string_town.$string_hotels;

/* echo "<br>";
echo "Показаны туры по запросу";
echo "<br>";
echo "Страна:  ".$land;
echo "<br>";
echo "Курорт:  ".$town;
echo "<br>";
echo "Отель:  ".$hotels; */
//$city = $_POST['city'];
//$land = $_POST['land'];

//$city = "Москва";
//$land = "Индия";


//находим из справочников id страны прилёта

$file = file_get_contents("bg_countries.txt");
$json = $file;
$cart = json_decode( $json );
$arr = $cart;

$i = 0;
foreach($arr as $key){
$l = $arr[$i]->title_ru;
if ($l == $land)
{
	$idCountry = $arr[$i]->id;
break;
}
$i++;
}
//echo $idCountry;

/////////////////////////////////////////////////////


//находим в справочнике id города курорта

$i = 0;
foreach($arr_resorts as $key){
$l = $arr_resorts[$i]->title_ru;
if ($l == $city)
{
	$idCity = $arr_resorts[$i]->id;
break;
}
$i++;
}





//echo $idCity;

/////////////////////////////////////////////////////


$search_url = 'http://export.bgoperator.ru/yandex?action=files&flt='.$idCountry.'&flt2='.$idCity.'&xml=11';

//echo $search_url;


$name_bg_price = 'bg_price.txt';
 $fp_bg_price = fopen ($name_bg_price, "w+");
 $ch = curl_init();
$url = $search_url;
//curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'C:\USR\www/cookie.php');
curl_setopt($ch, CURLOPT_HEADER, 0); // читать заголовок
curl_setopt($ch, CURLOPT_NOBODY, 0); // читать ТОЛЬКО заголовок без тела

//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Encoding: gzip",));
curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
curl_setopt($ch, CURLOPT_FILE, $fp_bg_price);
curl_setopt ($ch, CURLOPT_AUTOREFERER, 0);

$result = curl_exec($ch);  
curl_close($ch);

////////////////////////////////////////////////////////////////////////



$file_price = file_get_contents("bg_price.txt");
if (!$file_price){echo "Ничего не найдено! Чего-то вапще нет такого направления!!"; die;}

$json_price= $file_price;
$cart_price = json_decode( $json_price );
$arr_price = $cart_price->entries;




for ($i=0; $i < 3; $i++) { 
	
$j = 0;
foreach ($arr_price as $key){


if($land == "Италия"){

$type_tour1 = (string)"ТУРЫ В РИМИНИ АК Россия <b>АК Россия (группа Аэрофлот)</b>";
$type_tour2 = (string)"Италия Классика (прилет в Римини) <b>АК Россия (группа Аэрофлот)</b>";
$type_tour3 = (string)"Экскурсионный тур + отдых на Адриатической Ривьере <b>АК Россия (группа Аэрофлот)</b>";
$type_tour4 = (string)"Новая Италия (прилет в Римини) <b>АК Россия (группа Аэрофлот)</b>";
$type_tour5 = (string)"Зимняя Италия (прилет в Римини) <b>АК Россия (группа Аэрофлот)</b>";
$type_tour6 = (string)"Рим в кармане (прилет в Римини) <b>АК Россия (группа Аэрофлот)</b>";
$type_tour7 = (string)"Горящая Италия (прилет в Римини) <b>АК Россия (группа Аэрофлот)</b>";

if (($arr_date[$i]==$arr_price[$j]->date)  && 
	(($arr_price[$j]->route == $type_tour1)  ||
	($arr_price[$j]->route == $type_tour2)  ||
	($arr_price[$j]->route == $type_tour3)  ||
	($arr_price[$j]->route == $type_tour4)  ||
	($arr_price[$j]->route == $type_tour5)  || 
	($arr_price[$j]->route == $type_tour6)  || 
	($arr_price[$j]->route == $type_tour7)))
{
	$arr_url[]= $arr_price[$j]->url;
}
$j++;
}







if($land == "Греция"){

$type_tour1 = (string)"Кос <b>АК Россия (группа Аэрофлот)</b>";
$type_tour2 = (string)"Родос <b>АК Россия (группа Аэрофлот)</b>";
$type_tour3 = (string)"Крит <b>АК Россия (группа Аэрофлот)</b>";
$type_tour4 = (string)"Корфу <b>АК Россия (группа Аэрофлот)</b>";
$type_tour5 = (string)"КРИТ + САНТОРИНИ (ПЕРЕЛЁТ НА ПХУКЕТ) <b>АК Россия (группа Аэрофлот)</b>";


if (($arr_date[$i]==$arr_price[$j]->date)  && 
	(($arr_price[$j]->route == $type_tour1)  ||
	($arr_price[$j]->route == $type_tour2)  ||
	($arr_price[$j]->route == $type_tour3)  ||
	($arr_price[$j]->route == $type_tour4)  ||
	($arr_price[$j]->route == $type_tour5)))
{
	$arr_url[]= $arr_price[$j]->url;
}
$j++;
}







if($land == "Черногория"){
$type_tour1 = (string)"Туры в Черногорию <b>АК Россия (группа Аэрофлот)</b>";

if (($arr_date[$i]==$arr_price[$j]->date)  && 
	(($arr_price[$j]->route == $type_tour1) ))
{
	$arr_url[]= $arr_price[$j]->url;
}
$j++;
}


if($land == "Абхазия"){
$type_tour1 = (string)"Отдых в Абхазии <b>АК Россия (группа Аэрофлот)/ Red Wings</b>";

if (($arr_date[$i]==$arr_price[$j]->date)  && 
	(($arr_price[$j]->route == $type_tour1) ))
{
	$arr_url[]= $arr_price[$j]->url;
}
$j++;
}





if($land == "Объединенные Арабские Эмираты"){
$type_tour1 = (string)"Туры в ОАЭ <b>АК Россия (группа Аэрофлот)</b>";

if (($arr_date[$i]==$arr_price[$j]->date)  && 
	(($arr_price[$j]->route == $type_tour1) ))
{
	$arr_url[]= $arr_price[$j]->url;
}
$j++;
}

if($land == "Турция"){
$type_tour1 = (string)"Туры в Анталию <b>АК Россия (группа Аэрофлот) - Регулярный рейс</b>";

if (($arr_date[$i]==$arr_price[$j]->date)  && 
	(($arr_price[$j]->route == $type_tour1) ))
{
	$arr_url[]= $arr_price[$j]->url;
}
$j++;
}


if($land == "Чехия"){

$type_tour1 = (string)"Туры в Прагу (а/п Прага) <b>АК Россия (группа Аэрофлот)</b>";
$type_tour2 = (string)"Лечебные курорты <b>АК Россия (группа Аэрофлот)</b>";


if (($arr_date[$i]==$arr_price[$j]->date)  && 
	(($arr_price[$j]->route == $type_tour1)  ||
	($arr_price[$j]->route == $type_tour2)))
{
	$arr_url[]= $arr_price[$j]->url;

}
$j++;
}






if($land == "Индия"){
$type_tour1 = (string)"Гоа (Прямой перелет) <b>АК Россия (группа Аэрофлот) - Регулярный рейс</b>";

if (($arr_date[$i]==$arr_price[$j]->date)  && 
	(($arr_price[$j]->route == $type_tour1) ))
{
	$arr_url[]= $arr_price[$j]->url;
}
$j++;
}





if($land == "Таиланд"){

$type_tour1 = (string)"ТУРЫ В ПАТТАЙЮ <b>АК Россия (группа Аэрофлот) - Регулярный рейс</b>";
$type_tour2 = (string)"Туры на Пхукет <b>АК Россия (группа Аэрофлот) - Регулярный рейс</b>";
$type_tour3 = (string)"ТУРЫ НА САМЕТ <b>АК Россия (группа Аэрофлот) - Регулярный рейс</b>";
$type_tour4 = (string)"ТУРЫ ПХИ ПХИ - ПХУКЕТ <b>АК Россия (группа Аэрофлот) - Регулярный рейс</b>";
$type_tour5 = (string)"ТУРЫ НА КРАБИ (ПЕРЕЛЁТ НА ПХУКЕТ) <b>АК Россия (группа Аэрофлот) - Регулярный рейс</b>";
$type_tour6 = (string)"ТУРЫ ПХИ ПХИ - ПХУКЕТ <b>АК Россия (группа Аэрофлот) - Регулярный рейс</b>";
$type_tour7 = (string)"Туры Бангкок - Районг <b>АК Россия (группа Аэрофлот) - Регулярный рейс</b>";

if (($arr_date[$i]==$arr_price[$j]->date)  && 
	(($arr_price[$j]->route == $type_tour1)  ||
	($arr_price[$j]->route == $type_tour2)  ||
	($arr_price[$j]->route == $type_tour3)  ||
	($arr_price[$j]->route == $type_tour4)  ||
	($arr_price[$j]->route == $type_tour5)  || 
	($arr_price[$j]->route == $type_tour6)  || 
	($arr_price[$j]->route == $type_tour7)))
{
	$arr_url[]= $arr_price[$j]->url;
}
$j++;
}




if($land == "Россия"){

$type_tour1 = (string)"Крым <b>Уральские авиалинии</b>";
$type_tour2 = (string)"Крым <b>RED WINGS</b>";
$type_tour3 = (string)"Геленджик <b>ЮВТ-Аэро</b>";
$type_tour4 = (string)"Сочи <b>UTair</b>";
$type_tour5 = (string)"Сочи <b>Вим Авиа</b>";
$type_tour6 = (string)"Сочи <b>АК Россия (группа Аэрофлот)/ Red Wings</b>";
$type_tour7 = (string)"Сочи <b>RED WINGS</b>";


if (($arr_date[$i]==$arr_price[$j]->date)  && 
	(($arr_price[$j]->route == $type_tour1)  ||
	($arr_price[$j]->route == $type_tour2)  ||
	($arr_price[$j]->route == $type_tour3)  ||
	($arr_price[$j]->route == $type_tour4)  ||
	($arr_price[$j]->route == $type_tour5)  || 
	($arr_price[$j]->route == $type_tour6)  || 
	($arr_price[$j]->route == $type_tour7)))
{
	$arr_url[]= $arr_price[$j]->url;

}
$j++;
}





if($land == "Испания"){

$type_tour1 = (string)"Туры в Барселону <b>АК Россия (группа Аэрофлот)</b>";
$type_tour2 = (string)"Отдых на побережье Коста Брава <b>АК Россия (группа Аэрофлот)</b>";
$type_tour3 = (string)"Отдых на побережье Коста Дорада <b>АК Россия (группа Аэрофлот)</b>";
$type_tour4 = (string)"Отдых на побережье Коста Брава <b>Аэрофлот</b>";



if (($arr_date[$i]==$arr_price[$j]->date)  && 
	(($arr_price[$j]->route == $type_tour1)  ||
	  ($arr_price[$j]->route == $type_tour2)  ||
		($arr_price[$j]->route == $type_tour3)  || 
		($arr_price[$j]->route == $type_tour4)))
{
	$arr_url[]= $arr_price[$j]->url;
}
$j++;
}




if($land != "Испания" && $land != "Россия" && $land != "Таиланд"&& $land != "Индия"&& $land != "Чехия"&& $land != "Турция"
	&& $land != "Объединенные Арабские Эмираты"&& $land != "Италия"&& $land != "Греция"&& $land != "Черногория"&& $land != "Абхазия"
){

if ($arr_date[$i]==$arr_price[$j]->date)  
{
	$arr_url[]= $arr_price[$j]->url;
}
$j++;
}




}




}

//ЕСЛИ arr_rl ничего нету, то с этой точки дальше нет кода тут выход со словами, что туров нету. !!!ДОПИСАТЬ!!!!

//var_dump($arr_url);





  // тут мы ищем по дате в файле bg_price.txt нужные даты например:
// у нас есть дефолтный массив из дат вылета [02.03.2017,03.03.2017,04.03.2017,05.03.2017,06.03.2017] со текущей даты +3 дня
// или с выбора даты +7 дней .
//  Оттуда по каждой позиции собираем url . Получаем, ну примерно 14-20 url (запишем их в массив ) потом из полученного array_url вызываем и слепляем 
//  в один файл price_from_URL.txt все туры. В каждом в среднем по 500 елементов. В итоге получим 500*(8-20) = 4000 - 10 000 елементов в файле price_from_Url.txt
//  


// сортируем price_from_Url.txt по цене . 
// выбираем первые 40 позиций файла 
// и выдаём их (для начала принт)










//////////////////////////////////////////////////////////////

$myFile = "bg_temp/inside.txt";
$fh = fopen($myFile, 'w');
fclose($fh);


$random_name_file = 'bg_temp/inside'.date("d_m_Y_h_i_s").rand(1, 9999).'.txt' ;

$fp = fopen ($random_name_file , 'w');

$i =0;
foreach ($arr_url as $key) {


$inside_url = $arr_url[$i].$full_string."&f7=".$nightmin;

//echo $search_url;







 $fp_bg_inside = fopen ($random_name_file, "a+");
 $ch = curl_init();
$url = $inside_url;
//echo $url;
//curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'C:\USR\www/cookie.php');
curl_setopt($ch, CURLOPT_HEADER, 0); // читать заголовок
curl_setopt($ch, CURLOPT_NOBODY, 0); // читать ТОЛЬКО заголовок без тела

//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //разобраться с кешем
//curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);

//curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Encoding: gzip",));
curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
curl_setopt($ch, CURLOPT_FILE, $fp_bg_inside);
curl_setopt ($ch, CURLOPT_AUTOREFERER, 0);

$result = curl_exec($ch);  
curl_close($ch);

$i++;
}



//форматирование в файле inside.txt

$file = fopen($random_name_file, 'r');
$text = fread($file, filesize($random_name_file));
fclose($file);

$file = fopen($random_name_file, 'w');
$text = str_replace('{"href0" : "https', ',{"href0" : "https', $text);
$text = substr_replace($text, '[', 0, 1);
$text = substr_replace($text, ']', strlen($text), 0);
fwrite($file, $text);
fclose($file);



$file_inside = file_get_contents($random_name_file);   
$json_inside= $file_inside;
$cart_inside = json_decode( $json_inside );




$i = 0;
foreach ($cart_inside as $key ) {

foreach ($cart_inside[$i]->entries as $ke) {
	# code...

$clean_arr[] = $ke;
}
$i++;
}



//БЛОК ИСКЛЮЧЕНИЙ - ЕСЛИ ЗНАЧЕНИЕ ПРАЙС ПУСТОЕ ИЛИ ЕГО НЕТ
// ТО МЫ СНОСИМ ВЕСЬ ЕЛЕМЕНТ МАССИВА
if($land != "Россия" && $land != "Абхазия"){
	
foreach($clean_arr as $key => $value){
    if (@!$value->prices[0]->RUR)
    	{
    		unset($clean_arr[$key]);
    	}
	}}

/*if ($land == "Россия"){

foreach($clean_arr as $key => $value){
    if (@!$value->amount)
    	{
    		unset($clean_arr[$key]);

    	}
	}}
*/

//var_dump($clean_arr);
$data_wait=array();
//Генерируем "определяющий" массив

if($land != "Россия" && $land != "Абхазия"){

foreach($clean_arr as $key=>$arr){
    $data_wait[$key] = $arr->prices[0]->RUR;
	}

 }else{

foreach($clean_arr as $key=>$arr){
    $data_wait[$key] = $arr->prices[0]->amount;
	}


 }



    $data_tmp=$clean_arr;
    array_multisort($data_wait, SORT_NUMERIC, $data_tmp);


//блок отбора по минимальной максимальной цене

$i=0;
$data_t = array();

if ($land != "Россия" && $land != "Абхазия"){
foreach ($data_tmp as $key => $value) {
	if ($minprice_bg<$data_tmp[$key]->prices[0]->RUR){

		if ($maxprice_bg>$data_tmp[$key]->prices[0]->RUR){
		$data_t[$i] = $data_tmp[$key];
		$i++;
		}
}
}}


if ($land == "Россия" || $land == "Абхазия"){
foreach ($data_tmp as $key => $value) {
	if ($minprice_bg<$data_tmp[$key]->prices[0]->amount){

		if ($maxprice_bg>$data_tmp[$key]->prices[0]->amount){
		$data_t[$i] = $data_tmp[$key];
		$i++;
		}
}
}}


//сделать по цене : узнать с какого элемента начинается наша мин цена и присвоить $i значение элемента
$str = null;
$i = 0 ;
foreach ($data_t as $key) {
	/* echo $data_t[$i]->tour_date."    .    ";
	echo $data_t[$i]->duration."   .      ";

$nowHotel = $data_t[$i]->id_hotel;


$xmls = simplexml_load_file ('bg_hotels.txt');
foreach ($xmls->hotel as $key){
if($data_t[$i]->id_hotel == $key["key"]){
	$nameHotel =  $key["name"];
	echo $nameHotel;
break;
}
}


	//echo $data_tmp[$i]->id_hotel."    ";
echo '<font size="2" color="red" face="Arial">';
	echo "      ".$data_t[$i]->prices[0]->RUR;
echo '</font>';

	echo "      ".$data_t[$i]->town;
echo "      ".$data_t[$i]->aircompany;

	echo "<br>"; */
	

if ($land != "Россия" && $land != "Абхазия"){

		$str .= '{"price":'.$data_t[$i]->prices[0]->RUR.',"tour_id":'.$i.',"duration":'.$data_t[$i]->duration.',"operator":"BiblioGlobus"},';
		}
if ($land == "Россия" || $land == "Абхазия"){

		$str .= '{"price":'.$data_t[$i]->prices[0]->amount.',"tour_id":'.$i.',"duration":'.$data_t[$i]->duration.',"operator":"BiblioGlobus"},';
		}
		
	
	
	$i++;
	if ($i>40){break;}
}
//$rest = substr($str, 0, -1);
		
	echo $str;
 
/*
$ij = 0;

foreach ($arr_inside as $key){
	
echo "<br>";
echo "Дата вылета:   ";
echo $arr_inside[$ij]->tour_date;
echo "<br>";
echo "Авиакомпания:   ";
echo $arr_inside[$ij]->aircompany;
echo "<br>";
echo "Курорт:   ";
echo $arr_inside[$ij]->town;
echo "<br>";
echo "Отель:   ";
$nowHotel = $arr_inside[$i]->id_hotel;
$xmls = simplexml_load_file ('bg_hotels.txt');
foreach ($xmls->hotel as $key){
if($arr_inside[$ij]->id_hotel == $key["key"]){
	$nameHotel =  $key["name"];
	echo $nameHotel;
break;
}
}

echo "<br>";

echo "<img src='библио1.png'> ";

echo "<br>";
echo "Тип комнаты:   ";
echo $arr_inside[$i]->room;
echo "<br>";
echo "Продолжительность:   ";
echo $arr_inside[$i]->duration;
echo "<br>";
echo "Цена:   ";
echo '<p><font size="3" color="red" face="Arial">';
echo $arr_inside[$i]->prices[0]->RUR . "   рублей";
echo '</font>';
echo "<br>";
echo "<br>";
$ij++;

if ($ij > 40) {break;}


echo "<br>";
}
//////////////////////////////////////////////////////////////

*/
 




}

bg_find_tour("Москва","Италия",3,14,5000,200000,'2017-05-02',false,2,'','');

?>