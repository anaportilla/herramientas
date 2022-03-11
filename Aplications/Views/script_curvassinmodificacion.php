<script>
$(document).ready(function(){
	$('#myModal').modal('show');
	$.when(getData()).done(function(json){
		$('#myModal').modal('hide');
		console.log(json);
		
		estados = json.estados;
		
		select_estados = $('#select_estados');
		
		select_municipios = $('#select_municipios');
		
		select_estaciones = $('#select_estaciones');
		
		select_claves = $('#select_claves');
		
		input_estatus = $('#input_estatus');
		
		input_cuenca = $('#input_cuenca');
		
		input_altitud = $('#input_altitud');
		
		input_latitud = $('#input_latitud');
		
		input_longitud = $('#input_longitud');
		
		input_datos = $('#input_numero_de_datos');
		
		marcar_estaciones_por_estados = $('#marcar_estaciones_por_estados'); 

		input_latitud_ubicacion = $('#input_latitud_ubicacion');
		
		input_longitud_ubicacion = $('#input_longitud_ubicacion');
		
		checkbox_area_ubicacion = $('#checkbox_area_ubicacion');
		
		input_radio_ubicacion = $('#input_radio_ubicacion');
		
		checkbox_seleccionar_todas_estaciones = $('#checkbox_seleccionar_todas_estaciones');
		
		tabla_precipitacion = $('#tabla_precipitacion');
		
		select_año_mes = $('#select_año_mes');
		
		input_num_datos = $('#input_num_datos');
		
		input_factor_correccion = $('#input_factor_correccion');
		
		input_promedio = $('#input_promedio');
		
		
		select_metodos_ajuste = $('#select_metodos_ajuste');
		
		radio_automatica = $('#radio_automatica');
		
		radio_modificada = $('#radio_modificada');
		
		input_automatica = $('#input_automatica');
		
		input_modificada = $('#input_modificada');
		
		input_varaiable_regional_chen_a = $('#input_varaiable_regional_chen_a');
		
		radio_cheng_lung_chen = $('#radio_cheng_lung_chen');

		radio_f_cbe = $('#radio_f_cbe');
		
		input_agregar_año = $('#input_agregar_año');
		
		input_eliminar_año = $('#input_eliminar_año');
		
		input_aceptar = $('#input_aceptar');

		input_año = $('#input_año');

		input_precipitacion = $('#input_precipitacion');
		
		input_agregar_tr_años = $('#input_agregar_tr_años');

		input_eliminar_tr_años = $('#input_eliminar_tr_años');

		input_tr_años = $('#input_tr_años');

		input_agregar_minutos = $('#input_agregar_minutos');

		input_eliminar_minutos = $('#input_eliminar_minutos');

		input_generar_reporte = $('#input_generar_reporte');

		map = new google.maps.Map(document.getElementById("mapa"), mapOptions(estados[0].municipios[0].estaciones[0]));

		CrearControlPestaña(map);
		
		DibujarMarkerEstacion(estados[0].municipios[0].estaciones[0]);
		
		DibujarMarkerUbicacionDeProyecto();
		
		DibujarRadioUbicacionDeProyecto();

		

		for(var i=0;i<estados.length;i++){
			estados[i].seleccionado = false;
			select_estados.append('<option value="'+i+'">'+estados[i].nombre+'</option>');
			marcar_estaciones_por_estados.append('<input class="selectores_estados" type="checkbox" name="'+i+'" onchange="DibujarMarkersPorEstado(this);"> '+estados[i].nombre+'<br>'	);
			}
			
		//console.log(estados);
		
		EstablecerMunicipios(estados[0].municipios);
		
		EstablecerEstaciones(estados[0].municipios[0].estaciones);
		
		EstablecerEstacion(estados[0].municipios[0].estaciones[0]);
		
		SelectPorAños(estados[0].municipios[0].estaciones[0]);
		
		LlenarTablaAño(estados[0].municipios[0].estaciones[0],-1);
		
		LLenarArreglosMesAño(estados[0].municipios[0].estaciones[0],-1);
		 
		input_promedio.val((PromedioPrecipitacionesPorAños()).toFixed(3));
		
		input_desviacion.val((DesviacionEstandarPrecipitaciones()).toFixed(3));
		
		input_promedio_logaritmo.val((PromedioLogaritmoPrecipitaciondes()).toFixed(3));
		
		input_desviacion_logaritmo.val((DesviacionEstandarLogaritmoPrecipitaciones()).toFixed(3));
		
		PeriodoRetornoEmpirico();
		
		LLenarTablaTRMetodos();
		
		SelectMetodoAjuste();
		
		input_automatica.val(RelaciónEntreLaPrecipitacionHoras(estados[select_estados.val()].municipios[0].estaciones[0]).toFixed(3));
		
		var varibles_regionales = PrecipitacionHoras(1,radio_automatica.is(':checked'));
		

		input_varaiable_regional_chen_b.val((varibles_regionales[0][1]).toFixed(3));
 
		
		google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(GraficaPuntosPrecipitacionAños);
		
		google.charts.load('current', {packages: ['corechart', 'bar']});
		google.charts.setOnLoadCallback(GraficaBarrasErrorEstandar);
		
		google.charts.load('visualization','1', {packages: ['corechart']});
		google.charts.setOnLoadCallback(GraficaMetodosAjuste);

		
		
		 $(window).resize(function(){
			GraficaPuntosPrecipitacionAños();
			GraficaBarrasPrecipitacionMes();
			GraficaPrecipitacionBell();
			GraficaPrecipitacionChen();
			GraficaMetodosAjuste();
			GraficaIntensidadBell();
			GraficaIntensidadChen();

		});
 
		LlenarTablaIntensidadChen();
		
		LlenarTablaPrecipitacionChen();
		
		
		var arreglo_error_estandar = PeriodoRetornoEmpirico();
	
		input_exponencial_b.val(arreglo_error_estandar[0].toFixed(3));
		
		input_exponencial_b_x0.val(arreglo_error_estandar[1].toFixed(3));
		
		input_gumbel.val(arreglo_error_estandar[2].toFixed(3));
		
		input_nash.val(arreglo_error_estandar[3].toFixed(3));
		
		input_normal.val(arreglo_error_estandar[4].toFixed(3));
		
		input_log_normal.val(arreglo_error_estandar[5].toFixed(3));
		
		input_gamma.val(arreglo_error_estandar[6].toFixed(3));
	
		
		select_estados.change(function(){
			EstablecerMunicipios(estados[select_estados.val()].municipios);
			EstablecerEstaciones(estados[select_estados.val()].municipios[0].estaciones);
			EstablecerEstacion(estados[select_estados.val()].municipios[0].estaciones[0]);
			});

		select_municipios.change(function(){
			EstablecerEstaciones(estados[select_estados.val()].municipios[select_municipios.val()].estaciones);
			EstablecerEstacion(estados[select_estados.val()].municipios[select_municipios.val()].estaciones[0]);
			});
			
		select_estaciones.change(function(){
			select_claves.val(select_estaciones.val());
			EstablecerEstacion(estados[select_estados.val()].municipios[select_municipios.val()].estaciones[select_estaciones.val()]);		
			});
			
		select_claves.change(function(){
			select_estaciones.val(select_claves.val());
			EstablecerEstacion(estados[select_estados.val()].municipios[select_municipios.val()].estaciones[select_estaciones.val()]);
			});
			
		input_latitud_ubicacion.change(function(){
			map.markerUbicacionDeProyecto.setPosition( new google.maps.LatLng(parseFloat(input_latitud_ubicacion.val()), parseFloat(input_longitud_ubicacion.val()) ) );
			map.radioUbicacionDeProyecto.setCenter( new google.maps.LatLng(parseFloat(input_latitud_ubicacion.val()), parseFloat(input_longitud_ubicacion.val()) ) );
			map.panTo( new google.maps.LatLng(parseFloat(input_latitud_ubicacion.val()), parseFloat(input_longitud_ubicacion.val())));
			});
			
		input_longitud_ubicacion.change(function(){
			map.markerUbicacionDeProyecto.setPosition( new google.maps.LatLng(parseFloat(input_latitud_ubicacion.val()), parseFloat(input_longitud_ubicacion.val()) ) );
			map.radioUbicacionDeProyecto.setCenter( new google.maps.LatLng(parseFloat(input_latitud_ubicacion.val()), parseFloat(input_longitud_ubicacion.val()) ) );
			map.panTo( new google.maps.LatLng(parseFloat(input_latitud_ubicacion.val()), parseFloat(input_longitud_ubicacion.val())));
			});

		input_radio_ubicacion.change(function(){
			map.radioUbicacionDeProyecto.setCenter( new google.maps.LatLng(parseFloat(input_latitud_ubicacion.val()), parseFloat(input_longitud_ubicacion.val()) ) );
			map.radioUbicacionDeProyecto.setRadius(Math.sqrt(parseFloat(input_radio_ubicacion.val())) * 1000);
			map.panTo( new google.maps.LatLng(parseFloat(input_latitud_ubicacion.val()), parseFloat(input_longitud_ubicacion.val())));
			});
		
		checkbox_area_ubicacion.change(function(){
			map.radioUbicacionDeProyecto.setVisible(this.checked);
			});
		
		checkbox_seleccionar_todas_estaciones.change(function(){
			var checked = this.checked; 
			$('.selectores_estados').each(function(index, element){
				this.checked = checked;
				estados[index].seleccionado = checked;
				});
		
			DibujarMarkersPorEstados((checked)?estados:null);
			});
		
		select_año_mes.change(function(){	
			var estacion = estados[select_estados.val()].municipios[select_municipios.val()].estaciones[select_estaciones.val()];
			
			var indice = select_año_mes.val();
			
			LlenarTablaAño(estacion, indice);
			 
			LLenarArreglosMesAño(estacion,indice);
			 
			input_promedio.val((PromedioPrecipitacionesPorAños()).toFixed(3));
			 
			input_desviacion.val((DesviacionEstandarPrecipitaciones()).toFixed(3));
			
			input_promedio_logaritmo.val((PromedioLogaritmoPrecipitaciondes()).toFixed(3));
			
			input_desviacion_logaritmo.val((DesviacionEstandarLogaritmoPrecipitaciones()).toFixed(3));
			
			PeriodoRetornoEmpirico();
			
			LLenarTablaTRMetodos();
	
			google.charts.load('current', {packages: ['corechart', 'bar']});
			google.charts.setOnLoadCallback(GraficaBarrasErrorEstandar);
			
			google.charts.load('visualization','1', {packages: ['corechart']});
			google.charts.setOnLoadCallback(GraficaMetodosAjuste);


			 if(indice == -1)
			 {
				input_num_datos.val(TotalDeAñosHabilitados(estacion));
				
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(GraficaPuntosPrecipitacionAños);
				
			 }else{
				input_num_datos.val(TotalDeMesesHabilitados(estacion.años[indice]));
				
				google.charts.load('current', {packages: ['corechart', 'bar']});
				google.charts.setOnLoadCallback(GraficaBarrasPrecipitacionMes);
				
				
			}
			
		});
		
		select_metodos_ajuste.change(function(){
			var indice_metodo = select_metodos_ajuste.val();
			
			var variables_regionales = PrecipitacionHoras(indice_metodo,radio_automatica.is(':checked'));
			
		
			input_varaiable_regional_chen_a.val(variables_regionales[0][0]);

			input_varaiable_regional_chen_b.val(variables_regionales[0][1]);

			input_varaiable_regional_chen_c.val(variables_regionales[0][2]); 	

			input_varaiable_regional_chen_f.val(variables_regionales[0][3]);

			input_varaiable_regional_chen_p60_2.val(variables_regionales[0][4]);

			input_varaiable_regional_bell_p610.val(variables_regionales[0][5]);
			
			
			if (radio_cheng_lung_chen.is(':checked'))
			{
				LlenarTablaIntensidadChen();
				
				LlenarTablaPrecipitacionChen();
				
				GraficaIntensidadChen();

				GraficaPrecipitacionChen();
				
			}else{
				LlenarTablaIntensidadBell();
				
				LlenarTablaPrecipitacionBell();
				
				GraficaIntensidadBell();
				
				GraficaPrecipitacionBell();
			}
			
		});
		
		radio_automatica.change(function(){
			input_modificada.prop( "disabled", this.checked );
			input_automatica.prop( "disabled", !this.checked );
			});
		
		radio_modificada.change(function(){
			input_automatica.prop( "disabled", this.checked );
			input_modificada.prop( "disabled", !this.checked );
			});
		
		input_recalcular.click(function(){		
			var indice_metodo = select_metodos_ajuste.val();
			
			
			
			var variables_regionales = PrecipitacionHoras(indice_metodo,radio_automatica.is(':checked'));

			input_varaiable_regional_chen_a.val((variables_regionales[0][0]).toFixed(3));

			input_varaiable_regional_chen_b.val((variables_regionales[0][1]).toFixed(3));

			input_varaiable_regional_chen_c.val((variables_regionales[0][2]).toFixed(3)); 	

			input_varaiable_regional_chen_f.val((variables_regionales[0][3]).toFixed(3));

			input_varaiable_regional_chen_p60_2.val((variables_regionales[0][4]).toFixed(3));

			input_varaiable_regional_bell_p610.val((variables_regionales[0][5]).toFixed(3));
			
			if (radio_cheng_lung_chen.is(':checked'))
			{
				LlenarTablaIntensidadChen();
				
				LlenarTablaPrecipitacionChen();
				
				GraficaIntensidadChen();	
				
				GraficaPrecipitacionChen();
				
			}else{
				LlenarTablaIntensidadBell();
				
				LlenarTablaPrecipitacionBell();
				
				GraficaIntensidadBell();
				
				GraficaPrecipitacionBell();
			}

		});
		
		radio_f_cbe.change(function(){
			
			LlenarTablaIntensidadBell();	
			GraficaIntensidadBell();
			LlenarTablaPrecipitacionBell();
			GraficaPrecipitacionBell();
			
			
		});
		
		radio_cheng_lung_chen.change(function(){
		
			LlenarTablaIntensidadChen();
			GraficaIntensidadChen();		
			LlenarTablaPrecipitacionChen();		
			GraficaPrecipitacionChen();
		});
		
		input_agregar_año.click(function(){
			$("#agregar_año_precipitacion").modal('show');
			var indice = select_año_mes.val();

			if(indice==-1){
				input_año.prop("min", "1900-01-01");

				var fecha = new Date();

				var mes = (fecha.getMonth() + 1);

				mes = (mes<10)?"0"+mes:mes;
				
				var dia = fecha.getDate();

				dia = (dia<10)?"0"+dia:dia;

				input_año.val(fecha.getFullYear()+"-"+mes+"-"+dia);
			
				}
				
			else{
				input_año.prop("min", $(select_año_mes).find(":selected").text()+"-01-01");
				input_año.prop("max", $(select_año_mes).find(":selected").text()+"-12-31");
				input_año.val($(select_año_mes).find(":selected").text()+"-01-01");
		
				}
		
			
			input_año.focus();
			
		
			});
		
		input_eliminar_año.click(function(){
			
			var indice = select_año_mes.val();
			
			$('input:checkbox.selectores_año_precipitacion').each(function (){
				if(this.checked){
					
					var indice_de_estado = select_estados.val();
					
					var indice_de_municipio = select_municipios.val();
					
					var indice_de_estacion = select_estaciones.val();
					
					var estacion = estados[indice_de_estado].municipios[indice_de_municipio].estaciones[indice_de_estacion];
					if (indice==-1)
					{
						estacion.años[this.id].habilitado = false;
						
						input_num_datos.val(TotalDeAñosHabilitados(estacion));
	

					}
					else {
						estacion.años[indice].meses[this.id].habilitado = false;
						
						input_num_datos.val(TotalDeMesesHabilitados(estacion.años[indice]));
					}
			
		
					google.charts.load('current', {'packages':['corechart']});
					google.charts.setOnLoadCallback(GraficaPuntosPrecipitacionAños);

					google.charts.load('current', {packages: ['corechart', 'bar']});
					google.charts.setOnLoadCallback(GraficaBarrasPrecipitacionMes);
					
					google.charts.load('current', {packages: ['corechart', 'bar']});
					google.charts.setOnLoadCallback(GraficaBarrasErrorEstandar);
					
					google.charts.load('visualization','1', {packages: ['corechart']});
					google.charts.setOnLoadCallback(GraficaMetodosAjuste);
				
					EventosAñoMes();
					
					SelectPorAños(estacion);
					select_año_mes.val(indice);					
				
					}	
				});
		
			});
		
			

		input_eliminar_tr_años.click(function(){
			
			$('input:checkbox.Selectores_Error_Estandar').each(function (){
				if(this.checked){
					
					EliminarTrAños(this.id);
					
					LLenarTablaTRMetodos();

					EventosMetodosAjuste();
				} 
			});

		

			$('input:checkbox.selectores_Intensidad_de_lluvia_Bell').each(function (){
				if(this.checked){
					EliminarTrAños(this.id);
					
					LLenarTablaTRMetodos();

					EventosMetodosAjuste();
				} 
			});
			
			$('input:checkbox.selectores_Precipitacion_Bell').each(function (){
				if(this.checked){
					EliminarTrAños(this.id);
					
					LLenarTablaTRMetodos();

					EventosMetodosAjuste();
				} 
			});

				
			
		});


		input_agregar_tr_años.click(function(){
			$('#agregar_tr_años').modal('show');	
			input_tr_años.focus();
		});

		input_agregar_minutos.click(function(){
			//document.getElementById('agregar_tr_minutos').style.display='block';
			$('#agregar_tr_minutos').modal('show');	
			input_tr_minutos.focus();
		});	
	
		input_eliminar_minutos.click(function(){
		
			$('input:checkbox.selectores_Intensidad_de_lluvia_Chen').each(function (){
				//document.getElementById('eliminar_tr_minutos').style.display='block';
				$('#eliminar_tr_minutos').modal('show');	
			});	
		
			$('input:checkbox.selectores_Intensidad_de_lluvia_Bell').each(function (){
				$('#eliminar_tr_minutos').modal('show');
			});	

		});

	
		input_generar_reporte.click(function(){
		
		CrearReporte();

		});
	

		});
	});
	
