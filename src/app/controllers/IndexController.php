<?php

use Phalcon\Mvc\Controller;

define("BASE_API_URL",'http://api.weatherapi.com/v1');
define("KEY",'0bab7dd1bacc418689b143833220304');       

class IndexController extends Controller
{
    public function getJsonResponse($url)
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
            $searchCity=$this->request->getPost('q');
            $this->response->redirect("index/search/". $searchCity);
           
        }

    }
    public function searchAction($key)
    { 
        // http://api.weatherapi.com/v1/search.json?key=0bab7dd1bacc418689b143833220304&q=LKO
        echo BASE_API_URL.'/search.json?key='.KEY.'&q='.$key;
        $url=BASE_API_URL.'/search.json?key='.KEY.'&q='.$key;
        $this->view->res=$this->getJsonResponse($url);

    }
    public function detailAction($city)
    {
       $this->view->city=$city;
       if ($this->request->isPost()) {
       $contr=$this->request->getPost('contr');
       if($contr=='Current weather')
       { 
          $url= BASE_API_URL.'/forecast.json?key='.KEY.'&q='.$city.'&days=10&aqi=yes&alerts=no';
          $this->view->currentWeather=$this->getJsonResponse($url);
       }


       
    }
    
    }

}
