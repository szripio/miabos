<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<body>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        "pagingType": "full_numbers"
    } );

} );

</script> 
<div class="page_content">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
			<tr>
				<th colspan="7">Utoljára rögzített ügyfelek</th>
			</tr>
			</thead>
			<tr>
				<th>Név</th>
				<th>Adószám</th>
				<th>E-mail</th>
				<th>Számlázási cím</th>
				<th>Regisztráció dátuma</th>
				<th>M</th>
				<th>D</th>
			</tr>
			<?php 
			if (!empty($latest_customers))
			{
				foreach($latest_customers->result() as $row)
				{
			?>
				<tr>
					<td><?php echo $row->cegnev ?></td>
					<td><?php echo $row->adoszam ?></td>
					<td><?php echo $row->email ?></td>
					<td><?php echo $row->cim_teljes ?></td>
					<td><?php echo $row->reg_datum ?></td>
					<td><a href="<?php echo base_url();?>customers/updatecustomer/<?php echo $row->id; ?>" title="Módosít"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
					<td><a href="#" class="delete-customer" id="<?php echo $row->id; ?>" title="Törlés"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
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
		</table>
	</div>
	<div class="margin-default-bt"><a href="/customers/customerinsert"><div class="btn btn-info">Új ügyfél</div></a></div>
	<div class="table-responsive">
		<table id="example" class="table table-striped " cellspacing="0" width="100%">
			<thead>
			<tr>
				<th>Név</th>
				<th>Adószám</th>
				<th>E-mail</th>
				<th>Számlázási cím</th>
				<th>Regisztráció dátuma</th>
				<th>M</th>
				<th>D</th>
			</tr>
			</thead>
			<tbody>
			<?php 
			if (!empty($customers))
			{
				foreach($customers->result() as $row)
				{
			?>
				<tr>
					<td><?php echo $row->cegnev ?></td>
					<td><?php echo $row->adoszam ?></td>
					<td><?php echo $row->email ?></td>
					<td><?php echo $row->cim_teljes ?></td>
					<td><?php echo $row->reg_datum ?></td>
					<td><a href="<?php echo base_url();?>customers/updatecustomer/<?php echo $row->id; ?>" title="Módosít"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
					<td><a href="#" class="delete-customer" id="<?php echo $row->id ?>" title="Törlés"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
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
		$('.delete-customer').click(function(){
		var id = $(this).attr("id");
		if(confirm("Biztos törölni szeretnéd a céget?"))
		{
			window.location="<?php echo base_url();?>customers/deleteCustomer/"+id;
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
