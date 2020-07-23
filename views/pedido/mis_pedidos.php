<!-- REUTILIZAR VISTA DE ACUERDO A LO QUE LLEGUE -->
<?php if(isset($gestion)):?>
	<h1>Gestionar pedidos</h1>
<?php else: ?>
	<h1>Mis pedidos</h1>
<?php endif; ?>


<!-- Mostrar productos -->
<table class="mis-pedidos">
    <tr class="tr-pedidos">
        <th class="th-pedidos">No Pedido</th>
        <th class="th-pedidos">Coste</th>
        <th class="th-pedidos">Fecha</th>
        <th class="th-pedidos">Estado</th>
    </tr>
    <!-- Recogemos la var carrito enviado por controlador  
         Recorrer carrito y en cada iteracion conseguir el producto-->
    <?php 
		while($ped = $pedidos->fetch_object()): 
	?>
        <tr class="tr-pedidos">
            <td class="td-pedidos">
            	<!-- enlace para ir al pedido pasandole parametro get con el id -->
                <a href="<?=base_url?>pedido/detalle&id=<?=$ped->id?>"><?= $ped->id?> </a>
            </td>
            <td class="td-pedidos">
                $ <?= $ped->coste?>
        	</td>
	        <td class="td-pedidos">
				<?= $ped->fecha?>
			</td>
			<td class="td-pedidos">
				<?=Utils::showStatus($ped->estado)?> <br>
			</td>
        </tr>
    <?php endwhile; ?>
</table>