</script>

<script>
var estados;

var select_estados;

var select_municipios

var select_estaciones;

var select_claves;

var input_estatus;

var input_cuenca;

var input_altitud;

var input_latitud;

var input_longitud;

var input_datos;

var marcar_estaciones_por_estados; 

var input_latitud_ubicacion;

var input_longitud_ubicacion;

var checkbox_area_ubicacion;

var input_radio_ubicacion;

var checkbox_seleccionar_todas_estaciones;

var tabla_precipitacion;

var select_año_mes;
		
var input_num_datos;

var input_factor_correccion; 

var input_promedio;

var input_desviacion;

var arreglo_factores_de_correccion = [] ;

var Lista = [];

var input_promedio_logaritmo;

var input_desviacion_logaritmo;

var ListaTr = [2,5,10,20,25,50,100,200,500,1000,2000,5000];

var ListaTrAgregando = [];

var ListaMinutos = [5,10,15,20,25,30,35,40,45,50,55,60];

var Metodos = ["Exponencial","Exponencial con b y x0","Gumbel","Nash","Normal","Log. Normal 2","Gama 2"];

var input_exponencial_b;

var input_exponencial_b_x0;

var input_gumbel;

var input_nash;

var input_normal;

var input_log_normal;

var input_gamma;

var select_metodos_ajuste;

