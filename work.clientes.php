<?php


include 'conexion_minka.php';


$query = "SELECT dpa_despar, ST_AsGeoJSON(geom) FROM pichincha_parroquias where gid = 65";
$query = "SELECT dpa_despar, ST_AsGeoJSON(geom) FROM pichincha_parroquias ";


$query =   "SELECT latitude, longitude
            from coord_client_cayambe
            where cuenta in (select cuenta
            from data_client_cayambe
            where marc_medi='SHE');";


$query =   "SELECT * FROM coord_client_cayambe 
            LEFT OUTER JOIN data_client_cayambe
            ON data_client_cayambe.cuenta = coord_client_cayambe.cuenta
            where marc_medi='SHE'
            LIMIT 10;";

$query =   "SELECT * FROM coord_client_cayambe 
            LEFT OUTER JOIN data_client_cayambe
            ON data_client_cayambe.cuenta = coord_client_cayambe.cuenta
            where marc_medi='SHE';";

$query =   "SELECT * FROM coord_client_cayambe 
            LEFT OUTER JOIN data_client_cayambe
            ON data_client_cayambe.cuenta = coord_client_cayambe.cuenta;";
    
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
    $array = array();

    //$array['type'] = 'Feature';
    $array['type'] = 'Feature';
    
    $array['geometry'] = array
    (
      'type' => "Point",
      'coordinates' => array(
        $row["longitude"],
        $row["latitude"])
    );
    
    $array['properties'] = array(
      'name' => $row["nombre"]);
    
    $json = json_encode($array, JSON_PRETTY_PRINT);
    
    
    //echo '<pre>';
    //echo $json;
    //echo '</pre>';

    //$arreglo = $row["nombre"];
    //$jsonobj = $row["st_asgeojson"];

    //$arr = json_decode($jsonobj, true);



    //array_push($mapsarray,$arr);
    $currentvalue = $json.",";
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
