<?php

namespace App\Controller;

use App\Entity\Emoji;
use App\Service\OpenWeatherMap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DefaultController extends AbstractController
{

    /**
     *@Route("/", name="index")
    */
    public function index(){
        return $this->redirectToRoute('weather');
    }



    /**
     * @Route("/weather/{?city}", name="weather", requirements={"city"="[a-zA-Z]*"})
     */
    public function weather(OpenWeatherMap $openWeatherMap, ? String $city, ParameterBagInterface $params)
    {
        if($city)
        {
            $weather = $openWeatherMap->getWeather($city, $params);
        }
        else
        {
            $weather = null;
        }

        return $this->render('weather/city.html.twig', ['city' => $city, 'weather' => $weather]);
    }
}
