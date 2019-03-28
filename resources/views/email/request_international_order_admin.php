<?php

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

foreach ($items as $item) {
    $even = $row % 2 == 0;

    if ($even)
        $table .= "<tr style='background:#ddd;'>";
    else
        $table .= "<tr>";

	$table .= "
        <td style=padding:4px;vertical-align:top;width:60%;>{$item['artist']} - {$item['title']}</td>
        <td style=padding:4px;vertical-align:top;width:60%;text-align:right>\${$helpers->format_money($item['cost'])}</td>
        <td style=padding:4px;vertical-align:top;width:60%;text-align:right>{$item['quantity_ordered']}</td>
        <td style=padding:4px;vertical-align:top;width:60%;text-align:right>\${$helpers->format_money($item['subtotal'])}</td>
	</tr>
    ";

    $row += 1;
}

$table .= "
    </tbody>
    </table>
    <p style='font-weight:bold;'>Order Total: \${$helpers->format_money($order_total)}</p>
    ";

?>

<p>A customer has requested to place a new international order!</p>
<p>
    Name: <?php echo $name; ?><br>
    Email: <?php echo $email; ?>
</p>

<?php echo $table; ?>