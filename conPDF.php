<?php
 
class myPDF {
    public $mysqli = null;
 
    public function __construct() {
 
        include_once 'conexion.php';
		include_once 'includes/config.php';
        $this->mysqli = new conexj();
 
        if ($this->mysqli->connect_errno) {
            echo "Error MySQLi: ("&nbsp. $this->mysqli->connect_errno.") " . $this->mysqli->connect_error;
            exit();
        }
        $this->mysqli->set_charset("utf8");
    }
 
    public function __destruct() {	
        $this->CloseDB();
    }
 
    public function runQuery($qry) {
        $result = $this->mysqli->query($qry);
        return $result;
    }
 
    public function seleccionar_datos($cod,$ci)
    {
        $q = "select concat(r.nombres,' ',r.apellidos) as nombre,
		concat(r.ci,' ',d.ext_dep) as carnet,
        r.email, 
        (select nombre_dep from departamentos where id_dep=r.dpto) as dpto,
        case when r.profesion=0 then r.otraprofesion else (select nombre_prof from profesiones where id_prof=r.profesion) end as prof,
        r.fono,
        concat(substring(r.nombres,1,1),substring(r.apellidos,1,1),r.ci) as usuario,
        r.nit,
        r.razonsocial,
        case when r.institucion=0 then r.otrainstitucion else (select nombre_inst from institucion where id_inst=r.institucion) end as inst,
        date_format(i.f_inscripcion,'%d/%m/%Y') as f_inscripcion,
        i.id_pago,
        date_format(p.fecha_pago,'%d/%m/%Y') as f_pago,
        date_format(p.fecha_registro,'%d/%m/%Y %H:%i:%s') as f_registro
 		from registrados r left join inscritos i on r.ci=i.ci left join pagos p on i.id_pago=p.id_pago left join departamentos d on r.extension=d.id_dep where cod_inscripcion='".$cod."' and r.ci='".$ci."'";
 
        $result = $this->mysqli->query($q);
 
        //Array asociativo que contendrá los datos
        $valores = array();
 
        if( $result->num_rows == 0)
        {
            echo'<script type="text/javascript">
                alert("No se encontraron registros, favor verifique la dirección.");
                </script>';
        }
 
        else{
 
            while($row = mysqli_fetch_assoc($result))
            {
                //Se crea un arreglo asociativo
                array_push($valores, $row);
            }
        }
        //Regresa array asociativo
        return $valores;
    }
}
?>