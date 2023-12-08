<?php 


function Clima ($ciudad){
    $msg = '';
    $ciudadClima = '';
    $status='';
    $ciudadClima = $ciudad;
    $url = "https://api.openweathermap.org/data/2.5/weather?q="
    .$ciudadClima."&appid=83177a230ed6391b46520af268ae01df";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result=json_decode($result,true);

    if ($result["cod"] == 200){
        $status = "si";
    }else{
        $msg = $result["message"];
        echo $msg;
        }

    if($status == 'si'){

        $imclima="http://openweathermap.org/img/wn/".$result['weather'][0]['icon']."@4x.png";
        $temperatura= $result['main']['temp']-272.15;
        $humedad=$result['main']['humidity'];
        $datosTiempo = [$imclima,$temperatura,$humedad];
        return $datosTiempo;
    }
    
}




?>