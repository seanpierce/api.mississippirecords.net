<?php

$table = "	
<table style=width:100%;border-collapse:collapse;>
<thead style=border-bottom:1px;border-color:lightgrey;margin-bottom:12px;>
	<tr>
		<td style=padding-bottom:6px;border-bottom:solid;border-color:lightgray;>Item</td>
		<td style=padding-bottom:6px;border-bottom:solid;border-color:lightgray;>Cost</td>
		<td style=padding-bottom:6px;border-bottom:solid;border-color:lightgray;>Qty</td>
		<td style=padding-bottom:6px;border-bottom:solid;border-color:lightgray;>Sub</td>
	</tr>
</thead>
<tbody>
";

// get $order_total from controller
// get $items from controller
foreach ($items as $item) {
	// get $item->subtotal from controller
	$table .= "
	<tr style='style='background:#ddd;'>
		<td style=padding:4px;vertical-align:top;width:60%;>$item->artist - $item->title</td>
		<td style=padding:4px;vertical-align:top;width:60%;>\$$item->cost</td>
		<td style=padding:4px;vertical-align:top;>$item->QuantityOrdered</td>
		<td style=padding:4px;vertical-align:top;>\$$item->subtotal</td>
	</tr>
	";
}

$table .= "<p>Order Total: <strong>\$$order_total</strong></p>";

?>

<p>Thanks for requesting to place an international order. We'll contact you as soon as we can to discuss shipping options. We appreciate your support!</p>

<?php echo $table; ?>