<?php
header('Content-Type: application/json; charset=utf-8');
clearstatcache();
$params = array();
$params_raw = file_get_contents('php://input');
parse_str($params_raw, $params);

$key = '안알랴줌';
$url = 'http://api.openweathermap.org/data/2.5/onecall?lat='.$params['x'].'&lon='.$params['y'].'&exclude=minutely,hourly&units=metric&APPID='.$key;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data0 = json_decode($response, true);

echo '{';

/* 현재 날씨 */
$data = $data0['current'];
echo '"current":{';
echo '"status":"'.$data['weather'][0]['main'].'",';
echo '"temp":"'.$data['temp'].'℃",';
echo '"temp_wind":"'.$data['feels_like'].'℃",';
echo '"hum":"'.$data['humidity'].'%",';
echo '"wind_speed":"'.$data['wind_speed'].'m/s",';
echo '"wind_dir":"'.deg2dir($data['wind_deg']).'"';
echo '},';

/* 주간 날씨 */
$data = $data0['daily'];
$days = array('오늘', '내일', '모래', '글피', '5일 뒤', '6일 뒤');
echo '"weekly":[';
for($n = 0; $n < count($days); $n++) {
    if ($n > 0) echo ",";
    echo '{';
    echo '"date":"'.$days[$n].'",';
    echo '"status":"'.$data[$n]['weather'][0]['main'].'",';
    echo '"temp_min":"'.$data[$n]['temp']['min'].'℃",';
    echo '"temp_max":"'.$data[$n]['temp']['max'].'℃",';
    echo '}';
}
echo ']';

echo '}';

function deg2dir($deg){
    $dirs = array('북', '북동', '동', '남동', '남', '남서', '서', '북서', '북');
    $dir = ($deg + 22.5) / 45;
    return $dirs[$dir].'풍';
}

?>
