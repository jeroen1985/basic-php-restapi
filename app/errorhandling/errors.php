<?php
namespace App\ErrorHandling;

class Errors{
    /*
	* Property: eMsgUnknownError
	* Description: error message unknown error
	*/
  	private static $eMsgUnknownError = ['Error Msg'=>'Unknown error'];

    /*
	* Property: eMsgUnsupportedMethod
	* Description: error message in case an unsupported method is used
	*/
  	private static $eMsgUnsupportedMethod = ['Error Msg'=>'Unsupported method used'];

  	/*
	* Property: eMsgPostDataIncomplete
	* Description: error message in case the POST data is incomplete/incorrect
	*/
	private static $eMsgPostDataIncomplete = ['Error Msg'=>'POST data incomplete or incorrect, format should be brand=Toyotota&type=RAV4&color=Green&drive=2WD&engine=2.4L'];

    	/*
	* Property: eMsgInvalidCategory
	* Description: error message in case invalid category is selected
	*/
    private static $eMsgInvalidCategory = ['Error Msg'=>'Invalid category'];

    /*
	* Property: eMsgIndexOutOfBound
	* Description: error message in case the array index is out of the max index range
	*/
	private static $eMsgIndexOutOfBound = ['Error Msg'=>'Invalid index out of bound'];

    /*
	* Property: eMsgUnsupportedVersion
	* Description: error message in case an unsupported method is used
	*/
  	private static $eMsgUnsupportedVersion= ['Error Msg'=>'Unsupported version used'];

    /*
	* Property: eMsgInvalidRequest
	* Description: error message in case the request is invalid
	*/
    private static $eMsgInvalidRequest = ['Error Msg'=>'Invalid Request'];

    private static function getEMsgUnknownError(){
        return self::$eMsgUnknownError;
    }

    private static function getEMsgUnsupportedMethod(){
        return self::$eMsgUnsupportedMethod;
    }

    private static function getEMsgPostDataIncomplete(){
        return self::$eMsgPostDataIncomplete;
    }

    private static function getEMsgInvalidCategory(){
        return self::$eMsgInvalidCategory;
    }

    private static function getEMsgIndexOutOfBound(){
        return self::$eMsgIndexOutOfBound;
    }

    private static function getEMsgUnsupportedVersion(){
        return self::$eMsgUnsupportedVersion;
    }

    private static function getEMsgInvalidRequest(){
        return self::$eMsgInvalidRequest;
    }

    public static function handleError($type){
        switch($type){
            case "eMsgUnsupportedMethod":
                return self::getEMsgUnsupportedMethod();
            break;
            case "eMsgPostDataIncomplete":
                return self::getEMsgPostDataIncomplete();
            break;
            case "eMsgInvalidCategory":
                return self::getEMsgInvalidCategory();
            break;
            case "eMsgIndexOutOfBound":
                return self::getEMsgIndexOutOfBound();
            break;
            case "eMsgUnsupportedVersion":
                return self::getEMsgUnsupportedVersion();
            break;
            case "eMsgInvalidRequest";
                return self::getEMsgInvalidRequest();
            break;
            default:
                return self::getEMsgUnknownError(); 
        }
    }
    
}