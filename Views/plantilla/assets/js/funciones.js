$(function () {

  let baseURL = "http://localhost/leshealth/Views/plantilla/";

    Fancybox.bind("[data-fancybox]", {
  // Your custom options
});


  const apiKey = "85b72a23feb9ccd5bd3520a9efd9a39e";
  let lat = 12.1364;
  let lon = -86.2514;

   if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        lat = position.coords.latitude;
        lon = position.coords.longitude;

        console.log("Latitud: " + lat);
        console.log("Longitud: " + lon);

        // Aquí puedes llamar a tu función para consumir la API del clima
        // por ejemplo: getWeather(lat, lon);
      },
      function (error) {
        console.error("Error obteniendo ubicación:", error.message);
      }
    );
  } else {
    console.error("La geolocalización no es soportada por este navegador.");
  }

  $.ajax({
    url: "https://api.openweathermap.org/data/2.5/weather",
    method: "GET",
    data: {
      lat: lat,
      lon: lon,
      appid: apiKey,
      units: "metric",
      lang: "es"
    },
    success: async function (data) {
      const weather = data.weather[0];
      const temp = data.main.temp;
      const humedad = data.main.humidity;
      const cond = weather.description;
      const icon = weather.icon;
      const iconUrl = `https://openweathermap.org/img/wn/${icon}@2x.png`;

      // ----- Card 1: Clima -----
      $("#iconoClima").attr("src", iconUrl);
      $("#temperatura").text(temp + " °C");
      $("#condicion").text(cond.charAt(0).toUpperCase() + cond.slice(1));
      $("#humedad").text("Humedad: " + humedad + "%");

      // ----- Card 2: Recomendación solar -----
      const condMain = weather.main.toLowerCase();
      const uvResponse = await fetch(`https://currentuvindex.com/api/v1/uvi?latitude=${lat}&longitude=${lon}`);
const uvData = await uvResponse.json(); 
const uvIndex = uvData.now.uvi; // ajusta según cómo devuelva la API

      let nivel = "";
      let mensaje = "";
      let icono = "";
      let color = "";

      if (condMain.includes("clear")) {
        nivel = "Alta exposición";
        mensaje = "☀️ Usa protector solar, gafas de sol y evita salir entre 10am - 4pm.";
        icono = "fa-sun";
        color = "orange";
      } else if (condMain.includes("cloud")) {
        nivel = "Exposición moderada";
        mensaje = "⛅ Aunque esté nublado, los rayos UV atraviesan. Usa bloqueador.";
        icono = "fa-cloud-sun";
        color = "gray";
      } else if (condMain.includes("rain")) {
        nivel = "Baja exposición";
        mensaje = "🌧️ Riesgo bajo de radiación UV. Aún así, protégete si sales.";
        icono = "fa-cloud-rain";
        color = "blue";
      } else {
        nivel = "Exposición variable";
        mensaje = "ℹ️ Consulta antes de salir y usa protector por precaución.";
        icono = "fa-sun-cloud";
        color = "green";
      }

      $("#nivelExposicion").text(nivel);
      $("#mensajeRecomendacion").text(mensaje);
      $("#iconoSolar").removeClass().addClass("fa-solid " + icono).css("color", color);

      // Cambiar título dinámico
      let tituloSolar = "Recomendación Solar @ Hoy";
      switch(nivel) {
        case "Alta exposición":
          tituloSolar = "🌞 " + tituloSolar;
          $("#solarCard h5").css("color", "red");
          break;
        case "Exposición moderada":
          tituloSolar = "⛅ " + tituloSolar;
          $("#solarCard h5").css("color", "orange");
          break;
        case "Baja exposición":
          tituloSolar = "🌧️ " + tituloSolar;
          $("#solarCard h5").css("color", "blue");
          break;
        default:
          tituloSolar = "ℹ️ " + tituloSolar;
          $("#solarCard h5").css("color", "green");
      }
      $("#solarCard h5").text(tituloSolar);

      // ----- Card 3: Nivel UV estimado (alerta lupus) -----
const hora = new Date().getHours(); // hora local
let uvNivel = "";
let mensajeUV = "";
let uvIcono = "";
let uvColor = "";

// Estimación UV combinando índice y hora
if (uvIndex <= 2) {
  uvNivel = "Baja exposición";
  mensajeUV = "🟢 Riesgo bajo, aún así usa protector solar si te expones mucho tiempo.";
  uvIcono = "fa-sun"; 
  uvColor = "green";
} else if (uvIndex <= 5) {
  uvNivel = "Exposición moderada";
  mensajeUV = "🟡 Usa gafas de sol y bloqueador si sales al mediodía.";
  uvIcono = "fa-sun-cloud";
  uvColor = "yellow";
} else if (uvIndex <= 7) {
  uvNivel = "Alta exposición";
  mensajeUV = "🟠 Usa protector solar, gafas y busca sombra entre 10am - 4pm.";
  uvIcono = "fa-sun";
  uvColor = "orange";
} else if (uvIndex <= 10) {
  uvNivel = "Muy alta exposición";
  mensajeUV = "🔴 Evita estar al sol directo. Usa sombrero, bloqueador fuerte y ropa protectora.";
  uvIcono = "fa-sun"; 
  uvColor = "red";
} else {
  uvNivel = "Exposición extrema";
  mensajeUV = "☠️ Evita salir sin protección, riesgo muy alto de daño en la piel y ojos.";
  uvIcono = "fa-sun"; 
  uvColor = "purple";
}

      $("#nivelUV").text(uvNivel);
      $("#mensajeUV").text(mensajeUV);
      $("#iconoUV").css("color", uvColor);

      // Cambiar título del card UV según nivel
      let tituloUV = "Nivel UV @ Hoy";
      switch(uvNivel) {
        case "Alta":
          tituloUV = "🔴 " + tituloUV;
          $("#uvCard h5").css("color", "red");
          break;
        case "Moderada":
          tituloUV = "🟠 " + tituloUV;
          $("#uvCard h5").css("color", "orange");
          break;
        case "Baja":
          tituloUV = "🟢 " + tituloUV;
          $("#uvCard h5").css("color", "green");
          break;
        default:
          tituloUV = "ℹ️ " + tituloUV;
          $("#uvCard h5").css("color", "blue");
      }
      $("#uvCard h5").text(tituloUV);

    },
    error: function(xhr, status, error) {
      $("#climaCard").append("<p>Error cargando clima</p>");
      $("#solarCard").append("<p>Error cargando recomendación</p>");
      $("#uvCard").append("<p>Error cargando nivel UV</p>");
      console.error(xhr.responseText);
    }
  });

   /* Inicializando dataTable */
   inicializarDataTable();

   /* Funciones para capturar la ruta en la que se encuentra y proporcionar la clase active en el menu */        

   var activeUrl = window.location.pathname;
    
   // Selecciona el enlace activo
   var activeLink = $('a[href*="' + activeUrl + '"]');

   // Quita la clase 'collapsed' del enlace activo
   activeLink.removeClass('collapsed');

   // Agrega 'collapsed' a los demás enlaces
   $(".nav-link").not(activeLink).addClass('collapsed');

   $(".nav-item").click(function() {
       var callItem = $(this);
       
       // Quita la clase 'active' de otros elementos y agrega a 'callItem'
       $(".nav-item").not(callItem).removeClass('active');
       callItem.addClass('active');

       // Remueve 'collapsed' del enlace clicado y lo agrega a los demás
       var clickedLink = callItem.find('a');
       $(".nav-link").addClass('collapsed');
       clickedLink.removeClass('collapsed');
   });
    /* Inicializacion del mapa de leaflet */

    /* Previsualizacion en el modal al agregar doctor */
     $('#imagen').on('change', function() {
        const file = this.files[0];
        const preview = $('#previewImage');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result);
                preview.show();
            };
            reader.readAsDataURL(file);
        } else {
            preview.attr('src', '#');
            preview.hide();
        }
    });

    /* Funcion para mandar el formulario de doctor y agregar a la BD */

       $('#formAgregarDoctor').submit(function (e) {
        e.preventDefault();
        var extension=$("#imagen").val().split('.').pop().toLowerCase();;
        console.log(extension);
        if(extension != '')
          {
           if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
           {
            alert("Invalid Image File");
            $('#imagen').val('');
            return false;
           }
          } 
        $.ajax({
            url: 'doctor/agregarDoctor',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarDoctor').modal('hide');
                $('#formAgregarDoctor')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego registro de Doctor!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });


    /* Funcion para cargar informacion en el formulario de editar doctor */
     /* funciones cargar los datos en el modal actualizar categoria */
     $("#table").on("click",".btnEditarDoctor", function(){
        $('#modalEditarDoctor').modal({backdrop: 'static', keyboard: false});
        var datos = JSON.parse($(this).attr('data-Doctor'));
        console.log(datos);
        $("#idUp").val(datos['id_doctor']);
        $("#nombreUp").val(datos['nombre_doctor']);
        $("#sexoUp").val(datos['sexo']);
        $("#numeroUp").val(datos['telefono']);
        $("#correoUp").val(datos['correo']);
        $("#nombreUsUp").val(datos['usuario']);

        $("#especialidadUp").val(datos['especialidad']);

        $("#previewImageUp").attr('src', baseURL + 'assets/img/' + datos['imagen']);


      });


       /* Funcion para mandar el formulario de editar doctor y agregar a la BD */

       $('#formEditarDoctor').submit(function (e) {
        e.preventDefault();
        var extension=$("#imagenUp").val().split('.').pop().toLowerCase();;
        console.log(extension);
        if(extension != '')
          {
           if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
           {
            alert("Invalid Image File");
            $('#imagenUp').val('');
            return false;
           }
          } 
        $.ajax({
            url: 'doctor/editarDoctor',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalEditarDoctor').modal('hide');
                $('#formEditarDoctor')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se edito el registro de Doctor!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });


    /* Funcion para mandar el formulario de registro de signos y agregar a la BD */

       $('#formAgregarSigno').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'signos/agregarSigno',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarSigno').modal('hide');
                $('#formAgregarSigno')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego registro!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });


    /* Funcion para cargar informacion en el formulario para editar signos */
    $("#table").on("click",".btnEditarSigno", function(){
        $('#modalActualizarSigno').modal({backdrop: 'static', keyboard: false});
        var datos = JSON.parse($(this).attr('data-Signos'));
        console.log(datos);
         $("#idSigno").val(datos['id_signo']);
        $("#idPUp").val(datos['protagonista_id_protagonista']);
        $("#fechaUp").val(datos['fecha']);
        $("#horaUp").val(datos['hora']);
        $("#tipoUp").val(datos['tipo']);
        $("#valorUp").val(datos['valor']);
        
      });
    
       /* Funcion para editar el formulario de registro de signos y agregar a la BD */

       $('#formEditarSigno').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'signos/editarSigno',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalActualizarSigno').modal('hide');
                $('#formEditarSigno')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego registro!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });

    /* Borrar Signo */


    $("#table").on("click",".btBorrarSigno",function(){
        Swal.fire({
            title: 'Estas seguro?',
            text: "No podrá recuperar los datos!",
            icon: 'warning',
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#428bca',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Sí, Eliminarlo!',
            cancelButtonText: 'No, cancelar',
            reverseButtons:true
        }).then((result)=>{
            if(result.isConfirmed){
                var idSigno=$(this).attr('data-borrarSigno');
    console.log(idSigno);
                $.ajax({
                    url:'signos/borrarSigno',
                    type:"POST",
                    data:{"id":idSigno},
                    success:function(respuesta){
                        $("#table").DataTable().destroy();
                        $("#table tbody").html(respuesta);
                        inicializarDataTable();
                            Swal.fire(
                            'Borrado',
                            'El registro a sido eliminado',
                            'success'
                            )
    
                        
                    }
                });
    
    
    
                
    
    
            }
            else if (
                result.dismiss === Swal.DismissReason.cancel
              ){
                Swal.fire(
                'cancelado',
                'el registro esta a salvo',
                'error'
        
                )
        
              }
    
        });
    
    
    });




      /* Funcion para mandar el formulario de agendar cita vista protagonista */

       $('#formAgregarReserva').submit(function (e) {
        e.preventDefault();
        var extension=$("#imagen").val().split('.').pop().toLowerCase();;
        console.log(extension);
        if(extension != '')
          {
           if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
           {
            alert("Invalid Image File");
            $('#imagen').val('');
            return false;
           }
          } 
        $.ajax({
            url: 'reserva/agregarReserva',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarReserva').modal('hide');
                $('#formAgregarReserva')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se registro la reserva!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });
    


   

    $("#municipioOrigen").prop("disabled", true);

    /* funciones cementerio */

    $('#departamentoOrigen').on("change", function () {
        let idDepartamento = $('#departamentoOrigen').val();
        console.log(idDepartamento);
        $.ajax({
            url: 'protagonista/cargarMunicipio',
            type: 'post',
            data: { 'idDepartamento': idDepartamento },
            success: function (respuesta) {
                $("#municipioOrigen").prop("disabled", false);
                $("#municipioOrigen").html(respuesta);
                console.log(respuesta);
            }
        });
    });

      /* Funcion para mandar el formulario de protagonista y agregar a la BD */

       $('#formAgregarProtagonista').submit(function (e) {
        e.preventDefault();
        var extension=$("#imagen").val().split('.').pop().toLowerCase();;
        console.log(extension);
        if(extension != '')
          {
           if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
           {
            alert("Invalid Image File");
            $('#imagen').val('');
            return false;
           }
          } 
        $.ajax({
            url: 'protagonista/agregarProtagonista',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarProtagonista').modal('hide');
                $('#formAgregarProtagonista')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego registro del Protagonista!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });






 
    /* funciones agregar cementerio */
    $('#formAgregarCementerio').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: '../cementerio/agregarCementerio',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                console.log(respuesta);
                $('#formAgregarCementerio')[0].reset();
                Swal.fire({
                    title: "Se agrego cementerio!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });

    /* Funcion para enviar los datos y cargarlos en el formilario de actualizar */
// Cuando se hace click en el botón de editar usuario
$("#table").on("click", ".btnEditarUsuario", function() {

    let data = JSON.parse($(this).attr('data-usuario'));
    

    $("#id_usuario").val(data.id_usuario);
    $("#nombreEditar").val(data.nombre_usuario);
    $("#claveEditar").val("");          
    $("#repetirEditar").val("");        
    $("#rolEditar").val(data['rol']);

    // Elimina los datos de sessionStorage
    sessionStorage.removeItem('datosUsuario');
});

// Cargar datos en el formulario si existen en sessionStorage

    /* funciones Enviar datos actualizados de cementerio */
    $('#formEditarUsuario').submit(function (e) {
        e.preventDefault();
        let data = new FormData(this)
        for (let [key, value] of data.entries()) {
    console.log(key, value);
}
        $.ajax({
            url: 'usuario/editar',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
              console.log()
                $('#formEditarUsuario')[0].reset();
                Swal.fire({
                    title: "Se Actualizo cementerio!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });

    


    /* funcion borrar cementerio */
    $("#table").on("click",".btBorrarCementerio",function(){
        Swal.fire({
            title: 'Estas seguro?',
            text: "No podrá recuperar los datos!",
            icon: 'warning',
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#428bca',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Sí, Eliminarlo!',
            cancelButtonText: 'No, cancelar',
            reverseButtons:true
        }).then((result)=>{
            if(result.isConfirmed){
                var idCementerio=$(this).attr('data-borrarUsuario');
    
                $.ajax({
                    url:'usuario/borrar/',
                    type:"POST",
                    data:{"id":idCementerio},
                    success:function(respuesta){
                        $("#table").DataTable().destroy();
                        $("#table tbody").html(respuesta);
                        inicializarDataTable();
                            Swal.fire(
                            'Borrado',
                            'El registro a sido eliminado',
                            'success'
                            )
    
                        
                    }
                });
    
    
    
                
    
    
            }
            else if (
                result.dismiss === Swal.DismissReason.cancel
              ){
                Swal.fire(
                'cancelado',
                'el registro esta a salvo',
                'error'
        
                )
        
              }
    
        });
    
    
    });

    // =============================
    // INFORMES
    // =========================
    $(document).ready(function() {

    // ==========================
    // 1. Abrir modal Editar Reporte
    // ==========================
    $("#tableReportes").on("click", ".btnEditarReporte", function() {
        let datos = JSON.parse($(this).attr('data-reporte'));

        // Llenar campos del formulario con los datos
        $("#id_signo").val(datos['id_signo']);
        $("#fechaEditar").val(datos['fecha']);
        $("#horaEditar").val(datos['hora']);
        $("#tipoEditar").val(datos['tipo']);
        $("#valorEditar").val(datos['valor']);
        $("#pacienteReporteEditar").val(datos['protagonista_id_protagonista']);

        // Abrir modal
        $("#modalEditarReporte").modal('show');
    });

    // ==========================
    // 2. Enviar formulario Agregar Reporte
    // ==========================
    $("#formAgregarReporte").submit(function(e) {
        e.preventDefault();
        let data = new FormData(this);

        $.ajax({
            url: 'reportes/agregarReporte',
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function(respuesta) {
                $("#tableReportes tbody").html(respuesta);
                $("#modalAgregarReporte").modal('hide');
                $("#formAgregarReporte")[0].reset();
            }
        });
    });

    // ==========================
    // 3. Enviar formulario Editar Reporte
    // ==========================
    $("#formEditarReporte").submit(function(e) {
        e.preventDefault();
        let data = new FormData(this);

        $.ajax({
            url: 'reportes/editarReporte',
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function(respuesta) {
                $("#tableReportes tbody").html(respuesta);
                $("#modalEditarReporte").modal('hide');
            }
        });
    });

    // ==========================
    // 4. Borrar Reporte
    // ==========================
    $("#tableReportes").on("click", ".btnBorrarReporte", function() {
        let id = $(this).attr('data-borrarReporte');

        if(confirm("¿Está seguro de eliminar este registro de signos vitales?")) {
            $.ajax({
                url: 'reportes/borrarReporte',
                type: 'POST',
                data: { idSigno: id },
                success: function(respuesta) {
                    $("#tableReportes tbody").html(respuesta);
                }
            });
        }
    });

});


    // ===========================
    // EJERCICIO
    // =================

    $(document).ready(function() {

    // ==========================
    // 1. Abrir modal Editar Ejercicio
    // ==========================
    $("#tableEjercicio").on("click", ".btnEditarEjercicio", function() {
        let datos = JSON.parse($(this).attr('data-ejercicio'));

        // Llenar campos del formulario con los datos
        $("#id_ejercicio").val(datos['id_ejercicio']);
        $("#nombreEjercicioEditar").val(datos['nombre_ejercicio']);
        $("#repeticionesEditar").val(datos['repeticiones']);
        $("#seriesEditar").val(datos['series']);
        $("#pacienteEjercicioEditar").val(datos['protagonista_id_protagonista']);

        // Abrir modal
        $("#modalEditarEjercicio").modal('show');
    });

    // ==========================
    // 2. Enviar formulario Agregar Ejercicio
    // ==========================
    $("#formAgregarEjercicio").submit(function(e) {
        e.preventDefault();
        let data = new FormData(this);

        $.ajax({
            url: 'ejercicio/agregarEjercicio',
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function(respuesta) {
                $("#tableEjercicio tbody").html(respuesta);
                $("#modalAgregarEjercicio").modal('hide');
                $("#formAgregarEjercicio")[0].reset();
            }
        });
    });

    // ==========================
    // 3. Enviar formulario Editar Ejercicio
    // ==========================
    $("#formEditarEjercicio").submit(function(e) {
        e.preventDefault();
        let data = new FormData(this);

        $.ajax({
            url: 'ejercicio/editarEjercicio',
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function(respuesta) {
                $("#tableEjercicio tbody").html(respuesta);
                $("#modalEditarEjercicio").modal('hide');
            }
        });
    });

    // ==========================
    // 4. Borrar Ejercicio
    // ==========================
    $("#tableEjercicio").on("click", ".btnBorrarEjercicio", function() {
        let id = $(this).attr('data-borrarEjercicio');

        if(confirm("¿Está seguro de eliminar este registro de ejercicio?")) {
            $.ajax({
                url: 'ejercicio/borrarEjercicio',
                type: 'POST',
                data: { idEjercicio: id },
                success: function(respuesta) {
                    $("#tableEjercicio tbody").html(respuesta);
                }
            });
        }
    });

});


    // ===========================
    // DIETAAAAAAAAAAAAAAAAA
    //==================

    $(document).ready(function() {

    // ==========================
    // 1. Abrir modal Editar Dieta
    // ==========================
    $("#tableDieta").on("click", ".btnEditarDieta", function() {
        let datos = JSON.parse($(this).attr('data-dieta'));

        // Llenar campos del formulario con los datos
        $("#id_dieta").val(datos['id_dieta']);
        $("#nombrePlatoEditar").val(datos['nombre_plato']);
        $("#tipoEditar").val(datos['tipo']);
        $("#descripcionEditar").val(datos['descripcion']);
        $("#pacienteEditar").val(datos['protagonista_id_protagonista']);

        // Abrir modal
        $("#modalEditarDieta").modal('show');
    });

    // ==========================
    // 2. Enviar formulario Agregar Dieta
    // ==========================
    $("#formAgregarDieta").submit(function(e) {
        e.preventDefault();
        let data = new FormData(this);

        $.ajax({
            url: 'dieta/agregarDieta',
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function(respuesta) {
                $("#tableDieta tbody").html(respuesta);
                $("#modalAgregarDieta").modal('hide');
                $("#formAgregarDieta")[0].reset();
            }
        });
    });

    // ==========================
    // 3. Enviar formulario Editar Dieta
    // ==========================
    $("#formEditarDieta").submit(function(e) {
        e.preventDefault();
        let data = new FormData(this);

        $.ajax({
            url: 'dieta/editarDieta',
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function(respuesta) {
                $("#tableDieta tbody").html(respuesta);
                $("#modalEditarDieta").modal('hide');
            }
        });
    });

    // ==========================
    // 4. Borrar Dieta
    // ==========================
    $("#table").on("click", ".btnBorrarDieta", function() {
        let id = $(this).attr('data-borrarDieta');

        if(confirm("¿Está seguro de eliminar este registro de dieta?")) {
            $.ajax({
                url: 'dieta/borrar',
                type: 'POST',
                data: { idDieta: id },
                success: function(respuesta) {
                    $("#tableDieta tbody").html(respuesta);
                }
            });
        }
    });

});


    // ==========================
    // MEDICACIOOOONESSS
    // ==========================

    // ==========================
    // 1. Abrir modal Editar
    // ==========================
    $("#tableMedicacion").on("click", ".btnEditarMedicacion", function() {
        let datos = JSON.parse($(this).attr('data-medicacion'));

        // Llenar campos del formulario con los datos
        $("#id_medicacion").val(datos['id_medicacion']);
        $("#nombreEditar").val(datos['nombre_medicamento']);
        $("#dosisEditar").val(datos['dosis']);
        $("#frecuenciaEditar").val(datos['frecuencia']);
        $("#horaEditar").val(datos['hora_aplicacion']);
        $("#fechaEditar").val(datos['fecha']);
        $("#duracionEditar").val(datos['duracion']);
        $("#pacienteEditar").val(datos['protagonista_id_protagonista']);

        // Abrir modal
        $("#modalEditarMedicacion").modal('show');
    });

    // ==========================
    // 2. Enviar formulario Agregar Medicación
    // ==========================
    $("#formAgregarMedicacion").submit(function(e) {
        e.preventDefault();
        let dataForm = new FormData(this);

        for (let [key, value] of dataForm.entries()) {
        console.log(key + ": " + value);
    }

        $.ajax({
            url: 'medicacion/agregar',
            type: 'POST',
            data: dataForm,
            contentType: false,
            processData: false,
            success: function(respuesta) {
                $("#tableMedicacion tbody").html(respuesta);
                $("#modalAgregarMedicacion").modal('hide');
                $("#formAgregarMedicacion")[0].reset();
            }
        });
    });

    // ==========================
    // 3. Enviar formulario Editar Medicación
    // ==========================
    $("#formEditarMedicacion").submit(function(e) {
        e.preventDefault();
        let data = new FormData(this);

        $.ajax({
            url: 'medicacion/editarMedicacion',
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function(respuesta) {
                $("#tableMedicacion tbody").html(respuesta);
                $("#modalEditarMedicacion").modal('hide');
            }
        });
    });

    // ==========================
    // 4. Borrar Medicación
    // ==========================
    $("#tableMedicacion").on("click", ".btnBorrarMedicacion", function() {
        let id = $(this).attr('data-borrarMedicacion');

        if(confirm("¿Está seguro de eliminar esta medicación?")) {
            $.ajax({
                url: 'medicacion/borrarMedicacion',
                type: 'POST',
                data: { idMedicacion: id },
                success: function(respuesta) {
                    $("#tableMedicacion tbody").html(respuesta);
                }
            });
        }
    });


     /* ------------------------------
        ------------------------------
          *   Funciones usuario   *
        ------------------------------
        ------------------------------
     */

        

      

        /* funciones agregar usuario */
    $('#formAgregarUsuario').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'usuario/agregarUsuario',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarUsuario').modal('hide');
                $('#formAgregarUsuario')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego cementerio!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });

    /* ------------------------------
        ------------------------------
          *   Funciones categoria   *
        ------------------------------
        ------------------------------
     */

        /* funciones agregar usuario */
    $('#formAgregarCategoria').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'categoria/agregarCategoria',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarCategoria').modal('hide');
                $('#formAgregarCategoria')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego categoria!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });

    
     /* funciones cargar los datos en el modal actualizar categoria */
     $("#table").on("click",".btnEditarCategoria", function(){
        $('#modalActualizarCategoria').modal({backdrop: 'static', keyboard: false});
        var datos = JSON.parse($(this).attr('data-categoria'));
        $("#idCategoriaUp").val(datos['id']);
        $("#nombreCategoriaUp").val(datos['nombre_categoria']);
      });

       

        /* funciones actualizar datos de la categoria */
    $('#formActualizarCategoria').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'categoria/actualizarCategoria',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalActualizarCategoria').modal('hide');
                $('#formActualizarCategoria')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se actualizo categoria!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });

    /* funcion borrar categoria */
    $("#table").on("click",".btBorrarCategoria",function(){
        Swal.fire({
            title: 'Estas seguro?',
            text: "No podrá recuperar los datos!",
            icon: 'warning',
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#428bca',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Sí, Eliminarlo!',
            cancelButtonText: 'No, cancelar',
            reverseButtons:true
        }).then((result)=>{
            if(result.isConfirmed){
                var idCategoria=$(this).attr('data-borrarCategoria');
    
                $.ajax({
                    url:'categoria/borrarCategoria/',
                    type:"POST",
                    data:{'idCategoria':idCategoria},
                    success:function(respuesta){
                        $("#table").DataTable().destroy();
                        $("#table tbody").html(respuesta);
                        $('#table').DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'excel', 'pdf', 'print'
                            ],
                            language: {
                                url: 'https://cdn.datatables.net/plug-ins/2.1.5/i18n/es-MX.json',
                            },
                            responsive: true
                            });  
                            Swal.fire(
                            'Borrado',
                            'El registro a sido eliminado',
                            'success'
                            )
    
                        
                    }
                });
    
    
    
                
    
    
            }
            else if (
                result.dismiss === Swal.DismissReason.cancel
              ){
                Swal.fire(
                'cancelado',
                'el registro esta a salvo',
                'error'
        
                )
        
              }
    
        });
    
    
    });

        /* ------------------------------
        ------------------------------
          *   Funciones Causas   *
        ------------------------------
        ------------------------------
     */


        /* funciones agregar enfermedades */
    $('#formAgregarCausa').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'causas/agregarCausa',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarCausa').modal('hide');
                $('#formAgregarCausa')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego registro de enfermedad!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });

     /* funciones cargar los datos en el modal actualizar ENFERMEDAD */
     $("#table").on("click",".btnEditarCausa", function(){
        $('#modalEditarCausa').modal({backdrop: 'static', keyboard: false});
        var datos = JSON.parse($(this).attr('data-causa'));
        $("#idCausa").val(datos['id']);
        $("#codigoCIEUP").val(datos['codigo']);
        $("#nombreCategoriaUP").val(datos['categoria_id']);
        $("#descripcionUP").val(datos['descripcion']);
      
      });

       

        /* funcion que envia los datos del formulario actualizar datos de la enfermedad */
    $('#formEditarEnfermedad').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'causas/actualizarCausa',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalEditarCausa').modal('hide');
                $('#formEditarEnfermedad')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se actualizo categoria!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });
    

     /* funcion borrar enfermedad */
     $("#table").on("click",".btBorrarCausa",function(){
        Swal.fire({
            title: 'Estas seguro?',
            text: "No podrá recuperar los datos!",
            icon: 'warning',
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#428bca',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Sí, Eliminarlo!',
            cancelButtonText: 'No, cancelar',
            reverseButtons:true
        }).then((result)=>{
            if(result.isConfirmed){
                var idCausa=$(this).attr('data-borrarCausa');
    
                $.ajax({
                    url:'causas/borrarCausa/',
                    type:"POST",
                    data:{'idCausa':idCausa},
                    success:function(respuesta){
                        $("#table").DataTable().destroy();
                        $("#table tbody").html(respuesta);
                        inicializarDataTable();
                            Swal.fire(
                            'Borrado',
                            'El registro a sido eliminado',
                            'success'
                            )
    
                        
                    }
                });
    
    
    
                
    
    
            }
            else if (
                result.dismiss === Swal.DismissReason.cancel
              ){
                Swal.fire(
                'cancelado',
                'el registro esta a salvo',
                'error'
        
                )
        
              }
    
        });
    
    
    });

      /* ------------------------------
        ------------------------------
          *   Funciones Departamentos  *
        ------------------------------
        ------------------------------
     */

        
        /* funciones agregar Departamento */
    $('#formAgregarDepartamento').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'departamento/agregarDepartamento',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarDepartamento').modal('hide');
                $('#formAgregarDepartamento')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego registro de enfermedad!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });

     /* funciones cargar los datos en el modal actualizar Departamento */
     $("#table").on("click",".btnEditarDepartamento", function(){
        $('#modalActualizarDepartamento').modal({backdrop: 'static', keyboard: false});
        var datos = JSON.parse($(this).attr('data-departamento'));
        $("#idDepartamentoUp").val(datos['id_departamento']);
        $("#nombreDepartamentoUp").val(datos['nombre_departamento']);
      });

       

        /* funcion que envia los datos del formulario actualizar datos de la departamento */
    $('#formActualizarDepartamento').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'departamento/actualizarDepartamento',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalActualizarDepartamento').modal('hide');
                $('#formActualizarDepartamento')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se actualizo categoria!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });

     /* funcion borrar departamento */
     $("#table").on("click",".btBorrarDoctor",function(){
        Swal.fire({
            title: 'Estas seguro?',
            text: "No podrá recuperar los datos!",
            icon: 'warning',
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#428bca',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Sí, Eliminarlo!',
            cancelButtonText: 'No, cancelar',
            reverseButtons:true
        }).then((result)=>{
            if(result.isConfirmed){
                var idDoctor=$(this).attr('data-borrarServicio');
    
                $.ajax({
                    url:'doctor/borrar/',
                    type:"POST",
                    data:{'idDoctor':idDoctor},
                    success:function(respuesta){
                        $("#table").DataTable().destroy();
                        $("#table tbody").html(respuesta);
                        inicializarDataTable();
                            Swal.fire(
                            'Borrado',
                            'El registro a sido eliminado',
                            'success'
                            )
    
                        
                    }
                });
    
    
    
                
    
    
            }
            else if (
                result.dismiss === Swal.DismissReason.cancel
              ){
                Swal.fire(
                'cancelado',
                'el registro esta a salvo',
                'error'
        
                )
        
              }
    
        });
    
    
    });

     /* ------------------------------
        ------------------------------
          *   Funciones Municipios  *
        ------------------------------
        ------------------------------
     */

        
        /* funciones agregar Municipio */
        $('#formAgregarMunicipio').submit(function (e) {
            e.preventDefault();
    
            $.ajax({
                url: 'municipio/agregarMunicipio',
                type: 'post',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $('#modalAgregarMunicipio').modal('hide');
                    $('#formAgregarMunicipio')[0].reset();
                    $("#table").DataTable().destroy();
                    $("#table tbody").html(respuesta);
                    inicializarDataTable();
                    Swal.fire({
                        title: "Se agrego registro de Municipio!",
                        text: "con exito!",
                        icon: "success"
                      });
                    
                }
    
    
            });
        });


        /* funciones cargar los datos en el modal actualizar Municipio */
     $("#table").on("click",".btnEditarMunicipio", function(){
        $('#modalActualizarMunicipio').modal({backdrop: 'static', keyboard: false});
        var datos = JSON.parse($(this).attr('data-municipio'));
        $("#idMunicipio").val(datos['id_municipio']);
        $("#departamentoUP").val(datos['departamento_id_departamento']);
        $("#nombreMunicipioUP").val(datos['nombre_municipio']);

      });

       

        /* funcion que envia los datos del formulario actualizar datos de la municipio */
    $('#formEditarMunicipio').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'municipio/actualizarMunicipio',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalActualizarMunicipio').modal('hide');
                $('#formEditarMunicipio')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se actualizo categoria!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });


     /* funcion borrar departamento */
     $("#table").on("click",".btBorrarMunicipio",function(){
        Swal.fire({
            title: 'Estas seguro?',
            text: "No podrá recuperar los datos!",
            icon: 'warning',
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#428bca',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Sí, Eliminarlo!',
            cancelButtonText: 'No, cancelar',
            reverseButtons:true
        }).then((result)=>{
            if(result.isConfirmed){
                var idMunicipio=$(this).attr('data-borrarMunicipio');
    
                $.ajax({
                    url:'municipio/borrarMunicipio/',
                    type:"POST",
                    data:{'idMunicipio':idMunicipio},
                    success:function(respuesta){
                        $("#table").DataTable().destroy();
                        $("#table tbody").html(respuesta);
                        inicializarDataTable();
                            Swal.fire(
                            'Borrado',
                            'El registro a sido eliminado',
                            'success'
                            )
    
                        
                    }
                });
    
    
    
                
    
    
            }
            else if (
                result.dismiss === Swal.DismissReason.cancel
              ){
                Swal.fire(
                'cancelado',
                'el registro esta a salvo',
                'error'
        
                )
        
              }
    
        });
    
    
    });


     /* ------------------------------
        ------------------------------
          *   Funciones Defunciones  *
        ------------------------------
        ------------------------------
     */

         /* funciones agregar cementerio */
    $('#formAgregarDefuncion').submit(function (e) {
        e.preventDefault();
        $('#edadCumplida').prop('disabled',false);
        $.ajax({
            url: '../defunciones/agregarDefuncion',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                console.log(respuesta);
                $('#formAgregarDefuncion')[0].reset();
                $('#edadCumplida').prop('disabled',true);
                Swal.fire({
                    title: "Se agrego Defunción!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });

   


    
     /* ------------------------------
        ------------------------------
          *   Funciones Familiar Recuerdo  *
        ------------------------------
        ------------------------------
     */




     /* funciones cargar los datos en el modal actualizar Municipio */
     $("#table").on("click",".btnAgregarRecuerdo", function(){
        var datos = JSON.parse($(this).attr('data-recuerdo'));
        $("#nombreCompleto").val(datos['primer_nombre']+' '+datos['segundo_nombre']+' '+datos['primer_apellido']+' '+datos['segundo_apellido']);
        $("#fechaNacimiento").val(datos['fecha_nacimiento']);
        $("#edad").val(datos['edad_cumplida']);
        $("#sexo").val(datos['sexo']);
        $("#nacionalidadDifunto").val(datos['nacionalidad']);
        $("#ocupacionDifunto").val(datos['ocupacion']);
        $("#fechaDefuncion").val(datos['fecha_ocurrencia']);
        $("#horaDefuncion").val(datos['hora_defuncion']);
        $("#idDefu").val(datos['id_defuncion']);

      });


      $("#formAgregarRecuerdo").on("submit",function(e){
      
        // Obtener el archivo
    var fileInput = document.getElementById('recurso');
    var file = fileInput.files[0]; // Accede al primer archivo

    // Verificar si se seleccionó un archivo
    if (file) {
        // Obtener la extensión del archivo
        var extension = file.name.split('.').pop().toLowerCase();

        // Verificar la extensión
        if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg', 'mp4']) == -1) {
            alert("Archivo no válido. Solo se permiten imágenes (gif, png, jpg, jpeg) y videos (mp4).");
            fileInput.value = ''; // Limpiar el input
            return false;
        }

        // Verificar el tamaño del archivo
        if (file.size > 10 * 1024 * 1024) { // 10 MB en bytes
            alert("El archivo es demasiado grande. El tamaño máximo permitido es de 10 MB.");
            fileInput.value = ''; // Limpiar el input
            return false;
        }
    } else {
        alert("Por favor, selecciona un archivo.");
        return false;
    }



        e.preventDefault();
        $.ajax({
            url:'recuerdo/insertarRecuerdo/',
            type:'post',
            data:new FormData(this),
            contentType:false,
            processData:false,
        success:function(respuesta){
      console.log(respuesta);
      if(respuesta==true){
        $('#formAgregarRecuerdo')[0].reset();
        $('#modalAgregarRecuerdo').modal('hide');

    
        Swal.fire(
            'Se Agrego el Recuerdo con exito',
            'en el sistema',
            'success'
        )
      }
      else{
        Swal.fire(
            'Error al añadir el archivo',
            'en el sistema',
            'error'
        )
      }
           
    
          
    
    
        }
        ,error:function(){
            console.log('Error');
        }
    
    
    
    }); 
    
    
    
    });

     /* ------------------------------
        ------------------------------
          *   Funciones Ubicacion Descanso  *
        ------------------------------
        ------------------------------
     */

         /* funciones cargar los datos en el modal Asignar Funcion Descanso*/
     $("#table").on("click",".btnAgregarUbicacion", function(){
        var datos = JSON.parse($(this).attr('data-ubicacion'));
        $("#nombreCompleto").val(datos['primer_nombre']+' '+datos['segundo_nombre']+' '+datos['primer_apellido']+' '+datos['segundo_apellido']);
        $("#cedula").val(datos['cedula']);

        $("#edadFallecio").val(datos['edad_cumplida']);
        $("#imgRecuerdo").val(datos['sexo']);
        $("#imgRecuerdo").attr("src",'Views/plantilla/assets/img/'+datos['recurso']);


        $("#fechaNacioU").val(datos['fecha_nacimiento']);
        $("#fechaFallecio").val(datos['fecha_ocurrencia']);
        $("#sexoFallecio").val(datos['sexo']);
        $("#horaDefuncion").val(datos['hora_defuncion']);
        $("#idDifunto").val(datos['id_defuncion']);

      });


       /* funciones agregar Ubicacion */
     $('#formAgregarUbicacion').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: 'ubicacion/asignarUbicacion',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAsignarUbicacion').modal('hide');
                $('#formAgregarUbicacion')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego registro de Municipio!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });


     /* funciones cargar los datos en el modal Editar Asignacion Descanso*/
     $("#table").on("click",".btnEditarAsignacion", function(){
        var datos = JSON.parse($(this).attr('data-asignado'));
        console.log(datos);
        $("#nombreCompletoUP").val(datos['primer_nombre']+' '+datos['segundo_nombre']+' '+datos['primer_apellido']+' '+datos['segundo_apellido']);
        $("#cedulaUP").val(datos['cedula']);

        $("#edadFallecioUP").val(datos['edad_cumplida']);
        $("#sexoFallecioUP").val(datos['sexo']);
        $("#imgRecuerdoUP").attr("src",'../Views/plantilla/assets/img/'+datos['recurso']);


        $("#fechaNacioUUP").val(datos['fecha_nacimiento']);
        $("#fechaFallecioUP").val(datos['fecha_ocurrencia']);
        $("#sexoFallecioUP").val(datos['sexo']);

        $("#idUbicacionUP").val(datos['id_ubicacion']);
        $("#cemterioDescansaUP").val(datos['cementerio_id_cementerio']);
        $("#latitudUbicacionUP").val(datos['latitud']);
        $("#longitudUbicacionUP").val(datos['longitud']);
        $("#descripcionLugarUP").val(datos['descripcion_lugar']);
        $("#idDefUp").val(datos['defuncion_id_defuncion']);

      });

       /* funciones actulizar asignacion ubicacion */
     $('#formActualizarUbicacion').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: '../ubicacion/editarUbicacion',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalEditarAsignacion').modal('hide');
                $('#formActualizarUbicacion')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego registro de Municipio!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });

     /* funcion borrar ubicacion */
     $("#table").on("click",".btBorrarUbicacion",function(){
        Swal.fire({
            title: 'Estas seguro?',
            text: "No podrá recuperar los datos!",
            icon: 'warning',
            confirmButtonColor: '#d9534f',
            cancelButtonColor: '#428bca',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: 'Sí, Eliminarlo!',
            cancelButtonText: 'No, cancelar',
            reverseButtons:true
        }).then((result)=>{
            if(result.isConfirmed){
                var idUbicacion=$(this).attr('data-borrarUbicacion');
    
                $.ajax({
                    url:'../ubicacion/borrarUbicacion/',
                    type:"POST",
                    data:{'idUbicacion':idUbicacion},
                    success:function(respuesta){
                        $("#table").DataTable().destroy();
                        $("#table tbody").html(respuesta);
                        inicializarDataTable();
                            Swal.fire(
                            'Borrado',
                            'El registro a sido eliminado',
                            'success'
                            )
    
                        
                    }
                });
    
    
    
                
    
    
            }
            else if (
                result.dismiss === Swal.DismissReason.cancel
              ){
                Swal.fire(
                'cancelado',
                'el registro esta a salvo',
                'error'
        
                )
        
              }
    
        });
    
    
    });


    /* ------------------------------
        ------------------------------
          *   Funciones Mapa Cargar Perfiles  *
        ------------------------------
        ------------------------------
     */



    $("#map").on("click",".btnVerPerfil",function(e){
        let id=JSON.parse($(this).attr('data-verPerfil'));
        e.preventDefault();
        $.ajax({
            url:'mapa/cargarPerfil/',
            type:'post',
            data:{'id':id},
            success:function(respuesta){
               
           console.log(respuesta); 
           $('#modalPerfil .modal-body').html(respuesta);
              
        
            }
        
        
        
        
        });
    
    
    
    });


     /* ------------------------------
        ------------------------------
          *   Funciones Cargar Perfiles en Buscar*
        ------------------------------
        ------------------------------
     */



        $("#table").on("click",".btBuscarPerfil",function(e){


            let id=JSON.parse($(this).attr('data-idPersona'));
            e.preventDefault();
             $.ajax({
                url:'buscar/cargarPerfil/',
               type:'post',
               data:{'id':id},
                success:function(respuesta){
                   
              console.log(respuesta); 
               $('#modalPerfilBuscar .modal-body').html(respuesta);
               
            
               }
            
            
            
            
            });
        
        
        
        });

    /* ------------------------------
        ------------------------------
          *   Funciones Servicios  *
        ------------------------------
        ------------------------------
     */



    
       /* funciones agregar Servicios */
       $('#formAgregarServicio').submit(function (e) {
        e.preventDefault();
        var extension=$("#imagenServicio").val().split('.').pop().toLowerCase();;
        console.log(extension);
        if(extension != '')
          {
           if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
           {
            alert("Invalid Image File");
            $('#imagenServicio').val('');
            return false;
           }
          } 
        $.ajax({
            url: 'servicios/agregarServicio',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarServicio').modal('hide');
                $('#formAgregarServicio')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego registro de Municipio!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });
    


    /* ------------------------------
        ------------------------------
          *   Funciones operarios  *
        ------------------------------
        ------------------------------
     */



    
       /* funciones agregar operario */
       $('#formAgregarOperario').submit(function (e) {
        e.preventDefault();
        var extension=$("#fotoOperario").val().split('.').pop().toLowerCase();;
        console.log(extension);
        if(extension != '')
          {
           if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
           {
            alert("Invalid Image File");
            $('#fotoOperario').val('');
            return false;
           }
          } 
        $.ajax({
            url: 'operario/agregarOperario',
            type: 'post',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $('#modalAgregarOperario').modal('hide');
                $('#formAgregarOperario')[0].reset();
                $("#table").DataTable().destroy();
                $("#table tbody").html(respuesta);
                inicializarDataTable();
                Swal.fire({
                    title: "Se agrego registro de Operario!",
                    text: "con exito!",
                    icon: "success"
                  });
                
            }


        });
    });







});




