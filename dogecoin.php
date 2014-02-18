<?php
	//scraping is bad kids, only do it with adult supervision

	//grab the page from crytochoincharts.com
	$ch = curl_init('http://www.cryptocoincharts.info/period-charts.php?period=1-month:&resolution=day&pair=doge-btc&market=vircurex');

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);

	//fix CSS source
	$response = str_replace('"css', '"http://www.cryptocoincharts.info/css', $response);

	//resize chart
	$response = str_replace('width: 940,', 'width: 540,', $response);
	$response = str_replace('height: 400,', 'height: 300,', $response);
	$response = str_replace('width:"840",', 'width: "400",', $response);
	$response = str_replace('height:"300"', 'height:"200"', $response);


	//hacky as hell way to hide all but the chart I want
	$newJs = '
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script>
		$(document).ready(function(){
			$("div").hide();
			$("p").hide();
			$("h2").hide();
			$("div.container").css("width", "100%");
			$("div#chart").show().parents().show();
		});
		</script>
	';

	$response = str_replace('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>', $newJs, $response);

	echo $response;
?>