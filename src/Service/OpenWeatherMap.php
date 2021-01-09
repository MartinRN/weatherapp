<?php


namespace App\Service;


use App\Entity\City;
use Symfony\Component\HttpClient\ScopingHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenWeatherMap
{
    private $openweatherchannel;

    public function __construct(HttpClientInterface $openweatherchannel)
    {
        $this->openweatherchannel = $openweatherchannel;
    }

    public function getWeather(?String $city)
    {
        $defaultUrl = "http://api.openweathermap.org/data/2.5/weather?APPID=e6b30269a76ed8b80cdee26aaabffc74&units=metric";
        $defaultUrl.= "&q=".$city;
        $response = $this->openweatherchannel->request('GET', $defaultUrl);
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

}