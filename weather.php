<?php
header('Content-Type: application/json; charset=utf-8');
clearstatcache();
$params = array();
$params_raw = file_get_contents('php://input');
parse_str($params_raw, $params);

$key = '안알랴줌';
$url = 'http://api.openweathermap.org/data/2.5/onecall?lat='.$params['x'].'&lon='.$params['y'].'&exclude=minutely,hourly&units=metric&APPID='.$key;

/* 날씨 API 요청 */
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data0 = json_decode($response, true);

/* 날씨 상태 id에 대응되는 상태 */
$status = array();
$status[200] = array("뇌우", "약간의 비를 동반한 천둥구름", 6);
$status[201] = array("뇌우", "비를 동반한 천둥구름", 6);
$status[202] = array("뇌우", "폭우를 동반한 천둥구름", 6);
$status[210] = array("뇌우", "약한 천둥구름", 6);
$status[211] = array("뇌우", "천둥구름", 6);
$status[212] = array("뇌우", "강한 천둥구름", 6);
$status[221] = array("뇌우", "불규칙적 천둥구름", 6);
$status[230] = array("뇌우", "약한 연무를 동반한 천둥구름", 6);
$status[231] = array("뇌우", "연무를 동반한 천둥구름", 6);
$status[232] = array("뇌우", "강한 이슬비를 동반한 천둥구름", 6);

$status[300] = array("이슬비", "가벼운 이슬비", 3);
$status[301] = array("이슬비", "이슬비", 3);
$status[302] = array("이슬비", "강한 이슬비", 3);
$status[310] = array("이슬비", "가벼운 적은비", 3);
$status[311] = array("이슬비", "적은비", 3);
$status[312] = array("이슬비", "강한 적은비", 3);
$status[313] = array("이슬비", "소나기와 이슬비", 3);
$status[314] = array("이슬비", "강한 소나기와 이슬비", 3);
$status[321] = array("소나기", "소나기", 3);

$status[500] = array("비", "악한 비", 3);
$status[501] = array("비", "중간 비", 3);
$status[502] = array("비", "폭우", 3);
$status[503] = array("비", "강한 폭우", 3);
$status[504] = array("비", "매우 강한 폭우", 3);
$status[511] = array("우박", "우박", 7);
$status[520] = array("소나기", "약한 소나기", 3);
$status[521] = array("소나기", "소나기");
$status[522] = array("소나기", "강한 소나기", 3);
$status[531] = array("소나기", "불규칙적 소나기", 3);

$status[600] = array("눈", "적은 눈", 5);
$status[601] = array("눈", "눈", 5);
$status[602] = array("눈", "폭설", 5);
$status[611] = array("진눈깨비", "진눈깨비", 4);
$status[612] = array("진눈깨비", "소낙성 진눈깨비", 4);
$status[615] = array("눈 또는 비", "적은 눈 또는 비", 4);
$status[616] = array("눈 또는 비", "눈 또는 비", 4);
$status[620] = array("눈", "약한 소나기눈", 5);
$status[621] = array("눈", "소나기눈", 5);
$status[622] = array("눈", "많은 소나기눈", 5);

$status[701] = array("옅은 안개", "박무, 옅은 안개", 9);
$status[711] = array("연기", "연기, 매연", 9);
$status[721] = array("연무", "먼지 등이 포함된 안개", 9);
$status[731] = array("먼지", "먼지 또는 모래가 포함된 회오리바람", 9);
$status[741] = array("안개", "안개", 9);
$status[751] = array("모래", "모래", 9);
$status[761] = array("먼지", "먼지", 9);
$status[762] = array("재", "화산재", 9);
$status[771] = array("돌풍", "돌풍", 8);
$status[781] = array("토네이도", "토네이도", 10);

$status[800] = array("맑음", "맑은 하늘", 0);
$status[801] = array("구름 조금", "구름 조금", 1);
$status[802] = array("구름", "드문드문 구름이 낀 하늘", 1);
$status[803] = array("구름 많음", "구름이 조금 많은", 2);
$status[804] = array("흐림", "흐린 하늘", 2);

$status[900] = array("토네이도", "토네이도", 10);
$status[901] = array("태풍", "태풍", 11);
$status[902] = array("허리케인", "허리케인", 11);
$status[903] = array("한파", "한파", 12);
$status[904] = array("폭염", "폭염", 13);
$status[905] = array("바람", "바람", 8);
$status[906] = array("우박", "우박", 7);
$status[951] = array("고요", "바람이 거의 없음", 14);
$status[952] = array("약한 바람", "약한 바람", 8);
$status[953] = array("부드러운 바람", "부드러운 바람", 8);
$status[954] = array("바람", "중간 세기 바람", 8);
$status[955] = array("바람", "신선한 바람", 8);
$status[956] = array("강풍", "센 바람", 8);
$status[957] = array("강풍", "돌풍에 가까운 센 바람", 8);
$status[958] = array("돌풍", "돌풍", 8);
$status[959] = array("돌풍", "심각한 돌풍", 8);
$status[960] = array("폭풍", "폭풍", 8);
$status[961] = array("폭풍", "강한 폭풍", 8);
$status[962] = array("허리케인", "허리케인", 11);


/* API 결과 출력하는 부분 시작 */
echo '{';

/* 현재 날씨 */
$data = $data0['current'];
$id = $data['weather'][0]['id'];
echo '"current":{';
echo '"status":"'.$status[$id][0].'",';
echo '"icon":"'.status2icon($status[$id][2]).'",';
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
    $id = $data[$n]['weather'][0]['id'];
    if ($n > 0) echo ",";
    echo '{';
    echo '"date":"'.$days[$n].'",';
    echo '"status":"'.$status[$id][1].'",';
    echo '"icon":"'.status2icon($status[$id][2]).'",';
    echo '"temp_min":"'.$data[$n]['temp']['min'].'℃",';
    echo '"temp_max":"'.$data[$n]['temp']['max'].'℃"';
    echo '}';
}
echo ']';

/* 끝 */
echo '}';

/* 각도 -> 풍향 변환 */
function deg2dir($deg){
    $dirs = array('북', '북동', '동', '남동', '남', '남서', '서', '북서', '북');
    $dir = ($deg + 22.5) / 45;
    return $dirs[$dir].'풍';
}

/* 날씨 상태 id -> 아이콘 변환 */
function status2icon($id){
$icons = array('sun.gif', 'cloud.gif', 'cloud2.png',
  'rain.gif', 'sleet.gif', 'snow.gif', 'thunder.gif',
  'hail.png', 'wind.gif', 'fog.gif', 'tornado.png',
  'typhon.png', 'cold.png', 'hot.png', 'quite.gif');
return $icons[$id];
}

?>
