<?php
	$apiKey = 'XXX';

	date_default_timezone_set('America/Los_Angeles');

	$phpSales  = 0;
	$phpDollas = 0;

	$nodeSales  = 0;
	$nodeDollas = 0;

	$sales  = 0;
	$dollas = 0;
	$unpaid = 0;
	$next   = 0;

	//pull the php book sales data from the API
	$ch = curl_init('https://leanpub.com/buildingsecurephpapps/sales.json?api_key=' . $apiKey);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	$response = curl_exec($ch);

	if (isset($response) && !empty($response)) {

		$data = json_decode($response);

		//set sales and royalties
		$phpSales  += $data->num_happy_paid_purchases;
		$phpDollas += $data->total_book_royalties;

		$sales  += $data->num_happy_paid_purchases;
		$dollas += $data->total_book_royalties;
		$unpaid += $data->unpaid_royalties;
		$next   += $data->royalties_due_on_first_of_next_month;
	}


	//pull the node book sales data from the API
	$nCh = curl_init('https://leanpub.com/buildingsecurenodeapps/sales.json?api_key=' . $apiKey);

	curl_setopt($nCh, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($nCh, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($nCh, CURLOPT_SSL_VERIFYPEER, FALSE);

	$nodeResponse = curl_exec($nCh);

	if (isset($nodeResponse) && !empty($nodeResponse)) {

		$nodeData = json_decode($nodeResponse);

		//set sales and royalties
		$nodeSales  += $nodeData->num_happy_paid_purchases;
		$nodeDollas += $nodeData->total_book_royalties;

		$sales  += $nodeData->num_happy_paid_purchases;
		$dollas += $nodeData->total_book_royalties;
		$unpaid += $nodeData->unpaid_royalties;
		$next   += $nodeData->royalties_due_on_first_of_next_month;
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
			<td style="text-align:center;">PHP</td>
			<td style="text-align:center;"><?=$phpSales?></td>
			<td style="text-align:center;">$<?=$phpDollas?></td>
		</tr>
		<tr>
			<td style="text-align:center;">Node</td>
			<td style="text-align:center;"><?=$nodeSales?></td>
			<td style="text-align:center;">$<?=$nodeDollas?></td>
		</tr>
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