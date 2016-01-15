<?
require_once("data.php");

class Api{
	/*
	* Property: method
	* Description: the http method e.g. get, post, etc.
	*/
	private $method;
	
	/*
	* Property: uri
	* Description: the uri e.g. /api/1.0/cars/11
	*/
	private $uri;
	
	/*
	* Property: product
	* Description: the product category
	*/
  	private $product;
  	
  	/*
	* Property: id
	* Description: id for a specific product
	*/
  	private $id;
  	
  	/*
	* Property: dataObject
	* Description: data object that holds the data properties and methods
	*/
  	private $dataObject;
  	
  	/*
	* Property: eMsgUnsupportedMethod
	* Description: error message in case an unsupported method is used
	*/
  	private static $eMsgUnsupportedMethod = "unsupported method used";

  	/*
	* Property: postDataIncomplete
	* Description: error message in case the POST data is incomplete/incorrect
	*/
	private static $postDataIncomplete = "POST data incomplete or incorrect, format should be 'brand=Toyotota&type=RAV4&color=Green&drive=2WD&engine=2.4L'";

    /*
	* Property: eMsgInvalidCategory
	* Description: error message in case invalid category is selected
	*/
    private static $eMsgInvalidCategory = "Invalid category";
    
	/*
	* Method: __construct
	* Description: constructor of the class Api
	* Return value: n/a
	*/
	public function __construct($dataObject){
		$this->dataObject = $dataObject;
	}

	/*
	* Method: processRequest
	* Description: processes the client request and generates the response
	* Return value: the dataSet array as json
	*/
	public function processRequest(){
		$this->method = $_SERVER['REQUEST_METHOD'];
		
		$requestUri = ltrim($_SERVER['REQUEST_URI'], '/');
		$requestUriToArray = explode('/', $requestUri);
		$this->uri = $requestUriToArray;
		
		$this->product = (array_key_exists(2,$requestUriToArray)) ? strtolower($requestUriToArray[2]) : '';
		
		$this->id = (array_key_exists(3,$requestUriToArray)) ? $requestUriToArray[3] : '';

		switch($this->method){
			case "GET":
				$returnData = $this->processGetRequest();
			break;
			case "POST":
				$returnData = $this->processPostRequest();
			break;
			case "PUT":
                // PUT can be added here
				$returnData = self::$eMsgUnsupportedMethod;
            break;
            case "DELETE":
                //Delete can be added here
				$returnData = self::$eMsgUnsupportedMethod;
            break;
			Default:
				$returnData = self::$eMsgUnsupportedMethod;
		}

		header('Content-Type: application/json');
		return json_encode($returnData);
	}

	/*
	* Method: processGetRequest
	* Description: processes the get request and get the required information from the dataObject
	* Return value: data array with requested products
	*/
	private function processGetRequest(){
		$this->dataObject->setCategory($this->product);
		$category = $this->dataObject->categoryValid;
		
		if($category){
			if($this->id === '' ){
				$data = $this->dataObject->getProducts();
			}else{
				$data = $this->dataObject->getProduct($this->id);
			}
			return $data;
		}else{
			return self::$eMsgInvalidCategory;
		}
	}
	
	/*
	* Method: processPostRequest
	* Description: processes the post request en saves the data in the dataObject
	* Return value: string status message
	*/
	private function processPostRequest(){
		$this->dataObject->setCategory($this->product);
		$category = $this->dataObject->categoryValid;
		if($category){
			$dataComplete = true;	
			$dataKeys = array("brand","type","color","drive","engine");
			$sanitizedPostData = array();

			foreach($dataKeys as $dataKey) {
				if($dataComplete == false) break;
				if(isset($_POST[$dataKey]) && !empty($_POST[$dataKey])){
					$sanitizedPostData[$dataKey] = trim(filter_var($_POST[$dataKey], FILTER_SANITIZE_ENCODED)," ");
				}else{
					$dataComplete = false;
				}
			}
		
			if($dataComplete){
				$data = $this->dataObject->setProduct($sanitizedPostData);
				return $data;	
			}else{
				return self::$postDataIncomplete;
			}
		}else{
		return self::$eMsgInvalidCategory;
		}
	}

}

// instantiate a new object from the Data class
$dataObject = new Data();

// instantiate a new object from the Api class
// make use of dependency injection by injecting the data object
$api = new Api($dataObject);

// call the process method on the api object
echo $api->processRequest();

?>
