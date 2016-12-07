<?php
namespace App\Controllers;

use Data\DataRepository;
use App\Response\ResponseHandler;

abstract class BaseController{
    /*
	* Property: dataRepository
	* Description: data object
	*/
    protected $dataRepository = null;

	/*
	* Property: responseHandler
	* Description: responseHandler object
	*/  
    protected $responseHandler = null;

    abstract public function retrieve();

    abstract public function process();

    public function __construct(){
        $this->dataRepository = new DataRepository();
        $this->responseHandler = new ResponseHandler();
    }

}