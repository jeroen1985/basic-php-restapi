<?php
namespace App\Response;

use App\Response\Response;
use App\ErrorHandling\Errors;

class ResponseHandler{
	/*
	* Property: response
	* Description: response object
	*/  
    private $response;

	/*
	* Property: error
	* Description: is there an error? true/false
	*/  
    private $error = false;

    public function handler(response $response){
        $this->response = $response;
        $this->finalize($this->handleResponse());
    }

    private function handleResponse(){
        if($this->response->getError() != null){
            $this->error = true;
            return $this->encode($this->response->getError());
        }

        if($this->response->getBody() != null){
            return $this->encode($this->response->getBody());
        }

        return (new Response(null, Errors::handleError('eMsgUnknownError')))->getError();
    }

    private function encode($input){
        return json_encode($input);
    }

    private function finalize($response){   
        $this->setHeaders();  
        die($response);
    }

    private function setHeaders(){
        if($this->error){
            header("HTTP/1.0 400");
        }
        header($this->response->getHeader());
    }
}