function ocultarPass(elemento,icono){
    let input=document.getElementById(elemento);
    if(input.type==="password"){
        input.type="text";
        icono.classList.remove("fa-eye");
        icono.classList.add("fa-eye-slash");
    } else {
        input.type="password";
        icono.classList.remove("fa-eye-slash");
        icono.classList.add("fa-eye");
    }
}

$("#municipioOrigen").prop("disabled", true);

 /* funciones defunciones departamento nacimiento carga los municipios */

 $('#departamentoOrigen').on("change", function () {
    let idDepartamento = $('#departamentoOrigen').val();
    console.log(idDepartamento);
    $.ajax({
        url: '../defunciones/cargarMunicipio',
        type: 'post',
        data: { 'idDepartamento': idDepartamento },
        success: function (respuesta) {
            $("#municipioOrigen").prop("disabled", false);
            $("#municipioOrigen").html(respuesta);
            console.log(respuesta);
        }
    });
});



 /* funciones defunciones departamento defuncion carga los municipios */
 $("#municipioDefuncion").prop("disabled", true);
$('#departamentoDefuncion').on("change", function () {
    let idDepartamento = $('#departamentoDefuncion').val();
    console.log(idDepartamento);
    $.ajax({
        url: '../defunciones/cargarMunicipio',
        type: 'post',
        data: { 'idDepartamento': idDepartamento },
        success: function (respuesta) {
            $("#municipioDefuncion").prop("disabled", false);
            $("#municipioDefuncion").html(respuesta);
            console.log(respuesta);
        }
    });
});


