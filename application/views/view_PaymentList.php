<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body>

<div class="page_content">
	<div class="margin-default-bt"><a href="/payment/insertpayment"><div class="btn btn-info">Új fizetési mód</div></a></div>
	<div class="table-responsive half-width">
		<table id="example" class="table table-striped " cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>Megnevezés</th>
				<th>Napok száma</th>
				<th>Létrehozás dátuma</th>
				<th>Létrehozó user</th>
				<th>M</th>
				<th>D</th>
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
					<td><?php echo $row["megnevezes"] ?></td>
					<td><?php echo $row["eltolas"] ?></td>
					<td><?php echo $row["letrehozas_datum"] ?></td>
					<td><?php echo $row["letrehozo_user"] ?></td>
					<td><a href="<?php echo base_url();?>payment/updatepayment/<?php echo $row["id"]; ?>" title="Módosít"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
					<td><a href="#" class="delete-payment" id="<?php echo $row["id"] ?>" title="Törlés"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
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
<script>
			
	$(document).ready(function(){
		$('.delete-payment').click(function(){
		var id = $(this).attr("id");
		if(confirm("Biztos törölni szeretnéd ezt a fizetési módot?"))
		{
			window.location="<?php echo base_url();?>payment/deletePayment/"+id;
		}
		else
		{
			return false;
		} 
		})
	});
</script>
</body>
</html>