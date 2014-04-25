<?php

header("Content-type: application/json");
if (isset($_GET['q'])) {
	$ch = curl_init();
	//$url='http://www.google.com/search?q='.$_GET['q'];
	$url='https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q='.urlencode($_GET['q']).'&userip=192.168.0.107&rsz=8';

//die($url);
    $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, $url);
$data = curl_exec($ch);
curl_close($ch);
$homepage=$data;
$arr=json_decode($data);
$jsonData = array('page'=>1,'total'=>0,'rows'=>array());
$k=0;
foreach($arr as $key=>$value){
	//$j=0;
	$k++;
	if($k>1){
		continue;//remove pagination and search result
	}
	$j=0;
	foreach((array)$value as $key2=>$value2){
		$j++;
		if($j==2){
			continue;//remove pagination and cursor
		}
		//print_r($value2);
		//echo $j;
		$i=0;
		foreach((array)$value2 as $key3=>$value3){

			$i++;
			
			$arr=((array)$value3);
			//print_r($arr);echo $i;
			$entry = array('id' => $i,
	            'cell'=>array(
	            'no'       => $i,
	            'url'             => "<a onclick=\"myFunction(this)\" href=\"#\">".$arr['unescapedUrl']."</a>",
	            'title' => $arr['titleNoFormatting']
	           )
	            );
	        $jsonData['rows'][] = $entry;
		}
	}
}
	
	$jsonData['total'] = 8;
}else{
	$jsonData = array('page'=>1,'total'=>0,'rows'=>array());
	$jsonData['total'] = 0;
}
//print_r($jsonData);
echo json_encode($jsonData);
?>