var radio_automatica;

var radio_modificada;

var input_automatica;

var input_modificada;

var input_varaiable_regional_chen_b;

var input_recalcular;

var radio_cheng_lung_chen;

var radio_f_cbe;

var input_agregar_año;

var input_eliminar_año;

var map;

/*Informacion General*/

var input_aceptar;

var input_año;

var input_precipitacion;

var input_agregar_tr_años;

var input_eliminar_tr_años;

var input_tr_años;

var input_agregar_minutos;

var input_eliminar_minutos;

var url_image_metodo_ajuste_intensidad_bell;

var url_image_metodo_ajuste_precipitacion_bell;

function getData(){
	return $.getJSON("assets/EstacionesPorEstados.json", function(json){});

	}

function EventosMetodosAjuste(){
	var arreglo_error_estandar = PeriodoRetornoEmpirico();
					
	input_exponencial_b.val(arreglo_error_estandar[0].toFixed(3));
	
	input_exponencial_b_x0.val(arreglo_error_estandar[1].toFixed(3));
	
	input_gumbel.val(arreglo_error_estandar[2].toFixed(3));
	
	input_nash.val(arreglo_error_estandar[3].toFixed(3));
	
	input_normal.val(arreglo_error_estandar[4].toFixed(3));
	
	input_log_normal.val(arreglo_error_estandar[5].toFixed(3));
	
	input_gamma.val(arreglo_error_estandar[6].toFixed(3));
	
	var indice_metodo = select_metodos_ajuste.val();
	
	var variables_regionales = PrecipitacionHoras(indice_metodo,radio_automatica.is(':checked'));
	
	input_varaiable_regional_chen_a.val((variables_regionales[0][0]).toFixed(3));

	input_varaiable_regional_chen_b.val((variables_regionales[0][1]).toFixed(3));

	if (radio_cheng_lung_chen.is(':checked'))
	{
		LlenarTablaIntensidadChen();
		
		LlenarTablaPrecipitacionChen();
		
		GraficaIntensidadChen();	
		
		GraficaPrecipitacionChen();
		
	}else{
		LlenarTablaIntensidadBell();
		
		LlenarTablaPrecipitacionBell();
		
		GraficaIntensidadBell();
		
		GraficaPrecipitacionBell();
	}

}


function EventosAñoMes(){
	var estacion = estados[select_estados.val()].municipios[select_municipios.val()].estaciones[select_estaciones.val()];
			
			var indice = select_año_mes.val();
			
			LlenarTablaAño(estacion, indice);
			 
			LLenarArreglosMesAño(estacion,indice);
			 
			input_promedio.val((PromedioPrecipitacionesPorAños()).toFixed(3));
			 
			input_desviacion.val((DesviacionEstandarPrecipitaciones()).toFixed(3));
			
			input_promedio_logaritmo.val((PromedioLogaritmoPrecipitaciondes()).toFixed(3));
			
			input_desviacion_logaritmo.val((DesviacionEstandarLogaritmoPrecipitaciones()).toFixed(3));
			
			PeriodoRetornoEmpirico();
			
			LLenarTablaTRMetodos();

			var arreglo_error_estandar = PeriodoRetornoEmpirico();
			
			google.charts.load('current', {packages: ['corechart', 'bar']});
			google.charts.setOnLoadCallback(GraficaBarrasErrorEstandar);
			
			google.charts.load('visualization','1', {packages: ['corechart']});
			google.charts.setOnLoadCallback(GraficaMetodosAjuste);
			
			var indice_metodo = select_metodos_ajuste.val();


			var variables_regionales = PrecipitacionHoras(indice_metodo,radio_automatica.is(':checked'));

			if (radio_cheng_lung_chen.is(':checked'))
			{
				LlenarTablaIntensidadChen();
				
				LlenarTablaPrecipitacionChen();
				
				GraficaIntensidadChen();	
				
				GraficaPrecipitacionChen();
				
			}else{
				LlenarTablaIntensidadBell();
				
				LlenarTablaPrecipitacionBell();
				
				GraficaIntensidadBell();
				
				GraficaPrecipitacionBell();
			}

			 if(indice == -1)
			 {
				input_num_datos.val(TotalDeAñosHabilitados(estacion));
				
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(GraficaPuntosPrecipitacionAños);
				
			 }else{
				input_num_datos.val(TotalDeMesesHabilitados(estacion.años[indice]));
				
				google.charts.load('current', {packages: ['corechart', 'bar']});
				google.charts.setOnLoadCallback(GraficaBarrasPrecipitacionMes);
				
			}


}
 

