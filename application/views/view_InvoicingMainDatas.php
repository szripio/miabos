<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<body>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        "scrollY":        "400px",
        "scrollCollapse": true,
        "paging":         false,
        "scrollX": false

    } );

    

} );

</script> 
<div class="page_content">
	<div class="table">
		<table id="example" class="table table-striped " cellspacing="0" width="98%">
			<thead>
			<tr>
				<th>Név</th>
				<th>Adószám</th>
				<th>E-mail</th>
				<th>Számlázási cím</th>
				<th>Regisztráció dátuma</th>
			</tr>
			</thead>
			<tbody>
			<?php 
			if (!empty($customers))
			{
				foreach($customers->result() as $row)
				{
			?>
				<tr class="select-customer" id="<?php echo $row->id ?>" style="cursor:pointer;">
					<td><?php echo $row->cegnev ?></td>
					<td><?php echo $row->adoszam ?></td>
					<td><?php echo $row->email ?></td>
					<td><?php echo $row->cim_teljes ?></td>
					<td><?php echo $row->reg_datum ?></td>
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
	<div id="customers-products">
	
	</div>
</div>

<div id="add_data_Modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Számlázási adatok rögzítése</h4>
			</div>
			<div class="modal-body">
				<form method="post" id="insert_data">
					<div class="col-md-1">
					<label class="modal-label">Év:</label></div>
					<div class="col-md-11">
					<select name="currentyear" id="currentyear" class="form-control">
					    <?php
					    for($i=date("Y")-7;$i<=date("Y")+3;$i++) {
					        $sel = ($i == date("Y")) ? "selected" : "";
					        echo "<option value=".$i." ".$sel.">".date("Y", mktime(0,0,0,0,1,$i+1))."</option>";
					    }
					    ?>
					</select>						
					</div>
					<br><br>
					<div class="col-md-1"><label class="modal-label">Cég:</label></div>
					<div class="col-md-11"><select name="customername" id="customername" class="form-control">
					<option value="Sanyi">Sanyi</option>
					<option value="Béla">Béla</option>
					</select></div>
					<br><br>
					<div class="col-md-1"><label class="modal-label">Termék:</label></div>
					<div class="col-md-11"><select name="product" id="product" class="form-control">
					<option value="Sanyi">Sanyi</option>
					<option value="Béla">Béla</option>
					</select></div>
					<br><br>
					<div class="col-md-6">
						<div class="col-md-1"><label class="modal-label">Január:</label></div>
						<div class="col-md-11"><input type="text" name="month1" id="month1" class="form-control month"/></div>
						<br><br>
						<div class="col-md-1"><label class="modal-label">Február:</label></div>
						<div class="col-md-11"><input type="text" name="month2" id="month2" class="form-control month"/></div>
						<br><br>
						<div class="col-md-1"><label class="modal-label">Március:</label></div>
						<div class="col-md-11"><input type="text" name="month3" id="month3" class="form-control month"/></div>
						<br><br>
						<div class="col-md-1"><label class="modal-label">Április:</label></div>
						<div class="col-md-11"><input type="text" name="month4" id="month4" class="form-control month"/></div>
						<br><br>
						<div class="col-md-1"><label class="modal-label">Május:</label></div>
						<div class="col-md-11"><input type="text" name="month5" id="month5" class="form-control month"/></div>
						<br><br>
						<div class="col-md-1"><label class="modal-label">Június:</label></div>
						<div class="col-md-11"><input type="text" name="month6" id="month6" class="form-control month"/></div>
					<br><br>
					</div>
					<div class="col-md-6">
						<div class="col-md-1"><label class="modal-label">Július:</label></div>
						<div class="col-md-11"><input type="text" name="month7" id="month7" class="form-control month"/></div>
						<br><br>
						<div class="col-md-1"><label class="modal-label">Augusztus:</label></div>
						<div class="col-md-11"><input type="text" name="month8" id="month8" class="form-control month"/></div>
						<br><br>
						<div class="col-md-1"><label class="modal-label">Szeptember:</label></div>
						<div class="col-md-11"><input type="text" name="month9" id="month9" class="form-control month"/></div>
						<br><br>
						<div class="col-md-1"><label class="modal-label">Október:</label></div>
						<div class="col-md-11"><input type="text" name="month10" id="month10" class="form-control month"/></div>
						<br><br>
						<div class="col-md-1"><label class="modal-label">November:</label></div>
						<div class="col-md-11"><input type="text" name="month11" id="month11" class="form-control month"/></div>
						<br><br>
						<div class="col-md-1"><label class="modal-label">December:</label></div>
						<div class="col-md-11"><input type="text" name="month12" id="month12" class="form-control month"/></div>
					</div>
					<br><br>
					<input type="submit" name="insert" id="insert" value="Rögzít" class="btn btn-success" style="margin-top:12px" />
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Bezár</button>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){

	$('#insert_data').on('submit',function(event){
		event.PreventDefault();
		if($('#month1').val() == '')
		{
			alert("Január nincs kitöltve!");
		}
	});

	$('.select-customer').click(function(){
	var id = $(this).attr("id");
		$.ajax({
			type: 'GET',
			url: '<?php echo base_url('invoicing/showProductQuantity')?>'+"/"+id,
			
			success: function(result){
				//alert(result);
				$('#customers-products').html(result);
			}
		});
	});
});
</script>
</body>
</html>
