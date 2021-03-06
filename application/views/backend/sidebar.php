<!-- #section:basics/navbar.dropdown -->
				<div class="navbar-buttons navbar-header pull-right" role="navigation">
				<!--Comienza MenÃº de usuario-->	
					<ul class="nav ace-nav">
						<!-- #section:basics/navbar.user_menu -->
						<li class="light-blue">

							<a data-toggle="dropdown" href="#" class="dropdown-toggle" aria-expanded="true">
								<span class="menu-text">
									<small><?php $session_data = $this->session->userdata('logged_in'); 
													echo 'Bienvenido, &nbsp'.$session_data['nombreE'];?> 
									</small>									
								</span>
								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="<?php echo base_url() ?>/login/logout">
										<i class="ace-icon fa fa-power-off"></i>
										Salir
									</a>
								</li>
							</ul>

						</li>
						<!-- /section:basics/navbar.user_menu -->
					</ul>
				</div>

		</div><!-- /.navbar-container -->
	</div>
</body>

<!FINALIZA HEADER!-->


<!COMIENZA SIDEBAR!-->

		<!-- /section:basics/navbar.layout -->
	<div class="main-container" id="main-container">

		<script type="text/javascript">
			try{ace.settings.check('main-container' , 'fixed')}catch(e){}
		</script>

			<!-- #section:basics/sidebar -->
		<div id="sidebar" class="sidebar responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

			<ul class="nav nav-list">

				<?php 
					if ($nivel){							
						foreach($nivel->result() as $niv){
      						if ($niv->descripNivel == "Administrador de Usuarios" || 
      							$niv->descripNivel == "Administrador" || 
      							$niv->descripNivel == "Referente" || 
      							$niv->descripNivel == "Coordinador"){
				?>

				<li class="">
					<a href="<?php echo base_url()?>auditoria/auditoriaC">
						<i class="menu-icon fa fa-search-plus"></i>
						<span class="menu-text">Auditoria</span>
					</a>

					<b class="arrow"></b>
				</li>

				<?php 		}
						}	
					}
				?>

				<?php 
					if ($nivel){							
						foreach($nivel->result() as $niv){
      						if ($niv->descripNivel == "Administrador de Usuarios" || 
      							$niv->descripNivel == "Facilitador" || 
      							$niv->descripNivel == "Administrador" || 
      							$niv->descripNivel == "Referente" ||  
      							$niv->descripNivel == "Coordinador"){
				?>

				<li class="">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-pencil-square-o"></i> 

							<span class="menu-text">Encuestas</span>
						<b class="arrow fa fa-angle-down"></b>
					</a>

						<b class="arrow"></b>
							<ul class="submenu">

								<?php 	if ($niv->descripNivel == "Administrador de Usuarios" || 
											$niv->descripNivel == "Facilitador" || 
											$niv->descripNivel == "Administrador" || 
											$niv->descripNivel == "Referente" || 
											$niv->descripNivel == "Coordinador"){
								?>
								<li class="">
									<a href="<?php echo base_url()?>encuesta/cargarEncuesta/">
										<i class="menu-icon fa fa-caret-right"></i>
										Cargar Relevamiento Realizado
									</a>
									<b class="arrow"></b>
								</li>
								<?php 	}	
								?>

								<?php 	if ($niv->descripNivel == "Administrador de Usuarios" || 
											$niv->descripNivel == "Administrador" ||  
											$niv->descripNivel == "Coordinador"){
								?>

								<li class="">
									<a href="#" class="btn disabled">
										<i class="menu-icon fa fa-caret-right"></i>
										Crear Encuesta
									</a>
									<b class="arrow"></b>
								</li>
								<?php 	}	
								?>

								<?php 	if ($niv->descripNivel == "Administrador de Usuarios" || 
											$niv->descripNivel == "Facilitador" || 
											$niv->descripNivel == "Administrador" || 
											$niv->descripNivel == "Referente" || 
											$niv->descripNivel == "Coordinador"){
								?>
								<li class="">
									<a  class="btn disabled" href="<?php echo base_url()?>abms/abmVisitasC/">
										<i class="menu-icon fa fa-caret-right"></i>
										Pactar Visita 
									</a>

									<b class="arrow"></b>
								</li>
								<?php 	}	
								?>

								<?php 	if ($niv->descripNivel == "Administrador de Usuarios" || 
											$niv->descripNivel == "Administrador" || 
											$niv->descripNivel == "Referente" || 
											$niv->descripNivel == "Coordinador"){
								?>
								<li class="">
									<a href="<?php echo base_url()?>encuesta/abmencuesta">
										<i class="menu-icon fa fa-caret-right"></i>
										Ver Encuestas
									</a>
									<b class="arrow"></b>
								</li>
								<?php 	}	
								?>
								<?php 	if ($niv->descripNivel == "Administrador de Usuarios" || 
											$niv->descripNivel == "Facilitador" || 
											$niv->descripNivel == "Administrador" || 
											$niv->descripNivel == "Referente" || 
											$niv->descripNivel == "Coordinador"){
								?>	
								<li class="">
									<a href="<?php echo base_url()?>relevamiento/relevamientoC">
										<i class="menu-icon fa fa-caret-right"></i>
										Ver Relevamientos
									</a>
									<b class="arrow"></b>
								</li>
								<?php 	}	
								?>									
							</ul>
				</li>

				<?php 		}
						}	
					}
				?>

				<?php 
					if ($nivel){							
						foreach($nivel->result() as $niv){
      						if ($niv->descripNivel == "Administrador de Usuarios" || 
      							$niv->descripNivel == "Administrador"){
				?>

				<li class="">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-cogs"></i> 

							<span class="menu-text">Gestiones Internas</span>

						<b class="arrow fa fa-angle-down"></b>
					</a>

						<b class="arrow"></b>
							<ul class="submenu">

								<li class="">
									<a href="<?php echo base_url()?>abms/abmEmpleadosC">
										<i class="menu-icon fa fa-caret-right"></i>
										Empleados
									</a>
									<b class="arrow"></b>
								</li>
							</ul>
				</li>

				<?php 		}
						}	
					}
				?>

				<?php 
					if ($nivel){							
						foreach($nivel->result() as $niv){
      						if ($niv->descripNivel == "Administrador de Usuarios" || 
      							$niv->descripNivel == "Facilitador" || 
      							$niv->descripNivel == "Administrador" || 
      							$niv->descripNivel == "Referente" || 
      							$niv->descripNivel == "Coordinador"){
				?>

				<li class="">
					<a href="<?php echo base_url()?>reportes/reportesC">
						<i class="menu-icon fa fa-list-alt"></i>
						<span class="menu-text"> Reportes</span>
					</a>
					<b class="arrow"></b>
				</li>

				<?php 		}
						}	
					}
				?>

				<?php 
					if ($nivel){							
						foreach($nivel->result() as $niv){
      						if ($niv->descripNivel == "Administrador de Usuarios"){
				?>
				<li class="">
					<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-user"></i>
							<span class="menu-text"> Usuarios </span>
							<b class="arrow fa fa-angle-down"></b>
					</a>

					<b class="arrow"></b>
						<ul class="submenu">

							<li class="">
								<a href="<?php echo base_url()?>seguridad/abmUsuariosC">
									<i class="menu-icon fa fa-caret-right"></i>
									Gestionar Usuarios
								</a>
								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="<?php echo base_url()?>seguridad/abmNivelesC">
									<i class="menu-icon fa fa-caret-right"></i>
									Gestionar Niveles de Seguridad
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
				</li>
				<?php 		}
						}	
					}
				?>

				<li class="">
					<a href="<?php echo base_url('bienvenidaC') ?>">
						<i class="menu-icon fa fa-reply-all"></i>
						<span class="menu-text"> Inicio</span>
					</a>
					<b class="arrow"></b>
				</li>

				<li class="">
					<a href="<?php echo base_url('login/logout') ?>">
						<i class="menu-icon fa fa-power-off"></i>
						<span class="menu-text"> Salir</span>
					</a>
					<b class="arrow"></b>
				</li>				
	
			</ul><!-- /.nav-list -->

				<!-- #section:basics/sidebar.layout.minimize -->
			<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
				<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
			</div>
				<!-- /section:basics/sidebar.layout.minimize -->
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
		</div>
	