function AgregarAño(){
	
	var año = input_año.val();

	año = año.split("-");
	
	var mes = año[1];

	var dia = año[2];

	año = año[0];

	var precipitacion = parseFloat(input_precipitacion.val());

	var indice_de_estado = select_estados.val();

	var indice_de_municipio = select_municipios.val();

	var indice_de_estacion = select_estaciones.val();

	var estacion = estados[indice_de_estado].municipios[indice_de_municipio].estaciones[indice_de_estacion];

	var años = estacion.años;

	var indice = select_año_mes.val();


		var existe = false;
		var existe_mes = false;

		for (var i=0;i<años.length;i++){
			
			if (años[i].año==año){

				if (años[i].precipitacion<precipitacion)
					años[i].precipitacion=precipitacion;

				var meses = años[i].meses;

				for (var j=0;j<meses.length;j++){
					
					if(meses[j].mes==mes){
						
						if(meses[j].precipitacion<precipitacion){
							meses[j].dia = dia;
							meses[j].precipitacion=precipitacion;
						}

						existe_mes=true;
						break;
					}
				
				}
				
				if (!existe_mes){
					meses.push({habilitado: true, mes: mes, dia: dia, precipitacion: precipitacion});
					meses.sort(function(a, b){
						return parseInt(a.mes) - parseInt(b.mes);
					});
				}
				existe = true;
				
				break;
			}
		
		}

		if (!existe){
			años.push({habilitado: true, año: año, precipitacion: precipitacion, meses: [{habilitado: true, mes: mes, dia: dia, precipitacion: precipitacion}]});
			años.sort(function(a,b){
				return parseInt(a.año) - parseInt(b.año);
			});
		}
			
	SelectPorAños(estacion);
	select_año_mes.val(indice);
	
	EventosAñoMes();

	

	input_año.val("");
	
	input_precipitacion.val("");
	$("#agregar_año_precipitacion").modal('hide');
	
	
	}

function TotalDeAñosHabilitados(estacion) {
var total=0;

	for(var i=0;i<estacion.años.length;i++){
		if (estacion.años[i].habilitado)
			total+=1;
	} 
	return total;
  }
  
function EstablecerMunicipios(municipios){
	var opciones="";
 	for(var i=0;i<municipios.length;i++){
		opciones+='<option value="'+i+'">'+municipios[i].nombre+'</option>';
		}
	select_municipios.html(opciones);
	}


function EstablecerEstacion(estacion){
	input_estatus.val(estacion.estatus);
		
	input_cuenca.val(estacion.cuenca);
		
	input_altitud.val(estacion.altitud);
		
	input_latitud.val(estacion.latitud);
		
	input_longitud.val(estacion.longitud);
	
	input_datos.val(estacion.numero_de_datos_por_estacion);
	
	DibujarMarkerEstacion(estacion);
	
	LlenarTablaAño(estacion,-1);
	
	LLenarArreglosMesAño(estacion,-1);
	
	input_promedio.val((PromedioPrecipitacionesPorAños()).toFixed(3));
	
	input_desviacion.val((DesviacionEstandarPrecipitaciones()).toFixed(3));
	
	LLenarTablaTRMetodos();
	
	PeriodoRetornoEmpirico();

	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(GraficaPuntosPrecipitacionAños);
	
	google.charts.load('visualization','1', {packages: ['corechart']});
	google.charts.setOnLoadCallback(GraficaMetodosAjuste);	
		
	input_num_datos.val(TotalDeAñosHabilitados(estacion));	
	
	SelectPorAños(estacion);

	SelectMetodoAjuste();

	RelaciónEntreLaPrecipitacionHoras(estacion);

	input_automatica.val(RelaciónEntreLaPrecipitacionHoras(estacion).toFixed(3));
	
	var varibles_regionales = PrecipitacionHoras(1,radio_automatica.is(':checked'));
		
	input_varaiable_regional_chen_a.val((varibles_regionales[0][0]).toFixed(3));

	input_varaiable_regional_chen_b.val((varibles_regionales[0][1]).toFixed(3));

	input_varaiable_regional_chen_c.val((varibles_regionales[0][2]).toFixed(3)); 	

	input_varaiable_regional_chen_f.val((varibles_regionales[0][3]).toFixed(3));

	input_varaiable_regional_chen_p60_2.val((varibles_regionales[0][4]).toFixed(3));

	input_varaiable_regional_bell_p610.val((varibles_regionales[0][5]).toFixed(3)); 
		
		
	google.charts.load('visualization','1', {packages: ['corechart']});
	google.charts.setOnLoadCallback(GraficaIntensidadChen);
	
	google.charts.load('visualization','1', {packages: ['corechart']});
	google.charts.setOnLoadCallback(GraficaPrecipitacionChen);
	
	
	var arreglo_error_estandar = PeriodoRetornoEmpirico();
	
	input_exponencial_b.val(arreglo_error_estandar[0].toFixed(3));
	
	input_exponencial_b_x0.val(arreglo_error_estandar[1].toFixed(3));
	
	input_gumbel.val(arreglo_error_estandar[2].toFixed(3));
	
	input_nash.val(arreglo_error_estandar[3].toFixed(3));
	
	input_normal.val(arreglo_error_estandar[4].toFixed(3));
	
	input_log_normal.val(arreglo_error_estandar[5].toFixed(3));
	
	input_gamma.val(arreglo_error_estandar[6].toFixed(3));
	
	}
	
function CrearControlPestaña(map){
	var contenedor_pestaña = document.createElement('div');
	
	var control_pestaña = document.createElement('div');
	control_pestaña.title = 'Mostrar Características';
	
	var pestaña_abrir = document.getElementById('pestaña_abrir');
	pestaña_abrir.style.display = 'block';
	
	control_pestaña.appendChild(pestaña_abrir);
		
	contenedor_pestaña.appendChild(control_pestaña);
	
	var contenedor_caracteristicas = document.createElement('div');
	contenedor_caracteristicas.style.display = 'none';
	
	var control_caracteristicas = document.createElement('div');
	
	var caracteristicas = document.getElementById('formulario_mapa');
	caracteristicas.style.display = 'block';
	
	var input_ocultar = document.getElementById('input_ocultar');
	
	var checkbox_seleccionar_ubicacion = document.getElementById('checkbox_seleccionar_ubicacion');
	
	var latitud_ubicacion = document.getElementById('input_latitud_ubicacion');
	
	var longitud_ubicacion = document.getElementById('input_longitud_ubicacion');
	
	var checkbox_area_ubicacion = document.getElementById('checkbox_area_ubicacion');
	
	var radio_ubicacion = document.getElementById('input_radio_ubicacion');
	
	control_caracteristicas.appendChild(caracteristicas);
	
	contenedor_caracteristicas.appendChild(control_caracteristicas);
	
	contenedor_pestaña.addEventListener('click',function(){
		contenedor_pestaña.style.display = (contenedor_pestaña.style.display == 'none') ? 'block' : 'none';
		
		contenedor_caracteristicas.style.display = (contenedor_caracteristicas.style.display == 'none') ? 'block' : 'none';
		
		});
	
	input_ocultar.addEventListener('click',function(){
		contenedor_pestaña.style.display = (contenedor_pestaña.style.display == 'none') ? 'block' : 'none';
		
		contenedor_caracteristicas.style.display = (contenedor_caracteristicas.style.display == 'none') ? 'block' : 'none';
		
		});
		
		checkbox_seleccionar_ubicacion.addEventListener('click',function(){
				latitud_ubicacion.disabled = !checkbox_seleccionar_ubicacion.checked; 
				longitud_ubicacion.disabled = !checkbox_seleccionar_ubicacion.checked;
				map.markerUbicacionDeProyecto.setDraggable(checkbox_seleccionar_ubicacion.checked);
		});
		
		checkbox_area_ubicacion.addEventListener('click',function(){
				input_radio_ubicacion.disabled = !checkbox_area_ubicacion.checked; 	
		});
		
	contenedor_pestaña.index = 1;
	map.controls[google.maps.ControlPosition.RIGHT_CENTER].push(contenedor_pestaña);
	
	contenedor_caracteristicas.index = 1;
	map.controls[google.maps.ControlPosition.RIGHT].push(contenedor_caracteristicas);
	}

