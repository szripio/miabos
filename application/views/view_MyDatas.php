<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<body>
<div class="page_content">
	<div class="margin-default-bt"><a href="/mydatas/updatedatas/<?php echo $companydatas["id"]; ?>"><div class="btn btn-info">Adatok módosítása</div></a></div>
		<table class="table table-striped" style="width:45%;float:left;margin-right: 20px">
			<tr>
				<td class="label-line">Név</td>
				<td class="data-line"><?php echo $companydatas["nev"]?></td>
			</tr>
			<tr>
				<td class="label-line">Adószám</td>
				<td class="data-line"><?php echo $companydatas["adoszam"]?></td>
			</tr>
			<tr>
				<td class="label-line">Közösségi adószám</td>
				<td class="data-line"><?php echo $companydatas["kozadoszam"]?></td>
			</tr>
			<tr>
				<td class="label-line">Csoportos adószám</td>
				<td class="data-line"><?php echo (!empty($companydatas["csopadoszam"]) ? $companydatas["csopadoszam"] : '-') ?></td>
			</tr>
			<tr>
				<td class="label-line">Cím</td>
				<td class="data-line"><?php echo $companydatas["cim_irszam"].' '.$companydatas["cim_telepules"].' '.$companydatas["cim_kozternev"].' '.$companydatas["cim_kozterjelleg"].' '.$companydatas["cim_hazszam"].' '.$companydatas["cim_egyeb"] ?></td>
			</tr>
			<tr>
				<td class="label-line">E-mail</td>
				<td class="data-line"><?php echo $companydatas["email"]?></td>
			</tr>
			<tr>
				<td class="label-line">Kisadózó</td>
				<td class="data-line"><?php echo ($companydatas["kisadozo"]==0 ? 'Nem' : 'Igen')?></td>
			</tr>
			<tr>
				<td class="label-line">Egyéni vállalkozó</td>
				<td class="data-line"><?php echo ($companydatas["egyeni_vallalkozo"]==0 ? 'Nem' : 'Igen')?></td>
			</tr>						
			<tr>
				<td class="label-line">Számlaközpont HASH kód</td>
				<td class="data-line"><?php echo $companydatas["apikey"]?></td>
			</tr>
		</table>
		<table class="table table-striped" style="width:45%;float:left;margin-bottom: 10px">
		<?php for ($i=0;$i<$counter["total"];$i++){?>
			<tr>
				<td colspan="2">Bank <?php echo $i+1;?></td>
			</tr>
			<tr>
				<td class="label-line">Bank neve</td>
				<td class="data-line"><?php echo $bankdatas[$i]["bankszamla"] ?></td>
			</tr>
			<tr>
				<td class="label-line">Bankszámlaszám</td>
				<td class="data-line"><?php echo $bankdatas[$i]["bankszamla"]?></td>
			</tr>
			<tr>
				<td class="label-line">IBAN</td>
				<td class="data-line"><?php echo $bankdatas[$i]["iban"]?></td>
			</tr>
			<tr>
				<td class="label-line">SWIFT</td>
				<td class="data-line"><?php echo $bankdatas[$i]["swift"] ?></td>
			</tr>
			<tr>
				<td class="label-line">&nbsp;</td>
				<td class="data-line">&nbsp;</td>
			</tr>
			</tbody>
		<?php }?>	
		</table>
	
</div>

</body>
</html>
