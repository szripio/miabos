<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<body>
<div class="page_content">

	<?php if ($action == 1) {
		echo form_open('products/insertproduct');
		echo '<div class="margin-default-bt"><button type="submit" name="insert" class="btn btn-primary">Rögzít</button></div>';		
	}else{
		echo form_open('products/updateproduct');
		echo '<div class="margin-default-bt"><input type="submit" name="update" class="btn btn-primary" value="Módosít"></div>';
	}?>
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-container">
	<div class="margin-default-bt"><input type="hidden" name="hidden_id" class="btn btn-primary" value="<?php echo set_value('id',(isset($data)) ? $data['id']:''); ?>"/></div>
		<span><strong>Termék adatok</strong></span><br><br>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="product_name">Megnevezés</label>
			<input type="text" class="form-control" name="product_name" value="<?php echo set_value('product_name',(isset($data)) ? $data['termeknev']:''); ?>" >
			<span class="text-danger"><?php echo form_error('product_name')?></span>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="product_quantity">Alapértelmezett mennyiség</label>
			<input type="text" class="form-control" name="product_quantity" value="<?php echo set_value('product_quantity',(isset($data)) ? $data['menny'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('product_quantity')?></span>			
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="product_quantity_unit">Mennyiségi egység</label>
			<input type="text" class="form-control" name="product_quantity_unit" value="<?php echo set_value('product_quantity_unit',(isset($data)) ? $data['mennyegys'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('product_quantity_unit')?></span>			
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="product_unit_price">Nettó egységár</label>
			<input type="text" class="form-control" name="product_unit_price" value="<?php echo set_value('product_unit_price',(isset($data)) ? $data['nettoegysegar'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('product_unit_price')?></span>			
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="product_net_value">Nettó ár</label>
			<input type="text" class="form-control" name="product_net_value" value="<?php echo set_value('product_net_value',(isset($data)) ? $data['nettoar'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('product_net_value')?></span>			
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<input type="hidden" class="form-control" name="product_vat_id" value="<?php echo set_value('product_vat_id',(isset($data)) ? $data['afakulcs'] : ''); ?>" >
			<label for="product_vat_rate">Áfakulcs</label>
			
		
					<select class="form-control input-sm" name="vat_rate_id">
			    		<?php foreach ($afakulcss as $afakulcs) {
			    		if (isset($data["afakulcs_id"]) && ($data["afakulcs_id"] == $afakulcs["id"])){ ?>
			    			<option selected="selected" value="<?php echo $afakulcs["id"];?>"><?php echo $afakulcs["megnevezes"]?></option>
			    		<?php }else{?>
			    			<option value="<?php echo $afakulcs["id"];?>" ><?php echo $afakulcs["megnevezes"]?></option>
			    		<?php }?>
			    		<?php }?>
			    	</select>
		   
			<span class="text-danger"><?php echo form_error('product_vat_rate')?></span>			
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="product_vat_value">Áfa érték</label>
			<input type="text" class="form-control" name="product_vat_value" value="<?php echo set_value('product_vat_value',(isset($data)) ? $data['afaertek'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('product_vat_value')?></span>			
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label for="product_gross_value">Bruttó ár</label>
			<input type="text" class="form-control" name="product_gross_value" value="<?php echo set_value('product_gross_value',(isset($data)) ? $data['bruttoar'] : ''); ?>" >
			<span class="text-danger"><?php echo form_error('product_gross_value')?></span>			
		</div>							
	</div>
	</form>

</div>

</body>
</html>
