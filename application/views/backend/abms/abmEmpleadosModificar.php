<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">
			
			<div class="page-header">
					<h1>
						 Gestionar Empleados
					</h1>
			</div>	

			<div class="widget-box"><!--Empieza cuadro Modificar Medicamento -->
					<div class="widget-header">
						<h5 class="widget-title">Modificar Empleado </h5>

							<!-- #section:custom/widget-box.toolbar -->
								<div class="widget-toolbar">
									<a href="#" data-action="collapse">
										<i class="ace-icon fa fa-chevron-up"></i>
									</a>		
								</div>
							<!-- /section:custom/widget-box.toolbar -->
					</div>

					<div class="widget-body">
							<div class="widget-main">
									<div class="widget-main">

										<?php 	if ($empleado){
													foreach ($empleado->result() as $emp){
        								?>

										<form class="form-horizontal" role="form" action="<?php echo base_url() ?>abms/abmEmpleadosC/actualizarDatos/<?= $emp->idEmpleado;?>" method="post"><!-- Comienza formulario Modificar -->

										  
	                                    <div class="form-group"> <!-- Empieza una linea del formulario -->
											<label class="col-sm-3 control-label no-padding-right" for="apellido">Apellidos Empleado(*) </label>

											<div class="col-sm-4">
												<input class="form-control" id="apellido" name="apellido" value="<?= $emp->apellidoE;?>"  type="text">		                        
											</div>
										</div>	                        
										
										<div class="form-group"> <!-- Empieza una linea del formulario -->
											<label class="col-sm-3 control-label no-padding-right" for="nombreE">Nombres Empleado(*) </label>

											<div class="col-sm-4">
												<input class="form-control" id="nombreE" name="nombreE" value="<?= $emp->nombreE;?>"  type="text">				                                
											</div> <!-- Cambiar lo de date picker??? -->
										</div>

										<div class="form-group"> <!-- Empieza una linea del formulario -->
											<label class="col-sm-3 control-label no-padding-right" for="nroLegajo">Nº Legajo(*) </label>
											
											<div class="col-sm-4">
												<input class="form-control" id="nroLegajo" name="nroLegajo" placeholder=""  value="<?= $emp->nroLegajo;?>" readonly type="number">
		                					</div> 
										</div>

										<div class="form-group"> <!-- Empieza una linea del formulario -->
											<label class="col-sm-3 control-label no-padding-right" for="dni">Nº Documento(*) </label>
											
											<div class="col-sm-4">
												<input class="form-control" id="dni" name="dni" placeholder=""  value="<?= $emp->dni;?>" type="number" min="1000000" max="70000000">
		                					</div> 
										</div>

										<div class="form-group"> <!-- Empieza una linea del formulario -->

											<label class="col-sm-3 control-label no-padding-right" for="telefono"> Teléfono </label>
											<div class="col-sm-4">
												<input class="form-control" id="telefono" name="telefono" placeholder="" value="<?= $emp->telefono;?>" type="tel">
		                					</div> 
										</div>

										<div class="form-group"> <!-- Empieza una linea del formulario -->
											<label class="col-sm-3 control-label no-padding-right" for="direccion"> Dirección </label>

											<div class="col-sm-4">
												<input class="form-control" id="direccion" name="direccion" value="<?= $emp->direccion;?>" placeholder=""  type="text">
		                					</div> 
										</div>

										<div class="form-group"> <!-- Empieza una linea del formulario -->
											<label class="col-sm-3 control-label no-padding-right" for="tipoEmpleado"> Tipo Empleado(*)</label>

												<div class="col-sm-4">
													<div>
														<select class="form-control" aria-controls="dynamic-table" id="tipoEmpleado" name="tipoEmpleado" value="<?= $emp->tipoEmpleado;?>">
															<?php if($emp->tipoEmpleado=="Administrador"){		
															?>
																	<option value="<?=$emp->tipoEmpleado?>"><?=$emp->tipoEmpleado;?></option>
																	<option value="Auditor">Auditor</option>
																	<option value="Administrador Base de Datos">Administrador Base de Datos</option>
																	<option value="Directivo">Directivo</option>
																	<option value="Facilitador">Facilitador</option>

															<?php	}elseif($emp->tipoEmpleado=="Auditor"){
															?>
																	<option value="<?=$emp->tipoEmpleado?>"><?=$emp->tipoEmpleado;?></option>
																	<option value="Auditor">Administrador</option>
																	<option value="Administrador Base de Datos">Administrador Base de Datos</option>
																	<option value="Directivo">Directivo</option>
																	<option value="Facilitador">Facilitador</option>

															<?php	}elseif($emp->tipoEmpleado=="Facilitador"){
															?>
																	<option value="<?=$emp->tipoEmpleado?>"><?=$emp->tipoEmpleado;?></option>
																	<option value="Auditor">Auditor</option>
																	<option value="Auditor">Administrador</option>
																	<option value="Administrador Base de Datos">Administrador Base de Datos</option>
																	<option value="Directivo">Directivo</option>

															<?php	}elseif($emp->tipoEmpleado=="Administrador Base de Datos"){
															?>
																	<option value="<?=$emp->tipoEmpleado?>"><?=$emp->tipoEmpleado;?></option>
																	<option value="Auditor">Auditor</option>
																	<option value="Auditor">Administrador</option>
																	<option value="Directivo">Directivo</option>
																	<option value="Facilitador">Facilitador</option>

															<?php	}elseif($emp->tipoEmpleado=="Directivo"){
															?>
																	<option value="<?=$emp->tipoEmpleado?>"><?=$emp->tipoEmpleado;?></option>
																	<option value="Auditor">Auditor</option>
																	<option value="Auditor">Administrador</option>
																	<option value="Administrador Base de Datos">Administrador Base de Datos</option>
																	<option value="Facilitador">Facilitador</option>

															<?php }		
															?>
														</select>
													</div>
												</div>
										</div>


										<div class="form-group"> <!-- Empieza una linea del formulario -->
											<label class="col-sm-3 control-label no-padding-right" for="convenio"> Convenio(*)</label>

												<div class="col-sm-4">
													<div>
														<select class="form-control" aria-controls="dynamic-table" id="convenio" name="convenio" value="<?= $emp->convenio;?>">
															<?php if($emp->convenio=="Planta Permanente"){		
															?>
																	<option value="<?=$emp->convenio?>"><?=$emp->convenio;?></option>
																	<option value="Contratado">Contratado</option>

															<?php	}elseif($emp->tipoEmpleado=="Contratado"){
															?>
																	<option value="<?=$emp->convenio?>"><?=$emp->convenio;?></option>
																	<option value="Planta Permanente">Planta Permanente</option>
															<?php }		
															?>
														</select>
													</div>
												</div>
										</div>


										<div class="clearfix form-actions"> <!-- Empiezan botones de modificar y limpiar -->
											<div class="col-md-offset-3 col-md-9">
												<button class="btn btn-info" type="submit" name="ActualizarEnDB">
													<i class="ace-icon fa fa-check bigger-110"></i>
													Modificar
												</button>

												&nbsp; &nbsp; &nbsp;
												<button class="btn" type="reset">
													<i class="ace-icon fa fa-undo bigger-110"></i>
													Limpiar
												</button>
											</div>
										</div>


										</form><!-- Termina formulario -->	

										<?php
													}
												}
										?>

									</div>
							</div>
					</div>
			</div><!--Termina cuadro Modificar Medicamento -->	

		</div><!-- /.page-content -->
	</div><!-- /.main-content-inner -->
</div><!-- /.main-content -->



<!--Para que se vean los botones de la tabla responsive-->

	<script type="text/javascript">
		window.jQuery || document.write("<script src='../../../assets/js/jquery.js'>"+"<"+"/script>");
	</script>


	<script type="text/javascript">
		if('ontouchstart' in document.documentElement) document.write("<script src='../../../assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
	</script>
	<script src="../../../assets/js/bootstrap.js"></script>

