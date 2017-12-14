<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body>
<div class="page_content">

	<?php echo form_open('dataimport/invoicequantityimport'); ?>
	<div class="margin-default-bt"><button type="submit" name="insert" class="btn btn-primary">Rögzít</button></div>
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-container">
		<span><strong>Alapadatok</strong></span><br><br>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="importdata_year">Év</label>
			<input type="text" class="form-control" name="importdata_year" value="<?php echo set_value('importdata_year',(isset($customerdata)) ? $customerdata['ev']:''); ?>" >
			<span class="text-danger"><?php echo form_error('importdata_year')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="importdata_month">Hónap</label>
			<input type="text" class="form-control" name="importdata_month" value="<?php echo set_value('importdata_month',(isset($customerdata)) ? $customerdata['honap'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('importdata_month')?></span>			
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="importdata_quantity">Darabszám</label>
			<input type="text" class="form-control" name="importdata_quantity" value="<?php echo set_value('importdata_quantity', (isset($customerdata)) ? $customerdata['darabszam'] : '' ); ?>" >
			<span class="text-danger"><?php echo form_error('importdata_quantity')?></span>			
		</div>
	</div>
	</form>

</div>

</body>
</html>
