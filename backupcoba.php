<?php

header("Content-type: application/json");
if (isset($_GET['q'])) {
	$ch = curl_init();
	//$url='http://www.google.com/search?q='.$_GET['q'];
	$url='https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q='.$_GET['q'].'&userip=192.168.0.107&rsz=8';
    $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, $url);
$data = curl_exec($ch);
curl_close($ch);
$homepage=$data;
$arr=json_decode($data);
foreach($arr as $key=>$value){
	$j=0;
	foreach($value as $key2=>$value2){
		$j++;
		if($j==2){
			continue;//remove pagination and cursor
		}
		//print_r($value2);
		foreach($value2 as $key3=>$value3){
			$arr=((array)$value3);
			echo $arr['unescapedUrl'];
			//print_r($key3);
			/*foreach($value3 as $key4=>$value4){
				//echo $key4;
			}*/
		}
	}
}
/*$arr=json_decode($data);
foreach($obj as $key=>$value){
	
}*/

//$json=json_encode($data);

	//$homepage = file_get_contents('http://www.google.com/search?q='.$_GET['q'],0);

	$res=explode("<div id=\"ires\">",$homepage);

	$link=explode("<h3 class=\"r\"><a href=\"",$res[1]);

	$i=0;
	$jsonData = array('page'=>1,'total'=>0,'rows'=>array());
	$no=0;
	foreach($link as $list)
	{$i++;
		//if($i==1 || $i==11||$i==12){
		//	continue;
		//}
		$isi=explode("<div class=\"s\">",$list);
		$content=explode("\">",$isi[0]);
		$url=str_replace("/url?q=","",$content[0]);
		
		$url=explode("&amp;sa",$url);
		$title=str_replace(array("<b>","</b>"),"",$content[1]);
		$no++;
	 	$entry = array('id' => $i,
	                'cell'=>array(
	                    'no'       => $no,
	                    'url'             => "<a onclick=\"myFunction(this)\" href=\"#\">".$url[0]."</a>",
	                    'title' => $title
	                )
	            );
	            $jsonData['rows'][] = $entry;

	}
	$jsonData['total'] = $no;
}else{
	$jsonData = array('page'=>1,'total'=>0,'rows'=>array());
	$jsonData['total'] = 0;
}
//print_r($jsonData);
//echo json_encode($jsonData);
?>