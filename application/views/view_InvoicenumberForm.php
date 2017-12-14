<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<body>
<div class="page_content">

	<?php echo form_open('invoicenumber/insertinvoicenumber');	?>
	<div class="margin-default-bt"><button type="submit" name="insert" class="btn btn-primary">Rögzít</button></div>
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-container">
	<div class="margin-default-bt"><input type="hidden" name="hidden_id" class="btn btn-primary" value="<?php echo set_value('id',(isset($datas)) ? $datas['id']:''); ?>"/></div>
		<span><strong>Számlatömb adatok</strong></span><br><br>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_name">Prefix</label>
			<input type="text" class="form-control" name="invoicenumber_prefix" value="<?php echo set_value('invoicenumber_prefix',(isset($datas)) ? $datas['prefix']:''); ?>" >
			<span class="text-danger"><?php echo form_error('invoicenumber_prefix')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_vatnumber">Suffix</label>
			<input type="text" class="form-control" name="invoicenumber_suffix" value="<?php echo set_value('invoicenumber_suffix',(isset($datas)) ? $datas['suffix'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('invoicenumber_suffix')?></span>			
		</div>
	</div>
	</form>

</div>

</body>
</html>
