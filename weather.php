<?php
header('Content-Type: application/json; charset=utf-8');
clearstatcache();
$params = array();
$params_raw = file_get_contents("php://input");
parse_str($params_raw, $params);

$key = '안알랴줌';
$url = 'http://api.openweathermap.org/data/2.5/onecall?lat='.$params['x'].'&lon='.$params['y'].'&exclude=current,minutely,hourly&units=metric&APPID='.$key;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$data = $data['daily'];
$days = array("오늘", "내일", "모래");

echo '[';
for($n = 0; $n < count($days); $n++) {
    if ($n > 0) echo ",";
    echo '{';
    echo '"date":"'.$days[$n].'",';
    echo '"status":"'.$data[$n]['weather'][0]['main'].'",';
    echo '"icon":"https://openweathermap.org/img/wn/'.$data[$n]['weather'][0]['icon'].'@4x.png",';
    echo '"temp_min":"'.$data[$n]['temp']['min'].'℃",';
    echo '"temp_max":"'.$data[$n]['temp']['max'].'℃",';
    echo '"hum":"'.$data[$n]['humidity'].'%",';
    echo '"wind_speed":"'.$data[$n]['wind_speed'].'m/s",';
    echo '"wind_dir":"'.deg2dir($data['wind_deg']).'℃",';
    echo '}';
}
echo ']';

function deg2dir($deg){
    $dirs = array('북', '북동', '동', '남동', '남', '남서', '서', '북서', '북');
    $dir = ($deg + 22.5) / 45;
    return $dirs[$dir].'풍';
}

?>
