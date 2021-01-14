<?php


namespace App\Service;


use App\Entity\City;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class OpenWeatherMap
{
    private $openweatherchannel;

    public function __construct(HttpClientInterface $openweatherchannel)
    {
        $this->openweatherchannel = $openweatherchannel;
    }

    public function getWeather(?String $city, ParameterBagInterface $params)
    {
        $api_key = $params->get('api_key');
        $defaultUrl = "http://api.openweathermap.org/data/2.5/weather?APPID=".$api_key."&units=metric";
        $defaultUrl.= "&q=".$city;
        $response = $this->openweatherchannel->request('GET', $defaultUrl);
        $status = $response->getStatusCode();
        $cityWeather = null;
        if($status == '200'){
            $data = $response->getContent();
            $data = json_decode($data, true);
            $cityWeather = New City();
            $cityWeather->setId(1);
            $cityWeather->setCountry($data['sys']['country']);
            $cityWeather->setIcon('https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/'.$data['weather'][0]['icon'].'.svg');
            $cityWeather->setName($city);
            $cityWeather->setTemperature($data['main']['temp']);
            $cityWeather->setWeather($data['weather'][0]['description']);
            return $cityWeather;
        }
        return $cityWeather;
        
    }

}