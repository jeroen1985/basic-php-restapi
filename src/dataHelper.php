<?
namespace Src;

class DataHelper{
    static public function sanitize($dataKeys,&$sanitizedPost){
        $dataComplete = true;	
			
        $sanitizedPostData = array();

        foreach($dataKeys as $dataKey) {
            if($dataComplete == false) break;
            if(isset($_POST[$dataKey]) && !empty($_POST[$dataKey])){
                $sanitizedPost[$dataKey] = trim(filter_var($_POST[$dataKey], FILTER_SANITIZE_ENCODED)," ");
            }else{
                $dataComplete = false;
            }
        }
        return $dataComplete;
    }
}