function mapOptions(estacion){
	return mapOptions = {
		center: new google.maps.LatLng(23.6218631,-99.3730956),
		zoom: 5,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		
	}
	
}


function DibujarMarkersPorEstados(estados){

if (map.markers == null)
	map.markers = [];

for (var i = 0; i < map.markers.length; i++ ) {
    map.markers[i].setMap(null);
  }
 map.markers.length = 0;
 
 if(estados==null)
	return;
	
		for (var i=0;i<estados.length;i++)
		{
			var estado = estados[i];
		
			for (var j=0;j<estado.municipios.length;j++)
			{
			
				var municipio = estado.municipios[j];
				
				for(var k=0;k<municipio.estaciones.length;k++)
				{
					var est = municipio.estaciones[k];

				map.markers.push(new google.maps.Marker({
				  map: map,
				  draggable: false,
				  animation: google.maps.Animation.DROP,
				  //icon:image,
				  position: {lat:  est.latitud , lng:  est.longitud }
				  }));
					
				}
			}
		}
	
}

function DibujarMarkerEstacion(estacion){
	if (map.MarkerEstacion != null)
		map.MarkerEstacion.setMap(null);

	map.MarkerEstacion = new google.maps.Marker({
		map: map,
		draggable: false,
		animation: google.maps.Animation.DROP,
		position: {lat:  estacion.latitud , lng:  estacion.longitud},
	 });
	 
	 var ventanaTexto = new google.maps.InfoWindow({
    content: '<b>Clave: </b>'+estacion.id+'<br><b> Nombre: </b>'+estacion.nombre
	});
  	map.MarkerEstacion.addListener('click', function(){
          ventanaTexto.open(map, map.MarkerEstacion);
	});
}


function DibujarRadioUbicacionDeProyecto(){
	map.radioUbicacionDeProyecto =  new google.maps.Circle({
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35,
      map: map,
	  center: {lat: parseFloat(input_latitud_ubicacion.val()), lng: parseFloat(input_longitud_ubicacion.val())},
      radius: Math.sqrt(parseFloat(input_radio_ubicacion.val())) * 1000
    });
}

function LlenarTablaAño(estacion,indice){
var Tabla  = document.getElementById("tabla_precipitacion");
	Tabla.innerHTML = "";
	
	
	var row = Tabla.insertRow(0);
	row.style.backgroundColor="#049ab8";
	row.style.color="white";
	row.style.textAlign="center";
	row.style.fontSize="14px";
	var checkbox = row.insertCell(0);
	var fecha = row.insertCell(1);
	var precipitacion = row.insertCell(2);
	
	fecha.innerHTML = "Fecha";
	precipitacion.innerHTML = "Precipitación";
	checkbox.innerHTML = " ";
	

	
	if (indice == -1)
	{
	for(var i = 0; i < estacion.años.length; i++){
		
			if(estacion.años[i].habilitado)
			{
				var tr = Tabla.insertRow();
				var check = document.createElement("input");
				check.type="checkbox";
				check.className="selectores_año_precipitacion";
				check.id = i;
				tr.insertCell().appendChild(check);
				tr.insertCell().appendChild(document.createTextNode(estacion.años[i].año));
				tr.insertCell().appendChild(document.createTextNode(estacion.años[i].precipitacion));
			}
		}
	}
	else {
		for(var indexmes in estacion.años[indice].meses) {
					
				if(estacion.años[indice].meses[indexmes].habilitado)
				{
				
					var tr = Tabla.insertRow();
					var check = document.createElement("input");
					check.type="checkbox";
					check.className="selectores_año_precipitacion";
					check.id = indexmes;
					tr.insertCell().appendChild(check);
					tr.insertCell().appendChild(document.createTextNode(estacion.años[indice].año+"/"+estacion.años[indice].meses[indexmes].mes+"/"+estacion.años[indice].meses[indexmes].dia));
					tr.insertCell().appendChild(document.createTextNode(estacion.años[indice].meses[indexmes].precipitacion));
				}
		}
	}
}

function SelectPorAños(estacion){
	select_año_mes.html("");

	var seleccion = '<option value="-1">Todos los años</option>';
	
 	for(var i=0;i<estacion.años.length;i++){
		if (estacion.años[i].habilitado)
			seleccion+='<option value="'+i+'">'+estacion.años[i].año+'</option>';
	}
	select_año_mes.html(seleccion);
}

function LLenarArreglosMesAño(estacion,indice){
	arreglo_factores_de_correccion = [];
	Lista = [];
	if (indice == -1)
	{
		for(var i = 0; i < estacion.años.length; i++){
			if(estacion.años[i].habilitado)
			{
				arreglo_factores_de_correccion.push(estacion.años[i].precipitacion * input_factor_correccion.val());
				Lista.push([estacion.años[i].año,estacion.años[i].precipitacion]);
			}
		}
		
	}else{
		for(var indexmes in estacion.años[indice].meses) {
			if(estacion.años[indice].meses[indexmes].habilitado)
			{
				arreglo_factores_de_correccion.push(estacion.años[indice].meses[indexmes].precipitacion * input_factor_correccion.val());		
				Lista.push([estacion.años[indice].meses[indexmes].mes,estacion.años[indice].meses[indexmes].precipitacion]);
			}
		}
	}
}





function SelectMetodoAjuste(){
var seleccion="";
 	for(var i=0;i<Metodos.length;i++){
		seleccion+='<option value="'+(i+1)+'">'+Metodos[i]+'</option>';
		}
	select_metodos_ajuste.html(seleccion);
}

/*Grafica */
function GraficaMetodosAjuste() {	
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Item');
    data.addColumn('number', 'Exponencial');
    data.addColumn('number', 'Exponencial con b0');
    data.addColumn('number', 'Gumbel');
    data.addColumn('number', 'Nash');
    data.addColumn('number', 'Normal');
    data.addColumn('number', 'Log. Normal 2');
    data.addColumn('number', 'Gama 2');
	
	data.addRows(LLenarTablaTRMetodos());
    
    var view = new google.visualization.DataView(data);

    var seriesColors = ['blue', 'red', 'orange','green','yellow','pink','purple'];
       
    var chart = new google.visualization.LineChart($('#grafica_metodos_de_ajuste')[0]);
    chart.draw(view, {
        strictFirstColumnType: true,
        colors: seriesColors
    });

    $('#grafica_metodos').find(':checkbox').change(function (event) {
		var checkbox = $(this);
		var checked = false;

		$('#grafica_metodos').find(':checkbox').each(function(){
			if($(this).is(':checked'))
				checked = true;
			});

		if(!checked){
			checkbox.prop('checked', true);
			return;
		}

        var cols = [0];
        var colors = [];
	
        $('#grafica_metodos').find(':checkbox:checked').each(function () {
            var value = parseInt($(this).attr('value'));
            cols.push(value);
            colors.push(seriesColors[value - 1]);
        });
	        view.setColumns(cols);
        
        chart.draw(view, {
            strictFirstColumnType: true,
            colors: colors
        });
    });
    
	url_image_metodo_ajuste =  chart.getImageURI();
   
     
}
	