/* Funcion para calcular edad automaticamente defuncion*/
$('#fechaNacio, #fechaDefuncion').on('change', function() {
    const fechaNacio = $('#fechaNacio').val();
    const fechaDefuncion = $('#fechaDefuncion').val();

    if (fechaNacio && fechaDefuncion) {
        const edad = calcularEdad(fechaNacio, fechaDefuncion);
        $('#edadCumplida').val(edad);
    } else {
        $('#edadCumplida').val('');
    }
});

function calcularEdad(fechaNac, fechaDef) {
    const nacimiento = new Date(fechaNac);
    const defuncion = new Date(fechaDef);
    let edad = defuncion.getFullYear() - nacimiento.getFullYear();
    const m = defuncion.getMonth() - nacimiento.getMonth();
    
    // Ajustar la edad si el cumpleaños no ha ocurrido aún en el año de la defunción
    if (m < 0 || (m === 0 && defuncion.getDate() < nacimiento.getDate())) {
        edad--;
    }

    return edad;
}
  $("#edadCumplida").prop("disabled", true);
  
 


// Inicializacion de select 2 para cargar las causas
$('.js-example-basic-single').select2();


$('#cemterioDescansa').select2({
    dropdownParent: $('#modalAsignarUbicacion'),
    theme: "classic" // Asegúrate de que se muestre dentro del modal
});

$('#horaDefuncion').change(function(){
console.log($('#horaDefuncion').val());
});



 /* funciones para cargar resultados segun la busqueda */

 
$("#buscar").on("keyup",function(){
    var bus=$("#buscar").val();
    if(bus.length>=3){
        console.log(bus);
    $.ajax({
    url:"buscar/busqueda/",
    type:'POST',
    data:{'bus':bus},
    success:function(resultado){
    $("#table").DataTable().destroy();
    $("#table tbody").html(resultado);
    
    inicializarDataTable();
    
    }  
    });
    }
    else if(bus.length==0){
        $("#table").DataTable().destroy();
        $("#table tbody").empty();
        inicializarDataTable();
    }



});



function inicializarDataTable(){
     /* Inicializacion del dataTable con traducciones botones de imprimir excel y generar pdf, ademas del responsive */
 $('#table').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'excel', 'pdf', 'print'
    ],
    language: {
        url: 'https://cdn.datatables.net/plug-ins/2.1.5/i18n/es-MX.json',
    },
    responsive: true

});

}



Fancybox.bind("[data-fancybox]", {
    // Your custom options
  });
          // Opciones adicionales, si las necesitas
  
