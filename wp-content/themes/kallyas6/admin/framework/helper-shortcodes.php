<?php


$headings = array(
	'Page Subtitle'  => '[subtitle] ' . __( 'Content', THEMENAME ) . ' [/subtitle]',
	'H1 Alternative' => '[h1a] ' . __( 'Content', THEMENAME ) . ' [/h1a]',
	'H2 Alternative' => '[h2a] ' . __( 'Content', THEMENAME ) . ' [/h2a]',
	'H3 Alternative' => '[h3a] ' . __( 'Content', THEMENAME ) . ' [/h3a]',
	'H4 Alternative' => '[h4a] ' . __( 'Content', THEMENAME ) . ' [/h4a]',
	'H5 Alternative' => '[h5a] ' . __( 'Content', THEMENAME ) . ' [/h5a]',
	'H6 Alternative' => '[h6a] ' . __( 'Content', THEMENAME ) . ' [/h6a]'
);

$lists = array(
	'Arrow list' => '[list type="list-style1"] <ul><li> ' . __( 'First list item', THEMENAME ) . '</li> <li> ' . __( 'Second list item', THEMENAME ) . ' </li> </ul> [/list]',
	'Check list' => '[list type="list-style2"] <ul><li> ' . __( 'First list item', THEMENAME ) . '</li> <li> ' . __( 'Second list item', THEMENAME ) . ' </li> </ul> [/list]'
);

$blockquotes = array(
	'Left aligned'  => '[blockquote author=""] ' . __( 'Content', THEMENAME ) . ' [/blockquote]',
	'Right aligned' => '[blockquote author="" align=""] ' . __( 'Content', THEMENAME ) . ' [/blockquote]'
);

$buttons = array(
	'Button'         => '[button style="" url="" size="" block="false" target="_self"] ' . __( 'BUTTON TEXT', THEMENAME ) . ' [/button]',
	'Button Primary' => '[button style="btn-primary" url="" size="" block="false" target="_self"] ' . __( 'BUTTON TEXT', THEMENAME ) . ' [/button]',
	'Button info'    => '[button style="btn-info" url="" size="" block="false" target="_self"] ' . __( 'BUTTON TEXT', THEMENAME ) . ' [/button]',
	'Button success' => '[button style="btn-success" url="" size="" block="false" target="_self"] ' . __( 'BUTTON TEXT', THEMENAME ) . ' [/button]',
	'Button warning' => '[button style="btn-warning" url="" size="" block="false" target="_self"] ' . __( 'BUTTON TEXT', THEMENAME ) . ' [/button]',
	'Button danger'  => '[button style="btn-danger" url="" size="" block="false" target="_self"] ' . __( 'BUTTON TEXT', THEMENAME ) . ' [/button]',
	'Button inverse' => '[button style="btn-inverse" url="" size="" block="false" target="_self"] ' . __( 'BUTTON TEXT', THEMENAME ) . ' [/button]'
);

$accordions = array(
	'Style 1' => '[accordion title="" style="default-style" collapsed="false"] ' . __( 'Content', THEMENAME ) . ' [/accordion]',
	'Style 2' => '[accordion title="" style="style2" collapsed="false"] ' . __( 'Content', THEMENAME ) . ' [/accordion]',
	'Style 3' => '[accordion title="" style="style3" collapsed="false"] ' . __( 'Content', THEMENAME ) . ' [/accordion]',
);

$misc = array(
	'QR Code' => '[qr align="right" size="140"] MECARD:N:Marius Hogas;ADR:MyStreet 22, Bucuresti;TEL:+ (50) 555 89 89;TEL:+ (50) 555 88 88;TEL:+ (50) 555 87 87;TEL:+ (50) 555 86 86;EMAIL:mhogas@gmail.com;URL:http://www.hogash.com/; [/qr]',
	'Code'    => '[code] ' . __( 'Content', THEMENAME ) . ' [/code]',
	'Skills'  => '[skills main_text="skills" main_color="#193340" text_color="#ffffff"] <br/>

[skill main_color="#97BE0D" percentage="95"] ' . __( 'JavaScript', THEMENAME ) . ' [/skill]<br/>

[skill main_color="#D84F5F" percentage="90"] ' . __( 'CSS3', THEMENAME ) . ' [/skill]<br/>

[skill main_color="#88B8E6" percentage="80"] ' . __( 'HTML5', THEMENAME ) . ' [/skill]<br/>

[skill main_color="#BEDBE9" percentage="53"] ' . __( 'PHP', THEMENAME ) . ' [/skill]<br/>

[skill main_color="#EDEBEE" percentage="45"] ' . __( 'MySQL', THEMENAME ) . ' [/skill]<br/>

[/skills]',
	'Tooltip' => '[tooltip placement="top" border="yes" title="Tooltip Title"] ' . __( 'Content', THEMENAME ) . ' [/tooltip]',
	'Icon'    => '[icon white="false" ] icon-glass [/icon]',
);


