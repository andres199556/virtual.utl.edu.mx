<?php
include "../conexion/conexion.php";
include "../funciones/get_name_module.php";
include "../sesion/validar_sesion.php";
include "../sesion/validar_permiso.php";
$id = $_POST["id"];
$resultado = array();
//busco los nodos
try{
    $buscar = $conexion->query("SELECT
	id_nodo,
	posicion,
	concat(SUBSTRING_INDEX(P.nombre,' ',1),' ',P.ap_paterno) as trabajador,
	PU.puesto AS puesto,
	CONCAT( '../', P.fotografia ) AS fotografia,
    NOR.color
FROM
	nodos_organigramas AS NOR
	INNER JOIN trabajadores AS T ON NOR.id_trabajador = T.id_trabajador
	INNER JOIN personas AS P ON T.id_persona = P.id_persona
	INNER JOIN puestos AS PU ON NOR.id_puesto = PU.id_puesto 
WHERE
    id_organigrama = $id");
    $nodos = array();
    $cantidad = $buscar->rowCount();
    if($cantidad == 0){
        //no existen nodos
        $resultado["resultado"] = "primer_nodo";
        $resultado["mensaje"] = "Todavía no existen nodos dentro del organigrama";
    }
    else{
        $resultado["resultado"] = "existe";
        $resultado["data"] = array();
        while($row = $buscar->fetch(PDO::FETCH_ASSOC)){
            $data = array(
                "id" => $row["id_nodo"],
                "text" => $row["puesto"],
                "title" => $row["trabajador"],
                "img" => $row["fotografia"],
                "color" => $row["color"]
            );
            array_push($nodos,array(
                "id" => $row["id_nodo"]."-".$row["posicion"],
                "from" => $row["posicion"],
                "to" => $row["id_nodo"],
                "type" => "line",
                "stroke" => "#7986CB"
            ));
            array_push($resultado["data"],$data);
        };
        if($cantidad != 1){
            $n = 0;
            foreach($nodos as $nodo){
                if($n == 0){

                }
                else{
                    array_push($resultado["data"],$nodo);
                }
                $n++;
                
            }
        }
        $resultado["cantidad"] = $cantidad;
    }
}
catch(PDOException $error){
    $resultado["resultado"] = "error";
    $resultado["mensaje"] = $error->getMessage();
}
echo json_encode($resultado);
?>