function LLenarTablaTRMetodos(){
arreglo_factores_de_correccion.sort(function(a, b){return a - b});
arreglo_factores_de_correccion.reverse();

var arreglo_tabla_metodos_de_ajuste = [];

var Tabla  = document.getElementById("tabla_metodos_tr");
	
	Tabla.innerHTML = "";
	
	var row = Tabla.insertRow(0);
	row.style.background="#049ab8";
	row.style.color="white";
	row.style.textAlign="center";
	row.style.fontSize="14px";
	var checkbox = row.insertCell(0);
	var tr_años = row.insertCell(1);
	var exponencial = row.insertCell(2);
	var exponencial_x0 = row.insertCell(3);
	var gumbel = row.insertCell(4);
	var nash = row.insertCell(5);
	var normal = row.insertCell(6);
	var log_normal = row.insertCell(7);
	var gama2 = row.insertCell(8);

	checkbox.innerHTML = " ";
	tr_años.innerHTML = "TR (Años)";
	exponencial.innerHTML = "Exponencial";
	exponencial_x0.innerHTML = "Exponencial con b y x0";
	gumbel.innerHTML = "Gumbel";
	nash.innerHTML = "Nash";
	normal.innerHTML = "Normal";
	log_normal.innerHTML = "Log. Normal 2";
	gama2.innerHTML = "Gama 2";
	

	var Fp;
	var P = parseFloat(input_promedio.val());
	var beta = 1/P;
	
	var PY = parseFloat(input_desviacion_logaritmo.val());
	var Sy = parseFloat(input_promedio_logaritmo.val());
	
	var S = parseFloat(input_desviacion.val());
	var x0 = P-S;
	
	var u_hat_gumbel = P-0.45*S;
	var alfa_hat_gumbel = 0.78*S;
	
	var sumatoriaxi_nash = 0;
	var sumatoriaxi_elevacion_nash = 0;
	var sumatoriayi_nash = 0;
	var sumatoriayi_elevacion_nash = 0;
	var sumatoria_xi_yi =0;
	
	var b0 = 2.515517;
	var b1 = 0.802853;
	var b2 = 0.010328;
	var b3 = 1.432788;
	var b4 = 0.189269;
	var b5 = 0.001308;
	var v1 = 0;
	
	for (var i=0;i<arreglo_factores_de_correccion.length;i++)
	{
		var periodo_de_retorno = (arreglo_factores_de_correccion.length+1)/(i+1);
		var funcion_de_distribucion_acumulada_precipitaciones = (periodo_de_retorno-1)/periodo_de_retorno;
		var x_nash = (Math.log(Math.log(1/funcion_de_distribucion_acumulada_precipitaciones)))*(-1);
		var x_nash_elevacion = x_nash *x_nash;
		var yi_elevacion = arreglo_factores_de_correccion[i] * arreglo_factores_de_correccion[i];
		var xi_por_yi = x_nash * arreglo_factores_de_correccion[i];


		var sumatoriaxi_nash = sumatoriaxi_nash + x_nash; //xi
		var sumatoriaxi_elevacion_nash = sumatoriaxi_elevacion_nash + x_nash_elevacion;//xi2
		var sumatoriayi_nash = sumatoriayi_nash + arreglo_factores_de_correccion[i];//yi
		var sumatoriayi_elevacion_nash = sumatoriayi_elevacion_nash + yi_elevacion;//yi2
		var sumatoria_xi_yi = sumatoria_xi_yi +  xi_por_yi;
	}
 	
	var alfa_pendiente = ((arreglo_factores_de_correccion.length * sumatoria_xi_yi)-(sumatoriaxi_nash * sumatoriayi_nash))/((arreglo_factores_de_correccion.length * sumatoriaxi_elevacion_nash)-(sumatoriaxi_nash * sumatoriaxi_nash));
	var u_interseccion = (sumatoriayi_nash - ( alfa_pendiente * sumatoriaxi_nash ))/(arreglo_factores_de_correccion.length);
	
	

	for (var i=0;i<ListaTr.length;i++)
	{
		var tr = Tabla.insertRow();
		var check = document.createElement("input");
		
		Fp = (ListaTr[i]-1)/(ListaTr[i]);
		var Ptr_24_Exponencial = ((1/beta)*(Math.log(1-Fp)))*(-1);
		var Ptr_24_Exponencial_x0 =  x0-S*Math.log(1-Fp);
		var Ptr_24_Gumbel = u_hat_gumbel-alfa_hat_gumbel*(Math.log(Math.log(1/Fp)));
		var X_Nash = (Math.log(Math.log(1/Fp)))*(-1);
		var Ptr_24_X_Nash = u_interseccion + alfa_pendiente * X_Nash;//64.41
		var V_Normal = Math.pow((Math.log(Math.pow((1/(1-Fp)),2))),0.5);
		var Ut_Normal = V_Normal-((b0 + b1 * V_Normal + b2 * (Math.pow(V_Normal,2)))/(1 + b3 * V_Normal + b4 *(Math.pow(V_Normal,2)) + b5 * Math.pow(V_Normal,3)));
		var Ptr_24_Normal = P + (Ut_Normal  * S );
		var Ptr_24_Log_Normal = Math.exp(Sy + (PY * Ut_Normal));
		var alfa_hat_gamma = Math.pow(S,2)/P;
		var beta_hat_gamma = Math.pow((P/S),2);
		var Ptr_24_gamma = alfa_hat_gamma * beta_hat_gamma * Math.pow(((1-1/(9*beta_hat_gamma)+Ut_Normal * Math.sqrt((1/(9*beta_hat_gamma))))),3);

		
		//console.log(" V "+V_Normal+" - "+(b0 + b1 * V_Normal + b2 * (Math.pow(V_Normal,2)))+" / "+(1 + b3 * V_Normal + b4 *(Math.pow(V_Normal,2)) + b5 * Math.pow(V_Normal,3)));
		
		check.type="checkbox";
		check.className="Selectores_Error_Estandar";
		check.id = i;

		if (ListaTr[i] == 2 || ListaTr[i] == 10)
			check.disabled = true;
		
		tr.insertCell().appendChild(check);
		tr.insertCell().appendChild(document.createTextNode(ListaTr[i]));
		tr.insertCell().appendChild(document.createTextNode(Ptr_24_Exponencial.toFixed(3)));
		tr.insertCell().appendChild(document.createTextNode(Ptr_24_Exponencial_x0.toFixed(3)));
		tr.insertCell().appendChild(document.createTextNode(Ptr_24_Gumbel.toFixed(3)));
		tr.insertCell().appendChild(document.createTextNode(Ptr_24_X_Nash.toFixed(3)));
		tr.insertCell().appendChild(document.createTextNode(Ptr_24_Normal.toFixed(3)));
		tr.insertCell().appendChild(document.createTextNode(Ptr_24_Log_Normal.toFixed(3)));
		tr.insertCell().appendChild(document.createTextNode(Ptr_24_gamma.toFixed(3)));

		arreglo_tabla_metodos_de_ajuste.push([ListaTr[i],parseFloat(Ptr_24_Exponencial.toFixed(3)),parseFloat(Ptr_24_Exponencial_x0.toFixed(3)),parseFloat(Ptr_24_Gumbel.toFixed(3)),parseFloat(Ptr_24_X_Nash.toFixed(3)),parseFloat(Ptr_24_Normal.toFixed(3)),parseFloat(Ptr_24_Log_Normal.toFixed(3)),parseFloat(Ptr_24_gamma.toFixed(3))]);
		//console.log(Ptr_24_Exponencial+","+Ptr_24_Exponencial_x0 + " , "+Ptr_24_Gumbel+" , "+Ptr_24_X_Nash+" , "+Ptr_24_Normal+" , "+Ptr_24_Log_Normal+" , "+Ptr_24_gamma);
	}
	//console.log(arreglo_tabla_metodos_de_ajuste);
	
	

	return arreglo_tabla_metodos_de_ajuste;
}

function EliminarTrAños(num){
	for (var i=0;i<ListaTr.length;i++){
		if (ListaTr[i]==ListaTr[num]){
			ListaTr.splice(i,1);
		}
	}		
	//console.log(ListaTr.length);	
}