$tables = array(
	'Striped'         => '[table type="table-striped"] <table>
<thead>
	<tr>
		<th>#</th>
		<th>' . __( 'First Name', THEMENAME ) . '</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>' . __( '1', THEMENAME ) . '</td>
		<td>' . __( 'Mark', THEMENAME ) . '</td>
	</tr>
	<tr>
		<td>' . __( '2', THEMENAME ) . '</td>
		<td>' . __( 'Jacob', THEMENAME ) . '</td>
	</tr>
	<tr>
		<td>' . __( '3', THEMENAME ) . '</td>
		<td>' . __( 'Larry', THEMENAME ) . '</td>
	</tr>
</tbody>
</table> [/table]',
	'Bordered'        => '[table type="table-bordered"] <table>
<thead>
	<tr>
		<th>#</th>
		<th>' . __( 'First Name', THEMENAME ) . '</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>' . __( '1', THEMENAME ) . '</td>
		<td>' . __( 'Mark', THEMENAME ) . '</td>
	</tr>
	<tr>
		<td>' . __( '2', THEMENAME ) . '</td>
		<td>' . __( 'Jacob', THEMENAME ) . '</td>
	</tr>
	<tr>
		<td>' . __( '3', THEMENAME ) . '</td>
		<td>' . __( 'Larry', THEMENAME ) . '</td>
	</tr>
</tbody>
</table> [/table]',
	'Hover Table'     => '[table type="table-hover"] <table>
<thead>
	<tr>
		<th>#</th>
		<th>' . __( 'First Name', THEMENAME ) . '</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>' . __( '1', THEMENAME ) . '</td>
		<td>' . __( 'Mark', THEMENAME ) . '</td>
	</tr>
	<tr>
		<td>' . __( '2', THEMENAME ) . '</td>
		<td>' . __( 'Jacob', THEMENAME ) . '</td>
	</tr>
	<tr>
		<td>' . __( '3', THEMENAME ) . '</td>
		<td>' . __( 'Larry', THEMENAME ) . '</td>
	</tr>
</tbody>
</table> [/table]',
	'Condensed Table' => '[table type="table-condensed"] <table>
<thead>
	<tr>
		<th>#</th>
		<th>' . __( 'First Name', THEMENAME ) . '</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td>' . __( '1', THEMENAME ) . '</td>
		<td>' . __( 'Mark', THEMENAME ) . '</td>
	</tr>
	<tr>
		<td>' . __( '2', THEMENAME ) . '</td>
		<td>' . __( 'Jacob', THEMENAME ) . '</td>
	</tr>
	<tr>
		<td>' . __( '3', THEMENAME ) . '</td>
		<td>' . __( 'Larry', THEMENAME ) . '</td>
	</tr>
</tbody>
</table> [/table]',
);

$layouts = array(
	'Row'         => '[row] ' . __( 'Content', THEMENAME ) . ' [/row]',
	'Two Columns' => '[one_half_column] ' . __( 'Content', THEMENAME ) . ' [/one_half_column]',
	'1/3 Columns' => '[one_third_column] ' . __( 'Content', THEMENAME ) . ' [/one_third_column]',
	'1/4 Columns' => '[one_fourth_column] ' . __( 'Content', THEMENAME ) . ' [/one_fourth_column]',
	'2/3 Columns' => '[two_third_column] ' . __( 'Content', THEMENAME ) . ' [/two_third_column]',
	'3/4 Columns' => '[three_fourth_column] ' . __( 'Content', THEMENAME ) . ' [/three_fourth_column]',
);

