<?php
namespace App\Controllers;

use App\Response\ResponseHandler;
use App\Response\Response;
use App\ErrorHandling\Errors;
use Src\DataHelper;

class CarController extends BaseController{
    /*
    * Property: validCategory
    * Description: allows categories
    */
    private $validCategory = false;

    /*
    * Property: route
    * Description: routing data
    */  
    private $route = null;

    /*
    * Property: dataKeys
    * Description: allows keys in post
    */
    private $dataKeys = ["brand",
                         "type",
                         "color",
                         "drive",
                         "engine"];

    public function __construct($route){
        parent::__construct();

        $this->route = $route;
        $this->dataRepository->setCategory($this->route['category']);
	$this->validCategory = $this->dataRepository->categoryValid;
    }

    public function retrieve(){	
	if($this->validCategory){
	    if($this->route['id'] == ""){
		$data = $this->dataRepository->getProducts();
	    }else if(isset($this->route['id']) && $this->route['id'] != ""){
		$data = $this->dataRepository->getProduct($this->route['id']);
	    }
	    $this->responseHandler->handler(new Response($data,null));
	}else{
	    $this->responseHandler->handler(new Response(null, Errors::handleError('')));
        }
    }

    public function process(){
	if($this->validCategory){	
    	    $dataComplete = DataHelper::sanitize($this->dataKeys,$sanitizedPost);
		
	    if($dataComplete){
		$result = $this->dataRepository->setProduct($sanitizedPost);
		if($result == true){
		    $this->responseHandler->handler(new Response(["POST"=>"Succes","Data"=>$sanitizedPost],null));
		}
		$this->responseHandler->handler(new Response(null,Errors::handleError('eMsgPostDataIncomplete')));             
	    }else{
	        $this->responseHandler->handler(new Response(null,Errors::handleError('eMsgPostDataIncomplete')));
	    }
        }else{
	    $this->responseHandler->handler(new Response(null, Errors::handleError('')));
        }
    }

}