function transposeArray(array){
    var newArray = [];
    for(var i = 0; i < array.length; i++){
        newArray.push([]);
    };

    for(var i = 0; i < array.length; i++){
        for(var j = 0; j < array.length; j++){
            newArray[j].push(array[i][j]);
        };
    };

    return newArray;
}


function CrearReporte(){
	var pdf = new jsPDF('p', 'pt');
	var indice_de_estado = select_estados.val();

	var indice_de_municipio = select_municipios.val();

	var indice_de_estacion = select_estaciones.val();

	var estacion = estados[indice_de_estado].municipios[indice_de_municipio].estaciones[indice_de_estacion];
	/* x, y*/
	pdf.text(20,40,"Procedimiento para construir curvas I-D-Tr con registros pluviométricos");
	
	pdf.text(20,60,"Información de la estación:")
	var columns = ["", ""];
		var data = [
		["Estado:", ""+estados[indice_de_estado].nombre],
		["Municipio/Delegación:", ""+estados[indice_de_estado].municipios[indice_de_municipio].nombre],
		["Estación:", ""+estacion.nombre],
		["Clave Estación:", ""+estacion.id]
		];
		
		pdf.autoTable(columns,data,
		{ margin:{ top: 80},
		tableWidth: 250
		}
		);
		

	var header = function(data) {
		pdf.setFontSize(18);
		pdf.setTextColor(40);
		pdf.setFontStyle('normal');
		//pdf.text("Información de la estación:", data.settings.margin.left, 50);
  	};

  	var options = {
		//beforePageContent: header,
		margin: {
		top: 80, right: 20, bottom: 20, left: 300 
		},
		//startY: pdf.autoTableEndPosY()+20,
		tableWidth: 250
 	 };

	
	var columns = ["",""];
	var data = [
	["Estatus:", ""+estacion.estatus],
	["RH:", ""+estacion.cuenca],
	["Latitud:", ""+estacion.latitud],
	["Longitud:", ""+estacion.longitud],
	["Altura:", ""+estacion.altitud]
	];
	
	pdf.autoTable(columns, data, options);
	
	/* Año precipitacion*/
	var options = {
		startY: pdf.autoTableEndPosY() + 50,
		tableWidth:150
		
 	 };

	pdf.text(20,240,"Datos de la estación");
	
	//console.log("D "+pdf.autoTableEndPosY() + 50);
	var res = pdf.autoTableHtmlToJson(document.getElementById("tabla_precipitacion"));

	if (input_num_datos.val()>12)
	{
		if (select_año_mes.val()==-1){
			pdf.addImage(url_image_años, 'PNG', 200, 300, 400, 200);
		}
		else{
			pdf.addImage(url_image_meses, 'PNG', 200, 300, 400, 200);
		}
	
		
	//	console.log("Valor  "+pdf.autoTableEndPosY());

		pdf.autoTable(res.columns, res.data, options);

		/* Parametros estadisticos*/	

		pdf.addPage();
		
			var options = {
			margin: {
			top: 40, right: 20, bottom: 20, left: 200
			},
			//startY: pdf.autoTableEndPosY() + 40,
			tableWidth:250
		};
		//console.log(" "+(pdf.autoTableEndPosY() + 200));
		pdf.text(250, 30,"Datos Paramétricos");

		//console.log(" "+(pdf.autoTableEndPosY() + 180));
		
		var columns = ["",""];
		var data = [
		["Número de datos:", ""+input_num_datos.val()],
		["Media de las precipitaciones:	", ""+input_promedio.val()],
		["Desv. Est. de las precipitaciones:", ""+input_desviacion.val()],
		["Media de los log. de las precipitaciones:	", ""+input_promedio_logaritmo.val()],
		["Desv. Est de los log. de las precipitaciones:", " Pendiente "]
		];
		
		pdf.autoTable(columns, data, options);

		/* Error Estandar*/
		
		var options = {
			margin: {
			top: 80, right: 20, bottom: 20, left: 30 
			},
			startY:pdf.autoTableEndPosY() + 80,
			tableWidth:250
		};
		
		
	
		var columns = ["Método","Error Estandar"];
		var data = [
		["Exponencial con b y x0:", ""+input_exponencial_b.val()],
		["Nash:	", ""+input_exponencial_b_x0.val()],
		["Log Normal 2:", ""+input_log_normal.val()],
		["Gumbel:	", ""+input_gumbel.val()],
		["Gamma 2:", ""+input_gamma.val()],
		["Normal:", ""+input_normal.val()],
		["Exponencial con b:", ""+input_exponencial_b.val()]
		];
		pdf.addImage(url_image_error_estandar, 'PNG', 300,  pdf.autoTableEndPosY()+80 , 250, 200);//x,y,ancho,alto	
		pdf.autoTable(columns, data, options);
		pdf.text(30,pdf.autoTableEndPosY()-190,"Error Estandar")
		
		
		
		/*Metodo de Ajuste*/
		pdf.addPage();
		var options = {
			margin: {
			top: 40, right: 20, bottom: 20, left: 20 
			},
			//startY: pdf.autoTableEndPosY() + 310,
			//tableWidth:500
			
		};
		
		pdf.text(200, 30,"Métodos de ajuste");
		var res = pdf.autoTableHtmlToJson(document.getElementById("tabla_metodos_tr"));
		pdf.autoTable(res.columns, res.data, options);
	
	

		/*Informacion de la Estación tablas*/
		var options = {
			margin: {
			top: 40, right: 20, bottom: 20, left: 20 
			},
			startY: pdf.autoTableEndPosY() + 250,
			tableWidth:180
			
		};
		
		pdf.addImage(url_image_metodo_ajuste, 'PNG', 20, pdf.autoTableEndPosY() + 20, 500, 200);	
		var posicion =  pdf.autoTableEndPosY() + 250;

		var columns = ["Información","Estación"];
		var data = [
		["Estado:", ""+estados[indice_de_estado].nombre],
		["Municipio:", ""+estados[indice_de_estado].municipios[indice_de_municipio].nombre],
		["Estación:", ""+estacion.nombre],
		["Clave:", ""+estacion.id],
		["Estatus:", ""+estacion.estatus],
		["No. De datos:", ""+input_num_datos.val()]
		];
		pdf.autoTable(columns, data, options);
		
		var options = {
			margin: {
			top: 40, right: 20, bottom: 20, left: 210 
			},
			startY: posicion,
			tableWidth:130
		};

		var columns = ["Variables","Regionales"];
		var data = [
		["P60-2:",""+input_varaiable_regional_chen_p60_2.val()],
		["P610:", ""+input_varaiable_regional_bell_p610.val()],
		["F:", ""+input_varaiable_regional_chen_f.val()],
		["a:", ""+input_varaiable_regional_chen_a.val()],
		["b:", ""+input_varaiable_regional_chen_b.val()],
		["c:", ""+input_varaiable_regional_chen_c.val()]
		];
		pdf.autoTable(columns, data, options);  

		var options = {
			margin: {
			top: 40, right: 20, bottom: 20, left: 350 
			},
			startY: posicion,
			tableWidth:220
		};

		
		var columns = ["",""];
		var data = [
		["Método de Ajuste:",""+ Metodos[select_metodos_ajuste.val()]],
		["Método Curva ID-Tr:", ""+radio_cheng_lung_chen.is(':checked')?"Cheng-Lung Chen":"F.C Be"],
		["R:", ""+radio_modificada.is(':checked')?input_modificada.val():input_automatica.val()]
		];
		pdf.autoTable(columns, data, options);  

		pdf.addPage();
		var options = {
			margin: {
			top: 40, right: 10, bottom: 10, left: 10 
			},
			//startY: pdf.autoTableEndPosY()+400,
			styles: {
				fontSize: 7,
			},
		};

			/* Curvas IdTr*/
		
		var res = pdf.autoTableHtmlToJson(document.getElementById("tabla_metodo_intensidad"));
		pdf.autoTable(res.columns, res.data, options);
		pdf.text(250,30,"Intensidad");
		if (radio_cheng_lung_chen.is(':checked')){
			pdf.addImage(url_image_metodo_ajuste_intensidad_chen, 'PNG', 20, pdf.autoTableEndPosY()+10, 500, 200);	
		}else {
			pdf.addImage(url_image_metodo_ajuste_intensidad_bell, 'PNG', 20, pdf.autoTableEndPosY()+10, 500, 200);
		}

		
		pdf.addPage();

		var options = {
			margin: {
			top: 40, right: 10, bottom: 10, left: 10 
			},
			//startY: pdf.autoTableEndPosY()+1000,//posiciontablaprecipitacion,
			styles: {
				fontSize: 7,
			},
		};
		// var valor = pdf.autoTableEndPosY()+290;

		var res = pdf.autoTableHtmlToJson(document.getElementById("tabla_metodo_precipitacion"));
		pdf.autoTable(res.columns, res.data, options);
		pdf.text(250,20,"Precipitación");
		if (radio_cheng_lung_chen.is(':checked')){
			pdf.addImage(url_image_metodo_ajuste_precipitacion_chen, 'PNG', 20, pdf.autoTableEndPosY()+10, 500, 200);	
		}else {
			pdf.addImage(url_image_metodo_ajuste_precipitacion_bell, 'PNG', 20, pdf.autoTableEndPosY()+10, 500, 200);	
		}
	
	}//termina if 
	else{

			if (select_año_mes.val()==-1){
			pdf.addImage(url_image_años, 'PNG', 200, 300, 400, 200);
			}
			else{
				pdf.addImage(url_image_meses, 'PNG', 200, 300, 400, 200);
			}	

		
		pdf.autoTable(res.columns, res.data, options);

		var options = {
			margin: {
			top: 40, right: 20, bottom: 20, left: 20 
			},
			//startY: pdf.autoTableEndPosY() + 100,
			startY: 607,
			tableWidth:250
		};
		
		
		pdf.text(20, 597,"Datos Paramétricos")
//		pdf.text(20, pdf.autoTableEndPosY() + 80,"Datos Paramétricos")
	
		var valor = 697;
		
	//	console.log("Datos de la estación"+(517 + 80)+ " valor "+valor);
	
		var columns = ["",""];
		var data = [
		["Número de datos:", ""+input_num_datos.val()],
		["Media de las precipitaciones:	", ""+input_promedio.val()],
		["Desv. Est. de las precipitaciones:", ""+input_desviacion.val()],
		["Media de los log. de las precipitaciones:	", ""+input_promedio_logaritmo.val()],
		["Desv. Est de los log. de las precipitaciones:", " Pendiente "]
		];
		pdf.autoTable(columns, data, options);
		/* Error Estandar*/
		var options = {
			margin: {
			top: 80, right: 20, bottom: 20, left: 20 
			},
			startY: valor+230,
			tableWidth:250
		};
				
		var columns = ["Método","Error Estandar"];
		var data = [
		["Exponencial con b y x0:", ""+input_exponencial_b.val()],
		["Nash:	", ""+input_exponencial_b_x0.val()],
		["Log Normal 2:", ""+input_log_normal.val()],
		["Gumbel:	", ""+input_gumbel.val()],
		["Gamma 2:", ""+input_gamma.val()],
		["Normal:", ""+input_normal.val()],
		["Exponencial con b:", ""+input_exponencial_b.val()]
		];

		pdf.autoTable(columns, data, options);
		pdf.text(20, pdf.autoTableEndPosY()-210,"Error Estandar");
		pdf.addImage(url_image_error_estandar, 'PNG', 300,  pdf.autoTableEndPosY()-210, 250, 200);//x,y,ancho,alto

		/*Metodo de Ajuste*/
		pdf.text(200, pdf.autoTableEndPosY()+30,"Métodos de ajuste");
		var options = {
			margin: {
			top: 40, right: 20, bottom: 20, left: 20 
			},
			startY: pdf.autoTableEndPosY()+40,
			//tableWidth:500
			
		};
		var res = pdf.autoTableHtmlToJson(document.getElementById("tabla_metodos_tr"));
		pdf.autoTable(res.columns, res.data, options);
		
		pdf.addImage(url_image_metodo_ajuste, 'PNG', 20,pdf.autoTableEndPosY()+10, 500, 200);	

		/*Informacion de la Estación tablas*/
			var options = {
			margin: {
			top: 40, right: 20, bottom: 20, left: 20 
			},
			startY: pdf.autoTableEndPosY() + 250,
			tableWidth:180
			
		};
		var posicion =  pdf.autoTableEndPosY() + 250;
		//console.log("Valor  "+pdf.autoTableEndPosY() + 250+"posicion "+posicion);

		var columns = ["Información","Estación"];
		var data = [
		["Estado:", ""+estados[indice_de_estado].nombre],
		["Municipio:", ""+estados[indice_de_estado].municipios[indice_de_municipio].nombre],
		["Estación:", ""+estacion.nombre],
		["Clave:", ""+estacion.id],
		["Estatus:", ""+estacion.estatus],
		["No. De datos:", ""+input_num_datos.val()]
		];
		pdf.autoTable(columns, data, options);

		var options = {
			margin: {
			top: 40, right: 20, bottom: 20, left: 210 
			},
			tableWidth:130
		};

		var columns = ["Variables","Regionales"];
		var data = [
		["P60-2:",""+input_varaiable_regional_chen_p60_2.val()],
		["P610:", ""+input_varaiable_regional_bell_p610.val()],
		["F:", ""+input_varaiable_regional_chen_f.val()],
		["a:", ""+input_varaiable_regional_chen_a.val()],
		["b:", ""+input_varaiable_regional_chen_b.val()],
		["c:", ""+input_varaiable_regional_chen_c.val()]
		];
		pdf.autoTable(columns, data, options);  

		var options = {
			margin: {
			top: 40, right: 20, bottom: 20, left: 350 
			},
			tableWidth:220
		};

		
		var columns = ["",""];
		var data = [
		["Método de Ajuste:",""+ Metodos[select_metodos_ajuste.val()]],
		["Método Curva ID-Tr:", ""+radio_cheng_lung_chen.is(':checked')?"Cheng-Lung Chen":"F.C Be"],
		["R:", ""+radio_modificada.is(':checked')?input_modificada.val():input_automatica.val()]
		];
		pdf.autoTable(columns, data, options);  


		var options = {
			margin: {
			top: 40, right: 10, bottom: 10, left: 10 
			},
			startY: pdf.autoTableEndPosY()+120,
			styles: {
				fontSize: 7,
			},
		};

			/* Curvas IdTr*/
		
		var res = pdf.autoTableHtmlToJson(document.getElementById("tabla_metodo_intensidad"));
		pdf.autoTable(res.columns, res.data, options);
		pdf.text(250, 230,"Intensidad");
		if (radio_cheng_lung_chen.is(':checked')){
			pdf.addImage(url_image_metodo_ajuste_intensidad_chen, 'PNG', 20, pdf.autoTableEndPosY(), 500, 200);	
		}else {
			pdf.addImage(url_image_metodo_ajuste_intensidad_bell, 'PNG', 20, pdf.autoTableEndPosY(), 500, 200);	
		}

		

		var options = {
			margin: {
			top: 40, right: 10, bottom: 10, left: 10 
			},
			startY: pdf.autoTableEndPosY()+1000,//posiciontablaprecipitacion,
			styles: {
				fontSize: 7,
			},
		};

		var res = pdf.autoTableHtmlToJson(document.getElementById("tabla_metodo_precipitacion"));
		pdf.autoTable(res.columns, res.data, options);
		pdf.text(250,20,"Precipitación");
		if (radio_cheng_lung_chen.is(':checked')){
			pdf.addImage(url_image_metodo_ajuste_precipitacion_chen, 'PNG', 20, 280, 500, 200);	
		}else {
			pdf.addImage(url_image_metodo_ajuste_precipitacion_bell, 'PNG', 20, 280, 500, 200);	
		}

	}
	

	pdf.save('mipdf.pdf');


}

</script>


<script>

        
</script>
