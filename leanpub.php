<?php
	$apiKey = 'XXX';

	//pull the sales data from the API
	$ch = curl_init('https://leanpub.com/buildingsecurephpapps/sales.json?api_key=' . $apiKey);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);

	$sales  = 0;
	$dollas = 0;

	if (isset($response) && !empty($response)) {

		$data = json_decode($response);

		//set sales and royalties
		$sales  = $data->num_happy_paid_purchases;
		$dollas = $data->total_book_royalties;
	}
?>

<!-- Dashboard's table widget just needs a basic HTML table and it handles it from there -->
<table>
	<thead>
		<tr>
			<th>Source</th>
			<th>Sales</th>
			<th>Cash Money</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="text-align:center;">Leanpub</td>
			<td style="text-align:center;"><?=$sales?></td>
			<td style="text-align:center;">$<?=$dollas?></td>
		</tr>
	</tbody>
</table>