<?
namespace Data;

use App\Response\Response;
use App\Response\ResponseHandler;
use App\ErrorHandling\Errors;

Class DataRepository{
	/*
	* Property: category
	* Description: the category data type value
	*/
	private $category;
	
	/*
	* Property: category valid
	* Description: the category data type value
	*/
	public $categoryValid;
	
	/*
	* Property: dataSetCars
	* Description: array that holds all the apps data
	*/
	private $dataSetCars = array(
		array("Brand" => "Ford","Type" => "F-150","Color" => "Blue","Drive" => "4WD","Engine" => "2.8L"),array("Brand" => "Ford","Type" => "F-150","Color" => "Red","Drive" => "AWD","Engine" => "5.8L"), array("Brand" => "Ford","Type" => "F-150","Color" => "black","Drive" => "4WD","Engine" => "3.2L"),
		array("Brand" => "Ford","Type" => "F-350","Color" => "Blue","Drive" => "2WD","Engine" => "4.2L"),array("Brand" => "Ford","Type" => "F-350","Color" => "Red","Drive" => "4WD","Engine" => "5.4L"),array("Brand" => "Ford","Type" => "F-350","Color" => "Black","Drive" => "4WD","Engine" => "6.8L"),
	 	array("Brand" => "Ford","Type" => "Escape","Color" => "Blue","Drive" => "2WD","Engine" => "3.2L"),array("Brand" => "Ford","Type" => "Escape","Color" => "Red","Drive" => "4WD","Engine" => "3.4L"),array("Brand" => "Ford","Type" => "Escape","Color" => "Black","Drive" => "4WD","Engine" => "5.8L"));
			
	/*
	* Method: setCategory
	* Description: sets the product category that determines the data used
	* Return value: n/a
	*/
	public function setCategory($category){
		$this->category = $category;
		
		switch($this->category){
			case "car":
				$this->categoryValid = true;
			break;
			Default:
				$this->categoryValid = false;
		}
	}
	
	/*
	* Method: getProducts
	* Description: get an array of all products
	* Return value: the dataSetCarts array
	*/
	public function getProducts(){
		switch($this->category){
			case "car":
				$return = $this->dataSetCars;
			break;
			Default:
				$return = null;
		}
		return $return;
	}

	/*
	* Method: getProduct
	* Description: get a specific product array
	* Return value: array of a specific product 
	*/
	public function getProduct($productId=''){
        switch($this->category){
		case "car":
			if ($productId <= count($this->dataSetCars) && $productId > 0){
				$return = $this->dataSetCars[$productId-1];
			}else{
				(new responseHandler)->handler(new Response(null, Errors::handleError('eMsgIndexOutOfBound')));	
			}
		break;
		Default:
			$return = null;
		} 
        return $return;
	}
	
	/*
	* Method: setProduct
	* Description: add a new product to the dataSet
	* Return value: string status message
	*/
	public function setProduct($postData){
        	switch($this->category){
			case "car":
				$this->dataSetCars[] = $postData;	
				$return = true;
			break;
			Default:
				$return = false;				
		} 
        return $return;
	}
}

?>
