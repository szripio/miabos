<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<body>
<div class="page_content">

	<?php if ($action == 1) {
		echo form_open('vatdatas/insertvatdata');
		echo '<div class="margin-default-bt"><button type="submit" name="insert" class="btn btn-primary">Rögzít</button></div>';		
	}else{
		echo form_open('vatdatas/updatevatdata');
		echo '<div class="margin-default-bt"><input type="submit" name="update" class="btn btn-primary" value="Módosít"></div>';
	}?>
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-container">
	<div class="margin-default-bt"><input type="hidden" name="hidden_id" class="btn btn-primary" value="<?php echo set_value('id',(isset($data)) ? $data['id']:''); ?>"/></div>
		<span><strong>Áfakulcs adatok</strong></span><br><br>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_name">Megnevezés</label>
			<input type="text" class="form-control" name="vat_name" value="<?php echo set_value('vat_name',(isset($data)) ? $data['megnevezes']:''); ?>" >
			<span class="text-danger"><?php echo form_error('vat_name')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_vatnumber">Érték</label>
			<input type="text" class="form-control" name="vat_value" value="<?php echo set_value('vat_value',(isset($data)) ? $data['ertek'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('vat_value')?></span>			
		</div>
	</div>
	</form>

</div>

</body>
</html>
