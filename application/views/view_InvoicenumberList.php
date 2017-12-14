<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body>

<div class="page_content">
	<div class="margin-default-bt"><a href="/invoicenumber/insertinvoicenumber"><div class="btn btn-info">Új számlatömb</div></a></div>
	<div class="table-responsive half-width">
		<table id="example" class="table table-striped " cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>Sorszám prefix</th>
				<th>Sorszám suffix</th>
				<th>Létrehozás dátuma</th>
				<th>Létrehozó user</th>
			</tr>
			</thead>
			<tbody>
			<?php 
			if (!empty($list))
			{
				foreach($list as $row)
				{
			?>
				<tr>
					<td><?php echo $row["prefix"] ?></td>
					<td><?php echo $row["suffix"] ?></td>
					<td><?php echo $row["letrehozas_datum"] ?></td>
					<td><?php echo $row["letrehozo_user"] ?></td>
				</tr>
			<?php 			
				}
			}
			else 
			{
			?>
			<tr>
			<td colspan="7">Nincs adat</td>
			</tr>
			<?php 
			}
			?>
			</tbody>
		</table>
	</div>
</div>	
</body>
</html>