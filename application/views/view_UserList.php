<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<body>

<div class="page_content">
	<div class="table-responsive">
		<table class="table table-striped">
			<tr>
				<th>Név</th>
				<th>Felhasználó név</th>
				<th>Létrehozás dátum</th>
				<th>Módosítás dátum</th>
				<th>Létrehozó user</th>
				<th>Módosító user</th>
			</tr>
			<?php 
			if ($user_data->num_rows()>0)
			{
				foreach($user_data->result() as $row)
				{
			?>
				<tr>
					<td><?php echo $row->nev?></td>
					<td><?php echo $row->felhasznalo_nev?></td>
					<td><?php echo $row->letrehozas_datum?></td>
					<td><?php echo $row->modositas_datum?></td>
					<td><?php echo $row->letrehozo_user?></td>
					<td><?php echo $row->modosito_user?></td>
				</tr>
			<?php 			
				}
			}
			else 
			{
			?>
			<tr>
			<td colspan="6">Nincs adat</td>
			</tr>
			<?php 
			}
			?>
		</table>
	</div>
</div>

</body>
</html>
