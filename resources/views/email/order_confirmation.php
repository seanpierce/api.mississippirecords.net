<?php

// email needs:
// - order number
// - items
// - helpers class
// - order total
// - customer name
// - shipping
// - tax

$table = "	
<table style=width:100%;border-collapse:collapse;table-layout:fixed;>
<thead style=border-bottom:1px;border-color:lightgrey;margin-bottom:12px;>
	<tr>
        <td style=padding-bottom:6px;border-bottom:solid;border-color:lightgray;text-align:left;>Item</td>
        <td style=padding-bottom:6px;border-bottom:solid;border-color:lightgray;text-align:right;>Cost</td>
        <td style=padding-bottom:6px;border-bottom:solid;border-color:lightgray;text-align:right;>QTY</td>
        <td style=padding-bottom:6px;border-bottom:solid;border-color:lightgray;text-align:right;>Sub</td>
	</tr>
</thead>
<tbody>
";

$row = 1;

foreach ($line_item_details as $item) {
    $even = $row % 2 == 0;

    if ($even)
        $table .= "<tr style='background:#ddd;'>";
    else
        $table .= "<tr>";

	$table .= "
        <td style=padding:4px;vertical-align:top;width:60%;>$item->artist - $item->title</td>
        <td style=padding:4px;vertical-align:top;width:60%;text-align:right>\${$helpers->format_money($item->cost)}</td>
        <td style=padding:4px;vertical-align:top;width:60%;text-align:right>$item->quantity_ordered</td>
        <td style=padding:4px;vertical-align:top;width:60%;text-align:right>\${$helpers->format_money($item->subtotal)}</td>
	</tr>
    ";

    $row += 1;
}

$table .= "
    <tr>
        <td></td>
        <td></td>
        <td>Shipping</td>
        <td>\${$helpers->format_money($shipping_total)}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Tax</td>
        <td>\${$helpers->format_money($tax)}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td>Tax</td>
        <td>\${$helpers->format_money($order_total)}</td>
    </tr>
    
";

?>

<p>Thanks for your order. Below you'll find the details:</p>

<?php echo $table; ?>

<p>Please allow 3 - 5 business days for shipping. If you have questions, send us a message at orders@mississippirecords.net.</p>
<p>Thanks again for your support!</p>