<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//inicio_ingenieria

if(empty($this->session->userdata('usuario')))
	redirect('inicio');

?>

<style>
@media screen and (max-width: 600px) {
    #contenedor_mapa {
		margin-top: 20px;
        height: 400px;
	}
	#contenedor_metodos {	
		margin-top: 20px;
	}
	#contenedor_parametros{
		margin-top: 20px;
	}
	#contenedor_intensidad{
		margin-top: 20px;
	}
	
	#grafica_precipitacion_año_mes{	
		width: 100%;
		
	}

	
}

</style>
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" >
        <div class="modal-body">
		<center>
          <img src="<?=base_url()?>assets/images/loader.gif" width="50%" height="50%">
		  <h1>Cargando...</h1>
		</center>
        </div>
      </div>
      
    </div>
  </div>
  
<!-- modal small -->
	<div class="modal fade" id="agregar_año_precipitacion" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" id="agregar_año_precipitacion">
			<div class="modal-content" >
				<div class="modal-header" style="background-color:#138496;">
					<center><h5 class="modal-title" id="largeModalLabel" style="color:white;" >Agregar Registro Por Año</h5></center>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<br>
				<div class="container" style="background-color:white" >
					<div class="row form-group">
					<div class="col-sm-6" >
						<label><b>Agregar Año:</b></label>
					</div>	
					<div class="col-sm-6" >
						<input id="input_año" type="date" class="form-control"  min="1900-01-01">
					</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-6" >
							<label><b>Agregar Precipitación:</b></label>
						</div>	
						<div class="col-sm-6" >
							<input id="input_precipitacion" class="form-control" type="number">
					</div>
					</div>
					<div class="row">
							<div class="col-sm-6">
								<input id="input_aceptar" class="btn boton btn-lg btn-info" value="Aceptar" type="button" style="width:100%" onclick="AgregarAño()">
							</div>	
							<div class="col-sm-6">
								<input id="input_cancelar" class="btn boton btn-lg btn-info" value="Cancelar" style="width:100%" type="button" onclick="CancelarAño()" >
							</div>
					</div>
					</div>	
			</div>
		</div>
	</div>
<!-- end modal small -->

<div class="modal fade" id="agregar_tr_años" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" id="agregar_tr_años">
			<div class="modal-content" >
				<div class="modal-header" style="background-color:#8fd400;">
					<center><h5 class="modal-title" id="largeModalLabel" style="color:white;" >Agregar Registro</h5></center>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<br>
				<div class="container" style="background-color:white" >
					<div class="row form-group">
						<div class="col-sm-6" >
							<label><b>Agregar TR:</b></label>
						</div>	
						<div class="col-sm-6" >
							<input id="input_tr_años" class="form-control" type="number">
						</div>
					</div>
					<div class="row form-group">
							<div class="col-sm-6" >
								<input id="input_tr_aceptar" class="btn boton btn-lg btn-info" value="Aceptar" type="button"  style="width:100%;background-color:#8fd400; border-color:#8fd400;" onclick="AgregarTrAños()">
							</div>	
							<div class="col-sm-6" >
								<input id="input_tr_cancelar" value="Cancelar" class="btn boton btn-lg btn-info" type="button"  style="width:100%;background-color:#8fd400; border-color:#8fd400;" onclick="CancelarTrAños()" >
							</div>
					</div>
				</div>	
			</div>
		</div>
	</div>

	
	
	<div class="modal fade" id="agregar_tr_minutos" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" id="agregar_tr_minutos">
			<div class="modal-content" >
				<div class="modal-header" style="background-color:#138496;">
					<center><h5 class="modal-title" id="largeModalLabel" style="color:white;" >Agregar Minutos</h5></center>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<br>
				<div class="container" style="background-color:white" >
					<div class="row form-group">
						<div class="col-sm-6" >
							<label><b>Agregar Minutos:</b></label>
						</div>	
						<div class="col-sm-6" >
							<input id="input_tr_minutos"  min="1" class="form-control" type="number"  onkeypress="QuitarPunto(event)">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-6" >
							<input id="input_tr_minutos_aceptar" style="background-color:#138496;width:100%;" class="btn boton btn-lg btn-info" value="Aceptar" type="button" onclick="AgregarTrMinutos()">
						</div>	
						<div class="col-sm-6" >
							<input id="input_tr_minutos_cancelar" style="background-color:#138496;width:100%;" class="btn boton btn-lg btn-info" value="Cancelar" type="button"onclick="CancelarTrMinutos()" >
						</div>
					</div>
					
				</div>	
			</div>
		</div>
	</div>
	
	
	<div class="modal fade" id="eliminar_tr_minutos" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document" id="eliminar_tr_minutos">
			<div class="modal-content" >
				<div class="modal-header" style="background-color:#138496;">
					<center><h5 class="modal-title" id="largeModalLabel" style="color:white;" >Eliminar Minutos</h5></center>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<br>
				<div class="container" style="background-color:white" >
					
					<div class="row form-group">
						<div class="col-sm-6" >
							<label><b>Eliminar Minutos:</b></label>
						</div>	
						<div class="col-sm-6" >
							<input id="input_eliminar_tr_minutos"  min="1" class="form-control" type="number"  onkeypress="QuitarPunto(event)">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-sm-6" >
							<input id="input_tr_minutos_eliminar" value="Aceptar" type="button" class="btn boton btn-lg btn-info" style="background-color:#138496;width:100%; " onclick="EliminarTrMinutos()">
						</div>	
						<div class="col-sm-6" >
							<input id="input_tr_minutos_cancelar" value="Cancelar" type="button" class="btn boton btn-lg btn-info" style="background-color:#138496;width:100%; " onclick="CancelarTrMinutos()" >
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
	

