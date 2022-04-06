<!-- Page header -->
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fab fa-dashcube fa-fw"></i> &nbsp; FANTASY ISLAND
	</h3>
	<p class="text-justify">
		
	</p>
</div>

<!-- Content -->
<div class="full-box tile-container">
	<a href="<?php echo SERVERURL; ?>client-list/" class="tile">
		<div class="tile-tittle">Clientes</div>
		<div class="tile-icon">
			<i class="fas fa-users fa-fw"></i>
			<p> Registrados</p>
		</div>
	</a>
	
	<a href="<?php echo SERVERURL; ?>item-list/" class="tile">
		<div class="tile-tittle">Items</div>
		<div class="tile-icon">
			<i class="fas fa-pallet fa-fw"></i>
			<p> Registrados</p>
		</div>
	</a>

	<a href="<?php echo SERVERURL; ?>reservation-reservation/" class="tile">
		<div class="tile-tittle">Reservaciones</div>
		<div class="tile-icon">
			<i class="far fa-calendar-alt fa-fw"></i>
			<p> Registradas</p>
		</div>
	</a>

	<a href="<?php echo SERVERURL; ?>reservation-pending/" class="tile">
		<div class="tile-tittle">Prestamos</div>
		<div class="tile-icon">
			<i class="fas fa-hand-holding-usd fa-fw"></i>
			<p> Registrados</p>
		</div>
	</a>

	<a href="<?php echo SERVERURL; ?>reservation-list/" class="tile">
		<div class="tile-tittle">Finalizados</div>
		<div class="tile-icon">
			<i class="fas fa-clipboard-list fa-fw"></i>
			<p> Registrados</p>
		</div>
	</a>

	<?php 
		if( $_SESSION['privilegio_spm']==1){ 	/*-- Si el usuario es de  privilegio nivel 1 puede tener acceso a estas vistas  --*/
			require_once "./controladores/usuarioControlador.php";
			$ins_usuario = new usuarioControlador();
			$total_usuarios=$ins_usuario->datos_usuario_controlador("Conteo",0)
	?>	
	<a href="<?php echo SERVERURL; ?>user-list/" class="tile">
		<div class="tile-tittle">Usuarios</div>
		<div class="tile-icon">
			<i class="fas fa-user-secret fa-fw"></i>
			<p><?php echo $total_usuarios->rowCount() ; ?> Registrados</p>
		</div>
	</a>
	<?php }	?>
	<a href="<?php echo SERVERURL; ?>company/" class="tile">
		<div class="tile-tittle">Empresa</div>
		<div class="tile-icon">
			<i class="fas fa-store-alt fa-fw"></i>
			<p> Registrada</p>
		</div>
	</a>
</div>