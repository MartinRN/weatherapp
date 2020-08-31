<?php

namespace App\Controller;

use App\Entity\Emoji;
use App\Service\OpenWeatherMap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/weather/{city}", name="weather", requirements={"city"="[a-zA-Z]*"})
     */
    public function weather(OpenWeatherMap $openWeatherMap, ? String $city)
    {
        if($city)
        {
            $weather = $openWeatherMap->getWeather($city);
            /*$repoEmoji = $this->getDoctrine()->getRepository(Emoji::class);
            $emoji = $repoEmoji->findOneByName($weather);
            $emojiCode = $emoji->getCode();
            $emojiCode = '&#'.$emojiCode.';';*/

        }
        else
        {
            $weather = null;
        }

        return $this->render('weather/city.html.twig', ['city' => $city, 'weather' => $weather, 'emoji' => ""]);
    }
}