<!--<div id="pestaña_abrir" class="mapaestilo" style="display:none"><span ><b style="background-color:white;"><</b></span></div>-->
<div id="pestaña_abrir" class="mapaestilo" style="display:none">

<center><div class="container2" style="transform:rotate(90deg);">
	<div class="chevron"></div>
	<div class="chevron"></div>
</div>
</center>
</span></div>


<div id="formulario_mapa"  class="mapaestilo" style="display:none;background-color:white;">
	<form>
	<div class="row" style="width: 300px;">
		<div class="col-sm-12">
			<!--<div class="w3-panel w3-border w3-round-large">-->
			<div class="card">
				<div class="card-header" style="background-color:#005392; padding: .25rem;"><center><h4 style="color:#fff;margin-top: 5px;margin-bottom:5px;">Control de estación</h4></center></div>
				<div class="card-body card-block">
					<center><h5>Ubicación del Proyecto</h5></center>
					<div class="row form-group">
						<div class="col-sm-12"><br>
							<input type="checkbox" id="checkbox_seleccionar_ubicacion"> Seleccionar Ubicación 
						</div><br>	
					</div>
						<div class="row form-group">
							<div class="col-sm-4" >
								<br><label>Latitud:</label>
							</div>
							<div class="col-sm-8" >
								<input id="input_latitud_ubicacion" class="form-control" type="number" value="19.03622" disabled>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-4" >
								<br><label>Longitud:</label>
							</div>
							<div class="col-sm-8" >
								<input id="input_longitud_ubicacion" class="form-control" type="number" value="-98.22534" disabled>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-12" >
								<input type="checkbox" id="checkbox_area_ubicacion" checked> Dibujar Area Circundante
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-4">
								<br><label>Radio(km):</label>
							</div>
							<div class="col-sm-8" >
								<input id="input_radio_ubicacion" class="form-control" type="number" value="5" min="1">
							</div>
						</div>
						
				<!--</div> <!--Recuadro-->

				
					<center><h5>Control del Mapa</center></h5>
						<div class="row form-group">
							<div class="col-sm-12"><br>
								<div id="marcar_estaciones_por_estados" align="left" class="scrol">
									<input id="checkbox_seleccionar_todas_estaciones"  type="checkbox" > Marcar Todas<br>
								</div>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-sm-12">
								<center><input id="input_ocultar" class="btn boton btn-lg btn-info" type="button" value="Ocultar"style="width:80%;"></center>
							</div>
						</div>
				</div>
			
			</div>
		</div>
		
	</div>
	</form>
</div>





