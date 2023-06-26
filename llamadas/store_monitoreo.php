<?php
session_start();
//if (isset($_SESSION['user'])) {
ini_set('max_execution_time', 0);
require_once('PhpSpreadsheet/vendor/autoload.php');


$serverName = "implementta.mx";
$connectionInfo = array('Database' => 'implementtaMexicaliA', 'UID' => 'sa', 'PWD' => 'vrSxHH3TdC');
$cnx = sqlsrv_connect($serverName, $connectionInfo);
date_default_timezone_set('America/Mexico_City');


use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
// echo $_FILES['Rmonitoreo']['name'];
$extencion1 = explode(".", $_FILES['Rmonitoreo']['name']);
$extencion2 = explode(".", $_FILES['monitoreoI']['name']);

if (($extencion1[1] == 'xls' || $extencion1[1] == 'xlsx' || $extencion1[1] == 'csv') and ($extencion2[1] == 'xls' or $extencion2[1] == 'xlsx' or $extencion2[1] == 'csv')) {

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_FILES['Rmonitoreo']) and isset($_FILES['monitoreoI'])) {
            if ($_POST['mes'] != 0) {
                $tmpName_Rmonitoreo = $_FILES['Rmonitoreo']['tmp_name'];
                $tmpName_monitoreoI = $_FILES['monitoreoI']['tmp_name'];

                $spreadsheet1 = \PhpOffice\PhpSpreadsheet\IOFactory::load($tmpName_Rmonitoreo);
                $spreadsheet1 = $spreadsheet1->getActiveSheet();
                $data_array1 =  $spreadsheet1->toArray();
                $spreadsheet2 = \PhpOffice\PhpSpreadsheet\IOFactory::load($tmpName_monitoreoI);
                $spreadsheet2 = $spreadsheet2->getActiveSheet();
                $data_array2 =  $spreadsheet2->toArray();
                if (trim($data_array1[0][0])=='Numero de Cuenta' && trim($data_array1[0][1])=='Fileout'){
                    if (trim($data_array2[0][0])=='Fecha' && trim($data_array2[0][1])=='Hora'
                    && trim($data_array2[0][2])=='Origen' && trim($data_array2[0][3])=='Destino'
                    && trim($data_array2[0][4])=='Duración' && trim($data_array2[0][5])=='Tipo'
                    && trim($data_array2[0][6])=='Fileout'){
                        Rmonitoreo($tmpName_Rmonitoreo, $cnx,$tmpName_monitoreoI);
                    }else{
                        header('Location: ../index.php?error_headers=1');
                        }
                }
                else{
                    header('Location: ../index.php?error_headers=1');
                }
            } else {
                header('Location: ../index.php?error_mes=1');
            }
        } else {
            header('Location: ../index.php?error_archivo=1');
        }
    } else {
        header('Location: ../index.php?error=1');
    }
} else {
    header('Location: ../index.php?error_archivo=1');
}

    // funcion para cargar Rmonitoreo
    function Rmonitoreo($tmpName, $cnx, $tmpName_monitoreoI)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($tmpName);
        $spreadsheet = $spreadsheet->getActiveSheet();
        $data_array =  $spreadsheet->toArray();
        // print_r($data_array[1][0]);
        if (count($data_array) > 1) {
            sqlsrv_query($cnx, "DELETE FROM ReporteMonitoreo;");
            $count = count($data_array);
            if ($count > 1000) {
                $sobrante = $count % 1000;
                $bloques = ceil($count / 1000);
                carga_Rmonitoreo($data_array, $cnx, 1, 1000, $bloques, $sobrante,$tmpName_monitoreoI);
            } else {
                carga_Rmonitoreo($data_array, $cnx, 1, $count, 1, 0, $tmpName_monitoreoI);
            }
        } else {
            header('Location: ../index.php?error_sin_datos=1');
        }
    }
    

    // funcion cagar reportemonitoreo
    function carga_Rmonitoreo($data_array, $cnx, $i, $cantidad, $bloques, $sobrante, $tmpName_monitoreoI)
    {
        // echo $data_array[1][0];
        $query = '';
        $query = 'INSERT INTO ReporteMonitoreo (Cuenta, Fileout) VALUES';
        while ($i < $cantidad) {



            $fileout = $data_array[$i][1];


            $query .= "('" . $data_array[$i][0] . "',";
            $query .= "'" . $fileout . "'), ";

            $i += 1;
            if ($i == $cantidad) {
                $query = substr($query, 0, strlen($query) - 2);
                $query .= ";";
                sqlsrv_query($cnx, $query) or die(print_r(sqlsrv_errors()));
                $bloques -= 1;
                if ($bloques == 1) {
                    $cantidad += $sobrante;
                    carga_Rmonitoreo($data_array, $cnx, $i, $cantidad, $bloques, $sobrante, $tmpName_monitoreoI);
                } elseif ($bloques == 0) {
                    monitoreoI($tmpName_monitoreoI, $cnx);
                } else {
                    $cantidad += 1000;
                    carga_Rmonitoreo($data_array, $cnx, $i, $cantidad, $bloques, $sobrante,$tmpName_monitoreoI);
                }
            }
        }
    }

    // funcion para cargar monitoreoI
    function monitoreoI($tmpName, $cnx)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($tmpName);
        $spreadsheet = $spreadsheet->getActiveSheet();
        $data_array =  $spreadsheet->toArray();
        // print_r($data_array[1][0]);
        if (count($data_array) > 1) {
            sqlsrv_query($cnx, "DELETE FROM MonitoreoIssabel;");
            $count = count($data_array);
            if ($count > 1000) {
                $sobrante = $count % 1000;
                $bloques = ceil($count / 1000);
                carga_monitoreoI($data_array, $cnx, 1, 1000, $bloques, $sobrante);
            } else {
                carga_monitoreoI($data_array, $cnx, 1, $count, 1, 0);
            }
        } else {
            header('Location: ../index.php?error_sin_datos=1');
        }
    }
    
    // funcion cargar a tabla monitoreo Isabel
    function carga_monitoreoI($data_array, $cnx, $i, $cantidad, $bloques, $sobrante)
    {
        $query = '';
        $query = 'INSERT INTO MonitoreoIssabel (Duracion, Fileout) VALUES';
        while ($i < $cantidad) {



            $fileout = ($data_array[$i][6] == '') ? '' :  $data_array[$i][6];


            $query .= "('" . $data_array[$i][4] . "',";
            $query .= "'" . $fileout . "'), ";

            $i += 1;
            if ($i == $cantidad) {
                $query = substr($query, 0, strlen($query) - 2);
                $query .= ";";
                sqlsrv_query($cnx, $query) or die(print_r(sqlsrv_errors()));
                $bloques -= 1;
                if ($bloques == 1) {
                    $cantidad += $sobrante;
                    carga_monitoreoI($data_array, $cnx, $i, $cantidad, $bloques, $sobrante);
                } elseif ($bloques == 0) {
                    // mandar a llamar el store sp_InsertaFileoutLlamada
                    sp_InsertaFileoutLlamada($_POST['mes'], $_POST['anio'], $cnx);
                } else {
                    $cantidad += 1000;
                    carga_monitoreoI($data_array, $cnx, $i, $cantidad, $bloques, $sobrante);
                }
            }
        }
    }

    // funcion para llamar al store
    function sp_InsertaFileoutLlamada($mes, $anio, $cnx)
    {
        // eliminar los registros del mes y anio que se van a subir
        $delete = "DELETE FROM Duracionllamadas WHERE Anio='$anio' and Mes='$mes'";
        sqlsrv_query($cnx, $delete);

        $store = "execute [dbo].[sp_InsertaFileoutLlamada] '$mes','$anio'";
        $st = sqlsrv_query($cnx, $store) or die('Execute Stored Procedure Failed... Query store_monitoreo.php [sp_InsertaFileoutLlamada]');
        $resultSt = sqlsrv_fetch_array($st);
        if ($resultSt['resultado'] != 1) {

            header('Location: ../index.php?error_store=1');
        } else {
            header('Location: ../index.php?datos_guardados=1');
        }
        header('Location: ../index.php?datos_guardados=1');
    }
    /*}else{
        echo '<meta http-equiv="refresh" content="0,url=../logout.php">';
    }*/