$pricing = array(
	'Red'         => '[pricing_table color="red" columns="4" space="no" rounded="no"]

[pricing_column name="' . __( 'Starter', THEMENAME ) . '" highlight="no" price="' . __( '$6.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Standard', THEMENAME ) . '" highlight="yes" price="' . __( '$9.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Professional', THEMENAME ) . '" highlight="no" price="' . __( '$13.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Ultra', THEMENAME ) . '" highlight="no" price="' . __( '$99.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#"
button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[/pricing_table]',
	'Blue'        => '[pricing_table color="blue" columns="4" space="no" rounded="no"]

[pricing_column name="' . __( 'Starter', THEMENAME ) . '" highlight="no" price="' . __( '$6.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Standard', THEMENAME ) . '" highlight="yes" price="' . __( '$9.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Professional', THEMENAME ) . '" highlight="no" price="' . __( '$13.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Ultra', THEMENAME ) . '" highlight="no" price="' . __( '$99.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#"
button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[/pricing_table]',
	'Green'       => '[pricing_table color="green" columns="4" space="no" rounded="no"]

[pricing_column name="' . __( 'Starter', THEMENAME ) . '" highlight="no" price="' . __( '$6.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Standard', THEMENAME ) . '" highlight="yes" price="' . __( '$9.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Professional', THEMENAME ) . '" highlight="no" price="' . __( '$13.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Ultra', THEMENAME ) . '" highlight="no" price="' . __( '$99.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#"
button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[/pricing_table]',
	'Turquoise'   => '[pricing_table color="turquoise" columns="4" space="no" rounded="no"]

[pricing_column name="' . __( 'Starter', THEMENAME ) . '" highlight="no" price="' . __( '$6.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Standard', THEMENAME ) . '" highlight="yes" price="' . __( '$9.99', THEMENAME ) . '"
price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Professional', THEMENAME ) . '" highlight="no" price="' . __( '$13.99', THEMENAME ) . '"
price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Ultra', THEMENAME ) . '" highlight="no" price="' . __( '$99.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[/pricing_table]',
	'Orange'      => '[pricing_table color="orange" columns="4" space="no" rounded="no"]

[pricing_column name="' . __( 'Starter', THEMENAME ) . '" highlight="no" price="' . __( '$6.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Standard', THEMENAME ) . '" highlight="yes" price="' . __( '$9.99', THEMENAME ) . '"
price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Professional', THEMENAME ) . '" highlight="no" price="' . __( '$13.99', THEMENAME ) . '"
price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Ultra', THEMENAME ) . '" highlight="no" price="' . __( '$99.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#"
button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[/pricing_table]',
	'Purple'      => '[pricing_table color="purple" columns="4" space="no" rounded="no"]

[pricing_column name="' . __( 'Starter', THEMENAME ) . '" highlight="no" price="' . __( '$6.99', THEMENAME ) . '" price_value="' . __
		( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . ']
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Standard', THEMENAME ) . '" highlight="yes" price="' . __( '$9.99', THEMENAME ) . '" price_value="' . __
	                 ( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Professional', THEMENAME ) . '" highlight="no" price="' . __( '$13.99', THEMENAME ) . '"
price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Ultra', THEMENAME ) . '" highlight="no" price="' . __( '$99.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[/pricing_table]',
	'Yellow'      => '[pricing_table color="yellow" columns="4" space="no" rounded="no"]

[pricing_column name="' . __( 'Starter', THEMENAME ) . '" highlight="no" price="' . __( '$6.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#"
button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Standard', THEMENAME ) . '" highlight="yes" price="' . __( '$9.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Professional', THEMENAME ) . '" highlight="no" price="' . __( '$13.99', THEMENAME ) . '"
price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Ultra', THEMENAME ) . '" highlight="no" price="' . __( '$99.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[/pricing_table]',
	'Green Lemon' => '[pricing_table color="green_lemon" columns="4" space="no" rounded="no"]

[pricing_column name="' . __( 'Starter', THEMENAME ) . '" highlight="no" price="' . __( '$6.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Standard', THEMENAME ) . '" highlight="yes" price="' . __( '$9.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Professional', THEMENAME ) . '" highlight="no" price="' . __( '$13.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Ultra', THEMENAME ) . '" highlight="no" price="' . __( '$99.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[/pricing_table]',
	'Dark'        => '[pricing_table color="dark" columns="4" space="no" rounded="no"]

[pricing_column name="' . __( 'Starter', THEMENAME ) . '" highlight="no" price="' . __( '$6.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#"
button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Standard', THEMENAME ) . '" highlight="yes" price="' . __( '$9.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '"
button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Professional', THEMENAME ) . '" highlight="no" price="' . __( '$13.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Ultra', THEMENAME ) . '" highlight="no" price="' . __( '$99.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[/pricing_table]',
	'Light'       => '[pricing_table color="light" columns="4" space="no" rounded="no"]

[pricing_column name="' . __( 'Starter', THEMENAME ) . '" highlight="no" price="' . __( '$6.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Standard', THEMENAME ) . '" highlight="yes" price="' . __( '$9.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Professional', THEMENAME ) . '" highlight="no" price="' . __( '$13.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Ultra', THEMENAME ) . '" highlight="no" price="' . __( '$99.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[/pricing_table]',
	'Caption'     => '[pricing_table color="red" columns="4" space="no" rounded="no"]
[pricing_caption name="TITLE"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_caption]

[pricing_column name="' . __( 'Standard', THEMENAME ) . '" highlight="yes" price="' . __( '$6.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Professional', THEMENAME ) . '" highlight="no" price="' . __( '$9.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[pricing_column name="' . __( 'Ultra', THEMENAME ) . '" highlight="no" price="' . __( '$99.99', THEMENAME ) . '" price_value="' . __( 'per month', THEMENAME ) . '" button_link="#" button_text="' . __( 'ORDER NOW', THEMENAME ) . '"]
<ul>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
<li>' . __( 'TEXT', THEMENAME ) . '</li>
</ul>
[/pricing_column]

[/pricing_table]',

);

$tabs = array(
	'Style 1' => '[tabs style="style1"]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[/tabs]<br/>',
	'Style 2' => '[tabs style="style2"]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[/tabs]<br/>',
	'Style 3' => '[tabs style="style3"]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[/tabs]<br/>',
	'Style 4' => '[tabs style="style4"]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[tab title="TAB_NAME"] ' . __( 'CONTENT', THEMENAME ) . ' [/tab]<br/>
[/tabs]<br/>'
);

$categories = array(
	'Headings'      => $headings,
	'Lists'         => $lists,
	'Tables'        => $tables,
	'Blockquotes'   => $blockquotes,
	'Misc'          => $misc,
	'Layouts'       => $layouts,
	'Buttons'       => $buttons,
	'PricingTables' => $pricing,
	'Accordions'    => $accordions,
	'Tabs'          => $tabs
);