<div class="page-content--bgf7">
	   <!-- WELCOME-->
		<section class="welcome p-t-10">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						
						<hr class="line-seprate">
					</div>
				</div>
			</div>
		</section>
		<!-- END WELCOME-->
	<br><br>
			
	<section class="section__content--p30" style="background-image:url(<?=base_url()?>assets/images/servicios-de-ingenieria.jpg); background-repeat: no-repeat; background-size: 100% 100%;" >
		<br><div class="col-sm-12" align="center" >
			<h4 >Curvas IDTR</h4>	
			<br>
			</div>
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header" style="background-color:#005392; padding: .25rem;"><center><h4 style="color:#fff;margin-top: 5px;margin-bottom:5px;">Informacion de la estación</h4></center></div>
						<div class="card-body card-block">
						<div class="row">
							<div class="col-sm-3">
								
								<div class="row form-group">
									<div class="col-sm-4" >
										<br><label>	<b>Estado:</b></label>
									</div>
									<div class="col-sm-8" ><br>
										<select id="select_estados" class="form-control">
										</select>
									</div>
								</div>
								
								<div class="row form-group">
									<div class="col-sm-4" >
										<label><b>Municipio:</b></label>
									</div>
									<div class="col-sm-8" >
										<select id="select_municipios" class="form-control">
										</select>
									</div>
								</div>
								
								<div class="row form-group">
									<div class="col-sm-4" >
										<label><b>Estación:</b></label>
									</div>
									<div class="col-sm-8" >
										<select id="select_estaciones" class="form-control">
										</select>
									</div>
								</div>
								
								<div class="row form-group">
									<div class="col-sm-4" >
										<label><b>Clave:</b></label>
									</div>
									<div class="col-sm-8" >
										<select id="select_claves" class="form-control">
										</select>
									</div>
								</div>
								
								<div class="row form-group">
									<div class="col-sm-4" >
										<label><b>Estatus:</b></label>
									</div>
									<div class="col-sm-8" >
										<input id="input_estatus" class="form-control" type="text" readonly="readonly">
									</div>
								</div>	
								
								<div class="row form-group">
									<div class="col-sm-4" >
										<label><b>Número de datos:</b></label>
									</div>
									<div class="col-sm-8" >
										<input id="input_numero_de_datos" class="form-control" type="number" readonly="readonly">
									</div>
								</div>
								
								<div class="row form-group">
									<div class="col-sm-4" >
										<label><b>RH:</b></label>
									</div>
									<div class="col-sm-8" >
										<input id="input_cuenca" class="form-control" type="text" readonly="readonly">
									</div>
								</div>
								
								<div class="row form-group">
									<div class="col-sm-4" >
										<label><b>Altitud:</b></label>
									</div>
									<div class="col-sm-8" >
										<input id="input_altitud" class="form-control" type="number"readonly="readonly">
									</div>
								</div>
								
								<div class="row form-group">
									<div class="col-sm-4" >
										<label><b>Latitud:</b></label>
									</div>
									<div class="col-sm-8" >
										<input id="input_latitud" class="form-control" type="number"readonly="readonly">
									</div>
								</div>
								
								<div class="row form-group">
									<div class="col-sm-4" >
										<label><b>Longitud:</b></label>
									</div>
									<div class="col-sm-8" >
										<input id="input_longitud" class="form-control" type="number"readonly="readonly">
									</div>
								</div>
							</div>
							<div id="contenedor_mapa" class="col-sm-9"  style="padding-left: 5px;  padding-right: 0px;">
								<div class="w3-panel w3-border w3-round-large" style=" width:100%; height:100%;padding: 0px;">
									<div class="row" style="width:100%; height:100%">
										<div class="col-sm-12"  style="width:100%;"  >
											<div id="mapa" style="width:100%; height:100%;"></div>
										</div>
									</div>
								</div>
							</div><br>
						</div>
							
						</div>
					</div>
				</div>
				<br>
	</section>
	<section class="section__content--p30" style="background-image:url(<?=base_url()?>assets/images/servicios-de-ingenieria.jpg); background-repeat: no-repeat; background-size: 100% 100%;" >
	
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header" style="background-color:#005392; padding: .25rem;"><center><h4 style="color:#fff;margin-top: 5px;margin-bottom:5px;">Parametros estadísticos de las precipitaciones</h4></center></div>
						<div class="card-body card-block">
							<div class="row">
								<div class="col-sm-3">
									<div class="row form-group">		
										<!--<div class="container"><br>-->
										<div class="col-sm-12">
											<br>
											<div style="display:block;overflow-y:scroll;height:500px; overflow-x:hidden;">
												<center>
													<table  id="tabla_precipitacion"  class="table table-borderless table-striped" style="border-collapse: collapse;border-radius: 1em; overflow: hidden; ">
													</table>
												</center>	
											</div> 						
										</div>
									<!--	</div>-->
									</div>
									<div class="row">
										<div class="col-sm-6" >
											<input id="input_agregar_año" class="btn boton btn-lg btn-info" type="button" value="Agregar" onclick="agregar()">
										</div>
										<div class="col-sm-6" >
											<input id="input_eliminar_año" class="btn boton btn-lg btn-info" type="button" value="Eliminar">	
										</div>	
									</div>
								</div>
								<div id="contenedor_parametros" class="col-sm-9"><br>
									<div class="row">
										
											<div class="col row form-group">
												<div class="col-sm-6" >
													<label>Factor de Corrección:</label>
												</div>
												<div class="col-sm-6" >
													<input id="input_factor_correccion" class="form-control" type="number" value="1.13">
												</div>								
											</div>
										
								
											<div class="col row form-group">
												<div class="col-sm-6" >
													<label>Núm. de Datos:</label>
												</div>
												<div class="col-sm-6" >
													<input id="input_num_datos" class="form-control" type="number"readonly="readonly">
												</div>								
											</div>
									
										
											<div class="col row form-group">
												<div class="col-sm-6" >
													<label>P :</label>
												</div>
												<div class="col-sm-6" >
													<input id="input_promedio" class="form-control" type="number"readonly="readonly">
												</div>								
											</div>
										
									</div>
									
									<div class="row">
										<div class="col row form-group">
											<div class="col-sm-6" >
												<label>S :</label>
											</div>
											<div class="col-sm-6" >
												<input id="input_desviacion" class="form-control" type="number"readonly="readonly">
											</div>								
										</div>
									
										<div class="col row form-group">
											<div class="col-sm-6" >
												<label>Sy :</label>
											</div>
											<div class="col-sm-6" >
												<input id="input_promedio_logaritmo" class="form-control" type="number"readonly="readonly">
											</div>								
										</div>
									
										<div class="col row form-group">
											<div class="col-sm-6" >
												<label>Py :</label>
											</div>
											<div class="col-sm-6" >
												<input id="input_desviacion_logaritmo" class="form-control" type="number"readonly="readonly">
											</div>								
										</div>	
										
									</div><br>	
									<div class="row">
										<div class="col row form-group">
											<div class="col-sm-6" >
												<label>Seleccionar :</label>
											</div>
											<div class="col-sm-6" >
												<select id="select_año_mes" class="form-control">
												</select>
											</div>								
										</div>
										<div class="col row form-group">
																			
										</div>
										<div class="col row form-group">
																			
										</div>
									</div>
									<div class="row">
										<div class="col">
											<div class="row">
												<div class="col-sm-12" >
													<br><br>
													<div id="grafica_precipitacion_año_mes" class="chart_precipitacion"style="height: 350px;">grafica</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div><br>
						</div>
					</div>
				</div>
			
				<br>
	</section>
	<section class="section__content--p30" style="background-image:url(<?=base_url()?>assets/images/servicios-de-ingenieria.jpg); background-repeat: no-repeat; background-size: 100% 100%;" >
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header" style="background-color:#005392; padding: .25rem;"><center><h4 style="color:#fff;margin-top: 5px;margin-bottom:5px;">Parametros estadísticos de las precipitaciones</h4></center></div>
						<div class="card-body card-block">
							<div class="row">
								<div class="col-sm-3">
									<div class="row" id ="grafica_metodos">
										<div class="container"><br>
										<!--<div class="col-sm-12"  style=" padding-left: 5px;padding-right: 5px;" >-->
											<div class="col">
												<div class="row" >
													<div class="col-sm-12" >
														<br> <div id="grafica_error_estandar" class="chart_precipitacion" ></div>	
													</div>	
												</div>
											</div>
											<br>
												
											<div class="row form-group">
												<div class="col-sm-7">
													<input type="checkbox" id="checkbox_exponencial_b"  name="grafica_metodos" value="1" checked="true">  Exponencial con b 		
												</div>
												<div class="col-sm-5">
													<input id="input_exponencial_b"  class="form-control" type="number" readonly="readonly" style="background-color : #d1d1d1;  padding-left: 5px;padding-right: 5px;">
												</div>	
												
											</div>
										
										
											<div class="row form-group">
												<div class="col-sm-7">
													<input type="checkbox" id="checkbox_exponencial_b_x0"  name="grafica_metodos" value="2" checked="true"> Exponencial con b y x0	
												</div>
												<div class="col-sm-5" >
													<input id="input_exponencial_b_x0" class="form-control" type="number"readonly="readonly" style="background-color : #d1d1d1;  padding-left: 5px;padding-right: 5px;"  >
												</div>							
											</div>	
										
										
											<div class=" row form-group">
												<div class="col-sm-7">
													<input type="checkbox" id="checkbox_gumbel"  name="grafica_metodos" value="3" checked="true">  Gumbel	
												</div>
												<div class="col-sm-5">
													<input id="input_gumbel"  class="form-control" type="number"readonly="readonly" style="background-color : #d1d1d1;  padding-left: 5px;padding-right: 5px;">
												</div>				
											</div>	
											
											
											<div class=" row form-group">
												<div class="col-sm-7">
													<input type="checkbox" id="checkbox_nash" name="grafica_metodos" value="4" checked="true"> Nash	
												</div>
												<div class="col-sm-5">
													<input id="input_nash"  class="form-control" type="number"readonly="readonly" style="background-color : #d1d1d1;  padding-left: 5px;padding-right: 5px;">
												</div>				
											</div>	
											
											
											<div class=" row form-group">
												<div class="col-sm-7">
													<input type="checkbox" id="checkbox_normal" name="grafica_metodos" value="5" checked="true"> Normal	
												</div>
												<div class="col-sm-5">
													<input id="input_normal" class="form-control" type="number"readonly="readonly" style="background-color : #d1d1d1;  padding-left: 5px;padding-right: 5px;">
												</div>					
											</div>	
											
											
											
											<div class=" row form-group">
												<div class="col-sm-7" >
													<input type="checkbox" id="checkbox_log_normal"  name="grafica_metodos" value="6" checked="true"> Log. Normal 2
												</div>
												<div class="col-sm-5" >
													<input id="input_log_normal" class="form-control" type="number" readonly="readonly" style="background-color : #d1d1d1; padding-left: 5px;padding-right: 5px; ">
												</div>						
											</div>	
									
									
											<div class="row form-group">
												<div class="col-sm-7">
													<input type="checkbox" id="checkbox_gamma"  name="grafica_metodos" value="7" checked="true"> Gamma
												</div>
												<div class="col-sm-5">
													<input id="input_gamma" class="form-control" type="number"readonly="readonly" style="background-color : #d1d1d1;  padding-left: 5px;padding-right: 5px;">
												</div>					
											</div>	
										
											
										</div>	
									</div>
								</div>
								<div id="contenedor_parametros" class="col-sm-9"><br>
								<center><label align="center" ><b> Metodos de Ajuste</b></label></center>
										<div class="row form-group">
										
											<div class="col-sm-12" >
												<div style="display:block;overflow-y:auto;height:320px;"  > 
												<center>
													<table  id="tabla_metodos_tr"   class="table table-borderless table-striped" style="border-collapse: collapse;border-radius: 1em; overflow: hidden;">
													</table>
												</center>
												</div>
												
											</div>
										</div>
										<div class="col row form-group">
											
											<div class="col-sm-6" >
												<input id="input_agregar_tr_años" class="btn boton btn-lg btn-info" type="button"style="width:100%;" value="Agregar">
											</div>
											<div class="col-sm-6" >
													<input id="input_eliminar_tr_años" class="btn boton btn-lg btn-info" type="button"style="width:100%;" type="button" value="Eliminar">
											</div>	
											
										</div>
										
										<div class="col row form-group">
											<div class="col-sm-12" >
												<br><br>
												<div id="grafica_metodos_de_ajuste" class="chart_precipitacion" ></div>
											</div>
										</div>
								</div>
								
							</div>
							
						</div>
					</div>
				</div>
				<br>
	</section>
	<section class="section__content--p30" style="background-image:url(<?=base_url()?>assets/images/servicios-de-ingenieria.jpg); background-repeat: no-repeat; background-size: 100% 100%;" >
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header" style="background-color:#005392; padding: .25rem;"><center><h4 style="color:#fff;margin-top: 5px;margin-bottom:5px;">Parametros estadísticos de las precipitaciones</h4></center></div>
				<div class="card-body card-block">
					<div class="row">
						<div class="col-sm-3">
						<center><label align="center" ><b> Método de Ajuste </b></label></center>
						<div class="col-sm-12" >		
							
							
						
							<div class="row form-group">
								<div class="col-sm-12" >
									<select id="select_metodos_ajuste" class="form-control">									 
									</select>
								</div>
							</div>	
						
							<label align="center" ><b> Criterio de Predicción de Intensidad </b></label>
							
								<div class="row form-group">
									<div class="col-sm-12" >
										<input type="radio" id="radio_cheng_lung_chen" checked="true" name="tipo_intensidad"> Cheng-Lung Chen
									</div>
									<div class="col-sm-12">
										<input type="radio" id="radio_f_cbe" name="tipo_intensidad"> F.C Be
									</div>					
								</div>	
							
							
								<div class="row form-group">
									<div class="col-sm-12">
										<center><label align="center" ><b>Variable Regional R</b></label></center>
									</div>
								</div>	
								
								
									<div class="row form-group">
										<div class="col-sm-7">
											<input type="radio" name="variables_r" id="radio_automatica" checked> Automatica
										</div>
										<div class="col-sm-5" checked >
											<input type="number"  id="input_automatica" class="form-control" disabled="false" readonly="readonly" style="padding-left: 5px;padding-right: 5px;"> 
										</div>					
									</div>	
									<div class="row form-group">
										<div class="col-sm-7"  >
											<input type="radio" name="variables_r" id="radio_modificada"> Modificada
										</div>
										<div class="col-sm-5" >
											<input type="number" class="form-control" id="input_modificada" value="0.65" style="padding-left: 5px;padding-right: 5px;"> 
										</div>					
									</div>	
									
									<div class="row form-group">
										<div class="col-sm-12">
											<center><input type="button" class="btn boton btn-lg btn-info" id="input_recalcular"  value="Recalcular" style="width:80%"></center> 
										</div>				
									</div>
									<br>
						
							
							<center><label align="center" ><b>Variables Regionales </b></label></center>
								<div class="row form-group">
									<div class="col-sm-12">
										<center><label><b>Chen</b></label></center>
									</div>
								</div>	
									<div class=" row form-group">
									
										<div class="col-sm-4">
											<label> a: </label>
										</div>
										<div class="col-sm-8">
											<input type="text" id="input_varaiable_regional_chen_a" class="form-control" readonly="readonly" style="background-color : #d1d1d1;"  >
										</div>					
									</div>	
								
								
									<div class=" row form-group">
										<div class="col-sm-4" >
											<label> b: </label>
										</div>
										<div class="col-sm-8" >
											<input type="text" id="input_varaiable_regional_chen_b" class="form-control" readonly="readonly" style="background-color : #d1d1d1;"  >
										</div>					
									</div>	
								
								
								
									<div class=" row form-group">
										<div class="col-sm-4">
											<label> c: </label>
										</div>
										<div class="col-sm-8" >
											<input type="text" id="input_varaiable_regional_chen_c" class="form-control" readonly="readonly" style="background-color : #d1d1d1;"  >
										</div>					
									</div>	
								
								
									<div class="row form-group">
										<div class="col-sm-4">
											<label> F: </label>
										</div>
										<div class="col-sm-8" >
											<input type="text" id="input_varaiable_regional_chen_f" class="form-control" readonly="readonly" style="background-color : #d1d1d1;"  >
										</div>					
									</div>	
								
								
									<div class=" row form-group">
										<div class="col-sm-4">
											<label> P60-2: </label>
										</div>
										<div class="col-sm-8" >
											<input type="text" id="input_varaiable_regional_chen_p60_2" class="form-control" readonly="readonly" style="background-color : #d1d1d1;"   >
										</div>					
									</div>	
									
								
								<div class="row form-group">
									<div class="col-sm-12">
										<center><label><b>Bell</b></label></center>
									</div>
								</div>	
								
									<div class="row form-group">
										<div class="col-sm-4" >
											<label>P610:</label>
										</div>
										<div class="col-sm-8" >
											<input type="text" id="input_varaiable_regional_bell_p610" class="form-control" readonly="readonly" style="background-color : #d1d1d1;"  style=" padding-left: 5px;padding-right: 0px;">
										</div>					
									</div>	
									
								<!--<div class="row form-group">
									<div class="col-sm-12">
										<center><label><b>Reporte</b></label></center>
									</div>
								</div>	-->
									
									<div class="row form-group">
										<div class="col-sm-12" style=" padding-left: 12px;padding-right: 0px;">
											<center><input type="button" id="input_generar_reporte" class="btn boton btn-lg btn-info" value="Generar Reporte"style="width:80%"></center> 
										</div>					
									</div>	
									
							
						</div>
						</div>
						<div class="col-sm-9" id ="contenedor_intensidad" style="padding-left: 5px; padding-right: 0px">
			
							<div class="row form-group">
								<div class="col-sm-12" >
									<center><label align="center" ><b> Metodos de Ajuste Intensidad</b></label></center>
									 <!--style=";-->
									<center><table  id="tabla_metodo_intensidad" class="table table-borderless table-striped" style="border-collapse: collapse;border-radius: 1em; display:block;overflow-y:scroll;height:320px;width: 100% ">
									</table></center>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3" >											
										<input id="input_agregar_tr_años" class="btn boton btn-lg btn-info" style="background-color:#8fd400; border-color:#8fd400"  type="button" value="Agregar Tr">
								</div>
								<div class="col-sm-3" >
										<input id="input_eliminar_tr_años" class="btn boton btn-lg btn-info" style="background-color:#8fd400; border-color:#8fd400"  type="button" value="Eliminar Tr">
								</div>
								<div class="col-sm-3" >
										<input id="input_agregar_minutos" class="btn boton btn-lg btn-info" type="button" value="Agregar Minutos">
								</div>	
								<div class="col-sm-3" >		
									<input id="input_eliminar_minutos" class="btn boton btn-lg btn-info"  type="button" value="Eliminar Minutos">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12" >
									<br><center><label align="center"><b>Intensidad</b></label></center>
									<div id="grafica_intensidad" class="chart_precipitacion" ></div>
								</div>
							</div>
								
							<div class="row">
								<div class="col-sm-12">
								<center><label align="center" ><b> Metodos de Ajuste precipitación</b></label></center>
									<center><table  id="tabla_metodo_precipitacion" class="table table-borderless table-striped" style="border-collapse: collapse;border-radius: 1em; display:block;overflow-y:scroll;height:320px;">
									</table></center>
								</div>
							</div>	<br>
							<div class="row">
								<div class="col-sm-3" >											
										<input id="input_agregar_tr_años"  class="btn boton btn-lg btn-info" type="button" style="background-color:#8fd400;border-color:#8fd400"  value="Agregar Tr">
								</div>
								<div class="col-sm-3" >
										<input id="input_eliminar_tr_años"  class="btn boton btn-lg btn-info" type="button" style="background-color:#8fd400;border-color:#8fd400"  value="Eliminar Tr">
								</div>
								<div class="col-sm-3" >
										<input id="input_agregar_minutos_precipitacion"  class="btn boton btn-lg btn-info"  type="button" value="Agregar Minutos">
								</div>	
								<div class="col-sm-3" >		
									<input id="input_eliminar_minutos_precipitacion" class="btn boton btn-lg btn-info" type="button" value="Eliminar Minutos">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12" id="prec">
									<br><center><label align="center"><b>Precipitación</b></label></center>
									<div id="grafica_precipitacion" class="chart_precipitacion" ></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
	</section>
	
	
	
</div>

