<?php
namespace App\Response;

class Response{
    /*
    * Property: header
    * Description: standard header content type
    */  
    private $header = 'Content-Type: application/json';

    /*
    * Property: body
    * Description: response body
    */  
    private $body = null;

    /*
    * Property: error
    * Description: response error
    */  
    private $error = null;

    public function __construct($body = null, $error = null){
        $this->body = $body;
        $this->error = $error;
    }

    public function getHeader(){
        return $this->header;
    }

    public function getBody(){
        return $this->body;
    }

    public function getError(){
        return $this->error;
    }

}
