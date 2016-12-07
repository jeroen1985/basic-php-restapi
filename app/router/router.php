<?php
namespace App\Router;

use App\Response\Response;
use App\Response\ResponseHandler;
use App\ErrorHandling\Errors;
use App\Controllers\CarController;

class Router{
    /*
	* Property: category
	* Description: the category related to uri
	*/
	private $category;

    /*
	* Property: method
	* Description: the http method e.g. get, post, etc.
	*/
	private $method;

    /*
	* Property: cleanHttpMethod
	* Description: clean version of the http method e.g. get, post, etc. 
	*/
	private $cleanHttpMethod;
	
	/*
	* Property: uri
	* Description: the uri e.g. /api/1.0/car/11
	*/
	private $uri;

	/*
	* Property: id
	* Description: id for a specific product
	*/
  	private $id;

	/*
	* Property: version
	* Description: api version provided in url
	*/  
	private $version;  

	/*
	* Property: responseHandler
	* Description: responseHandler object
	*/  
    private $responseHandler;

	/*
	* Property: registeredControllers
	* Description: array that holds all registered controllers
	*/  
    private $registeredControllers = [];

	/*
	* Property: route
	* Description: required routing data to be passed on to controller
	*/  
    private $route = [];

    public function __construct(){
        $this->responseHandler = new ResponseHandler();
        $this->handleIntialRequest();
        $this->filterMethodMapping();
        $this->registerControllers();
        $this->dispatchToController();
    }

	private function handleIntialRequest(){
		$this->method = $_SERVER['REQUEST_METHOD'];
		
		$requestUri = ltrim($_SERVER['REQUEST_URI'], '/');
		
		if(!$this->validUrlPattern($requestUri)){
			 $this->responseHandler->handler(new Response(null, Errors::handleError('eMsgInvalidRequest')));
		}
		
		$requestUriToArray = explode('/', $requestUri);
		
		$this->uri = $requestUriToArray;

		$this->version = (array_key_exists(0,$requestUriToArray)) ? $requestUriToArray[0] : '';
		
		$this->category = (array_key_exists(1,$requestUriToArray)) ? strtolower($requestUriToArray[1]) : '';
		
		$this->id = (array_key_exists(2,$requestUriToArray)) ? $requestUriToArray[2] : '';
	}

	private function validUrlPattern($requestUri){
		$result = false;
		$pattern = "/^[0-9.]{3}[\/]{1}[a-zA-Z]+[\/]*[0-9]*$/";

		if(preg_match($pattern,$requestUri) === 1){
			$result = true;
		}

		return $result;	
	}

    private function filterMethodMapping(){
        switch($this->method){
			case "GET":
				$this->cleanHttpMethod = "GET";
			break;
			case "POST":
				$this->cleanHttpMethod = "POST";
			break;
			case "PUT":
            case "DELETE":
                $this->responseHandler->handler(new Response(null, Errors::handleError('eMsgUnsupportedMethod')));				
            break;
			Default:
				$this->responseHandler->handler(new Response(null, Errors::handleError('eMsgUnsupportedMethod')));	
		}
    }

    private function registerControllers(){
        $this->route = [
            "category" => $this->category,
            "cleanHttpMethod" => $this->cleanHttpMethod,
            "id" => $this->id
        ];

        $this->registeredControllers['car'] = new CarController($this->route);
    }

    private function dispatchToController(){
		if($this->version == '1.1'){
			switch($this->category){
				case "car":
					switch($this->cleanHttpMethod){
						case "GET":
							$this->registeredControllers['car']->retrieve();
						break;
						case "POST":
							$this->registeredControllers['car']->process();
						break;
					}
				break;
				Default:
					$this->responseHandler->handler(new Response(null, Errors::handleError('eMsgInvalidCategory')));				
			}
		}else{
			$this->responseHandler->handler(new Response(null, Errors::handleError('eMsgUnsupportedVersion')));	
		}
    }
}