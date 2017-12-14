<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body>

<div class="page_content">
	<div class="margin-default-bt"><a href="/products/insertproduct"><div class="btn btn-info">Új termék</div></a></div>
	<div class="table-responsive half-width">
		<table id="example" class="table table-striped " cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>Megnevezés</th>
				<th>Menny</th>
				<th>Egységár</th>
				<th>Nettóár</th>
				<th>Áfakulcs</th>
				<th>Bruttóár</th>
				<th>M</th>
				<th>D</th>
			</tr>
			</thead>
			<tbody>
			<?php 
			if (!empty($products))
			{
				foreach($products as $row)
				{
			?>
				<tr>
					<td><?php echo $row["termeknev"] ?></td>
					<td><?php echo $row["menny"] ?></td>
					<td><?php echo number_format($row["nettoegysegar"], 2, '.', '') ?></td>
					<td><?php echo number_format($row["nettoar"], 2, '.', '') ?></td>
					<td><?php echo $row["afakulcs"] ?></td>
					<td><?php echo number_format($row["bruttoar"], 2, '.', '') ?></td>
					<td><a href="<?php echo base_url();?>products/updateproduct/<?php echo $row["id"]; ?>" title="Módosít"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
					<td><a href="#" class="delete-product" id="<?php echo $row["id"] ?>" title="Törlés"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
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
		$('.delete-product').click(function(){
		var id = $(this).attr("id");
		if(confirm("Biztos törölni szeretnéd ezt a terméket?"))
		{
			window.location="<?php echo base_url();?>products/deleteProduct/"+id;
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