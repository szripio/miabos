<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<body>
<div class="page_content">

	<?php if ($action == 1) {
		echo form_open('payment/insertpayment');
		echo '<div class="margin-default-bt"><button type="submit" name="insert" class="btn btn-primary">Rögzít</button></div>';		
	}else{
		echo form_open('payment/updatepayment');
		echo '<div class="margin-default-bt"><input type="submit" name="update" class="btn btn-primary" value="Módosít"></div>';
	}?>
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-container">
	<div class="margin-default-bt"><input type="hidden" name="hidden_id" class="btn btn-primary" value="<?php echo set_value('id',(isset($datas)) ? $datas['id']:''); ?>"/></div>
		<span><strong>Fizetési mód adatok</strong></span><br><br>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_name">Megnevezés</label>
			<input type="text" class="form-control" name="payment_name" value="<?php echo set_value('payment_name',(isset($datas)) ? $datas['megnevezes']:''); ?>" >
			<span class="text-danger"><?php echo form_error('payment_name')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="customer_vatnumber">Érték</label>
			<input type="text" class="form-control" name="payment_value" value="<?php echo set_value('payment_value',(isset($datas)) ? $datas['eltolas'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('payment_value')?></span>			
		</div>
	</div>
	</form>

</div>

</body>
</html>
