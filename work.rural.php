<?php


include 'conexion_minka.php';


$query = "SELECT dpa_despar, ST_AsGeoJSON(geom) FROM pichincha_parroquias where gid = 65 LIMIT 10;";
$query = "SELECT dpa_despar, ST_AsGeoJSON(geom) FROM pichincha_parroquias where gid = 65;";

$query = "SELECT dpa_despar, ST_AsGeoJSON(geom) FROM pichincha_parroquias ";
 

 
    
//$mapsarray[]=array();
$resultado = '{
    "type": "FeatureCollection",
    "features": [';
$result = pg_query($con, $query);
$row_nd = pg_num_rows($result);
 
if ($row_nd == 0) {
    echo "There is no ";
    exit;
}
while ($row = pg_fetch_assoc($result))
{


    
    $arreglo = $row["st_asgeojson"];
    $jsonobj = $row["st_asgeojson"];
    $arr = json_decode($jsonobj, true);

    //$arr["name"] = $row["dpa_despar"];

    $arr['properties'] = array(
        'name' => $row["dpa_despar"]);
    $arr = json_encode($arr, true);
    //array_push($mapsarray,$arr);
    $currentvalue = $arr.",";
    $resultado = $resultado.$currentvalue;
    //$currentvalue = $arr.",";
    //$resultado = $resultado.$currentvalue;
}
 
 
$resultado = substr($resultado, 0, -1);
$resultado = $resultado."]}";
//echo $resultado;
echo $resultado;
 
    
pg_close($con);
?>
