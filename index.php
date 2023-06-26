<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Panel de Control</title>
  <link rel="icon" href="icono/implementtaIcon.png">
  <link rel="stylesheet" href="public/css/bootstrap.css">
  <link href="public/css/styles.css" rel="stylesheet" />
  <link href="public/fontawesome/css/all.css" rel="stylesheet">
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <script src="sweetalert/alertas.js"></script>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" id="theme-styles">

  <style>
    body {
      background-image: url(public/img/back.jpg);
      background-repeat: repeat;
      background-size: 100%;
      background-attachment: fixed;
      overflow-x: hidden;
      
      /* ocultar scrolBar horizontal*/
    }

    body {
      font-family: sans-serif;
      font-style: normal;
      font-weight: normal;
      width: 100%;
      height: 100%;
      margin-top: -1%;
      margin-bottom: 0%;
      padding-top: 0px;
    }

    
  </style>


  <br>
  <nav class="navbar navbar-expand-lg navbar-light">
    <a href="#"><img src="public/img/logoImplementtaHorizontal.png" width="250" height="82" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


      </ul>


    </div>
  </nav>
  <!--*************************************NAVBAR*************************************************************-->

</head>

<body>
  <?php if (isset($_GET['error_archivo'])) { ?>
    <script>
      error('solo se admiten archivos con extencion xlsx,xls,csv')
    </script>;
  <?php } ?>
  <?php if (isset($_GET['error_headers'])) { ?>
    <script>
      error('Los Archivos deben ser exactamente igual a las plantillas')
    </script>;
  <?php } ?>
  <?php if (isset($_GET['error_mes'])) { ?>
    <script>
      error('selecciona un mes valido')
    </script>;
  <?php } ?>
  <?php if (isset($_GET['error'])) { ?>
    <script>
      error('Error de peticion, intentelo nuevamente')
    </script>;
  <?php } ?>
  <?php if (isset($_GET['error_sin_datos'])) { ?>
    <script>
      error('el archivo no tienen datos')
    </script>;
  <?php } ?>
  <?php if (isset($_GET['error_store'])) { ?>
    <script>
      error('el archivo no tienen datos')
    </script>;
  <?php } ?>
  <?php if (isset($_GET['datos_guardados'])) { ?>
    <script>
      compilado('Datos Guardados Correctamente')
    </script>;
  <?php } ?>

  <div class=" row">

    <div class="container col-md-4 ">
      <div class="mt-4">
        <h2 style="text-shadow: 0px 0px 2px #717171;"><img src="https://img.icons8.com/fluency/47/document.png" />
          Reporte de Llamadas</h2>
        <h4 style="text-shadow: 0px 0px 2px #717171;">Mexicali Agua</h4>
      </div>
      <hr>
      <div class="p-1 mx-auto">
      <form action="./llamadas/store_monitoreo.php" method="POST" onsubmit="javascript:loadInfo_llamadas();" autocomplete="off" enctype="multipart/form-data">
          <!-- contenedor 1 -->
          <div class="p-2 rounded-4 col-md-12" style=" background-color: #E8ECEF; border: inherit;">
            <div class="text-white m-2 align-items-end" style="text-align:right;">
              <span class="badge badge-pill badge-info"><img src="https://img.icons8.com/fluency/30/000000/user-manual.png" />Cargar Excel duración de llamadas</span>
            </div>


            <div class="row align-items-start form-row">
              <div class="col-md-8">
                <label for="formFileSm" class="form-label">Reporte Monitoreo:*</label>
                <input class="form-control form-control-sm" name="Rmonitoreo" id="Rmonitoreo" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
              </div>

              <div class="col-md-4">
                <label for="formFileSm" class="form-label">Descargar Plantilla</label>
                <a href="llamadas/plantilla_monitoreo.xlsx" download="" class="btn btn-info btn-sm" title="Descargar Plantilla Reporte Monitore" style="width: 90%;"><i class="fa fa-download"></i> Reporte Monitoreo</a>
              </div>
            </div>
            <br>
            <div class="row align-items-start form-row">
              <div class="col-md-8">
                <label for="formFileSm" class="form-label">Monitoreo Isabel:*</label>
                <input class="form-control form-control-sm" name="monitoreoI" id="monitoreoI" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
              </div>

              <div class="col-md-4">
                <label for="formFileSm" class="form-label">Descargar Plantilla</label>
                <a href="llamadas/plantilla_isabel.xlsx" download="" class="btn btn-info btn-sm" title="Descargar Plantilla Monitoreo Isabel" style="width: 90%;"><i class="fa fa-download"></i> Monitoreo Isabel</a>
              </div>
            </div>
            <br>

            <div class="row align-items-start form-row">
              <div class="col-md-6">
                <label for="cuenta" class="form-label mb-2">Mes a subir:*</label>
                <select class="form-select form-select-sm" name="mes" aria-label=".form-select-sm example" required>
                  <option selected value=0>-- selecciona una opción --</option>
                  <option value=1>Enero</option>
                  <option value=2>Febrero</option>
                  <option value=3>Marzo</option>
                  <option value=4>Abril</option>
                  <option value=5>Mayo</option>
                  <option value=6>Junio</option>
                  <option value=7>Julio</option>
                  <option value=8>Agosto</option>
                  <option value=9>Septiembre</option>
                  <option value=10>Octubre</option>
                  <option value=11>Noviembre</option>
                  <option value=12>Diciembre</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="cuenta" class="form-label mb-2">Anio:*</label>
                <input type="number" value="<?php echo date('Y') ?>" class="form-control form-control-sm" name="anio">
              </div>
            </div>
          </div>


          <div class="form-row p-4">
            <div class="col">
              <div style="text-align:right;">
              
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Subir Archivos</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="public/js/scripts.js"></script>
  <script>
    // alert carga llamadas
    var loadInfo_llamadas = function() {
      Swal.fire({
        title: 'Insertando Datos',
        html: 'Espere un momento',
        timer: 0,
        timerProgressBar: true,
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
        willClose: () => {
          return false;
        }
      }).then((result) => {});
    }
  </script>

</body>

<script src="public/js/jquery-3.4.1.min.js"></script>
<script src="public/js/popper.min.js"></script>
<script src="public/js/bootstrap.js"></script>
<script>
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>

</html>