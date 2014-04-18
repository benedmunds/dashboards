<?php
	$apiKey = 'XXX';

	date_default_timezone_set('America/Los_Angeles');

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
		$unpaid = $data->unpaid_royalties;
		$next   = $data->royalties_due_on_first_of_next_month;
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
			<td style="text-align:center;">Total</td>
			<td style="text-align:center;"><?=$sales?></td>
			<td style="text-align:center;">$<?=$dollas?></td>
		</tr>
		<tr>
			<td style="text-align:center;">Unpaid</td>
			<td style="text-align:center;"></td>
			<td style="text-align:center;">$<?=$unpaid?></td>
		</tr>
		<tr>
			<td style="text-align:center;"><?=date('M', strtotime('next month'))?> 1st</td>
			<td style="text-align:center;"></td>
			<td style="text-align:center;">$<?=$next?></td>
		</tr>
	</tbody>
</table>