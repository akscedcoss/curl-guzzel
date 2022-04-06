<?php

use Phalcon\Mvc\Controller;
use GuzzleHttp\Client;

define("BASE_API_URL", 'http://api.weatherapi.com/v1');
define("KEY", '0bab7dd1bacc418689b143833220304');

class IndexController extends Controller
{
    public function getJsonResponseUsingCurl($url)
    {
        // Initialize a CURL session.
        $ch = curl_init();
        //grab URL and pass it to the variable.
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch));
        return $response;
    }


    public function indexAction()
    {

        if ($this->request->isPost()) {
            $searchCity = $this->request->getPost('q');
            $this->response->redirect("index/search/" . $searchCity);
        }
    }
    public function searchAction($key)
    {
        // http://api.weatherapi.com/v1/search.json?key=0bab7dd1bacc418689b143833220304&q=LKO
        echo BASE_API_URL . '/search.json?key=' . KEY . '&q=' . $key;
        $url = BASE_API_URL . '/search.json?key=' . KEY . '&q=' . $key;
        $this->view->res = $this->getJsonResponseUsingCurl($url);
    }
    public function detailAction($city)
    {
        $this->view->city = $city;
        if ($this->request->isPost()) {
            $contr = $this->request->getPost('contr');
            if ($contr == 'Current weather') {
                $url = BASE_API_URL . '/forecast.json?key=' . KEY . '&q=' . $city . '&days=3&aqi=yes&alerts=no';
                $this->view->currentWeather = $this->getJsonResponseUsingCurl($url);
            }
            if ($contr == 'Forecast') {
                $url = BASE_API_URL . '/forecast.json?key=' . KEY . '&q=' . $city . '&days=10&aqi=yes&alerts=no';
                $this->view->Forecast = $this->getJsonResponseUsingCurl($url)->forecast->forecastday;
            }

            if ($contr == 'Time Zone') {
                $url = BASE_API_URL . '/timezone.json?key=' . KEY . '&q=' . $city;
                $this->view->timeZone = $this->getJsonResponseUsingCurl($url);
            }
            if ($contr == 'Sports') {
                $url = BASE_API_URL . '/sports.json?key=' . KEY . '&q=' . $city;
                $this->view->sports = $this->getJsonResponseUsingCurl($url);
            }
            if ($contr == 'Astronomy') {
                $url = BASE_API_URL . '/astronomy.json?key=' . KEY . '&q=' . $city;
                $this->view->astronomy = $this->getJsonResponseUsingCurl($url);
            }
            if ($contr == 'Air Quality') {
                $url = BASE_API_URL . '/forecast.json?key=' . KEY . '&q=' . $city . '&days=3&aqi=yes&alerts=yes';
                $this->view->airQuality = $this->getJsonResponseUsingCurl($url)->current->air_quality;
            }
            if ($contr == 'Weather Alerts') {
                $url = BASE_API_URL . '/forecast.json?key=' . KEY . '&q=' . $city . '&days=3&aqi=yes&alerts=yes';
                $this->view->weatherAlerts = $this->getJsonResponseUsingCurl($url)->alerts;
            }
        }
    }
    //  Guzzle Code Starts  Here 
    public function getJsonResponseUsingGuzzle($url)
    {
        $client = new Client();

        $response = $client->request('GET', $url);

        $response = json_decode($response->getBody()->getContents());
        return $response;
    }
    public function indexGuzzleAction()
    {

        if ($this->request->isPost()) {
            $searchCity = $this->request->getPost('q');
            $this->response->redirect("index/searchGuzzle/" . $searchCity);
        }
    }
    public function searchGuzzleAction($key)
    {
        // http://api.weatherapi.com/v1/search.json?key=0bab7dd1bacc418689b143833220304&q=LKO
        // echo BASE_API_URL . '/search.json?key=' . KEY . '&q=' . $key;
        $url = BASE_API_URL . '/search.json?key=' . KEY . '&q=' . $key;
        print_r($this->getJsonResponseUsingGuzzle($url));
        $this->view->res = $this->getJsonResponseUsingGuzzle($url);
    }
    public function detailGuzzleAction($city)
    {
        $this->view->city = $city;
        if ($this->request->isPost()) {
            $contr = $this->request->getPost('contr');
            if ($contr == 'Current weather') {
                $url = BASE_API_URL . '/forecast.json?key=' . KEY . '&q=' . $city . '&days=3&aqi=yes&alerts=no';
                $this->view->currentWeather = $this->getJsonResponseUsingGuzzle($url);
            }
            if ($contr == 'Forecast') {
                $url = BASE_API_URL . '/forecast.json?key=' . KEY . '&q=' . $city . '&days=10&aqi=yes&alerts=no';
                $this->view->Forecast = $this->getJsonResponseUsingGuzzle($url)->forecast->forecastday;
            }

            if ($contr == 'Time Zone') {
                $url = BASE_API_URL . '/timezone.json?key=' . KEY . '&q=' . $city;
                $this->view->timeZone = $this->getJsonResponseUsingGuzzle($url);
            }
            if ($contr == 'Sports') {
                $url = BASE_API_URL . '/sports.json?key=' . KEY . '&q=' . $city;
                $this->view->sports = $this->getJsonResponseUsingGuzzle($url);
            }
            if ($contr == 'Astronomy') {
                $url = BASE_API_URL . '/astronomy.json?key=' . KEY . '&q=' . $city;
                $this->view->astronomy = $this->getJsonResponseUsingGuzzle($url);
            }
            if ($contr == 'Air Quality') {
                $url = BASE_API_URL . '/forecast.json?key=' . KEY . '&q=' . $city . '&days=3&aqi=yes&alerts=yes';
                $this->view->airQuality = $this->getJsonResponseUsingGuzzle($url)->current->air_quality;
            }
            if ($contr == 'Weather Alerts') {
                $url = BASE_API_URL . '/forecast.json?key=' . KEY . '&q=' . $city . '&days=3&aqi=yes&alerts=yes';
                $this->view->weatherAlerts = $this->getJsonResponseUsingGuzzle($url)->alerts;
            }
        }
    }
}
