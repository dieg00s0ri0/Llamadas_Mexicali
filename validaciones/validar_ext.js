
    function validarExtM() {
      var archivoInput = document.getElementById('Rmonitoreo');
      var files = document.getElementById('Rmonitoreo').files;
      var zero = document.getElementsByName('Rmonitoreo');
      var archivoRuta = archivoInput.value;
      var extPermitidas = /(.xlsx|.xls|.csv)$/i;


      if (!extPermitidas.exec(archivoRuta)) {
        Swal.fire({
          title: '¡Error!',
          text: 'solo se admiten archivos con extencion xlsx,xls,csv',
          icon: 'error',
          showConfirmButton: true
        })
        archivoInput.value = '';
        return false;
      }
      if (zero.length == "") {
        alert("selecciones un archivo");
        return false;
      }

    }





    function validarExtI() {
      var archivoInput = document.getElementById('monitoreoI');
      var files = document.getElementById('monitoreoI').files;
      var zero = document.getElementsByName('monitoreoI');
      var archivoRuta = archivoInput.value;
      var extPermitidas = /(.xlsx|.xls|.csv)$/i;


      if (!extPermitidas.exec(archivoRuta)) {
        Swal.fire({
          title: '¡Error!',
          text: 'solo se admiten archivos con extencion xlsx,xls,csv',
          icon: 'error',
          showConfirmButton: true
        })
        archivoInput.value = '';
        return false;
      }
      if (zero.length == "") {
        alert("selecciones un archivo");
        return false;
      }

    }
 