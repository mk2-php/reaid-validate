<?php

namespace Reald\Validate;

class Rules{

	private $_context;
	private $_post;

	/**
	 * __construct
	 * @param $post
	 */
	public function __construct(&$context, $post){
		$this->_context = $context;
		$this->_post = $post;
	}

    /**
     * required
     * @param string $field
     */
    private function getValue($field){

        $value = $this->_post;

        $fields = explode(".",$field);

        foreach($fields as $f_){
            if(empty($value[$f_])){
                return null;
            }    

            $value = $value[$f_];
        }

        return $value;
	}
	
    /**
     * required
	 * 
     * @param String $value
     */
    public function required($value){

        if($value){
            return true;
        }

        if($value===0 || $value==="0"){
            return true;
        }
            
        return false;
	}

	/**
	 * confirmed
	 * 
     * @param String $value
     * @param String $confirmedValue
	 */
	public function confirmed($value, $confirmedValue){

		$targetValue = $this->getValue($confirmedValue);

		return $this->equal($value, $targetValue);
	}
    
    /**
     * alphaNumric
	 * 
     * @param String $value
     * @param Array $parameters
     */
    public function alphaNumeric($value, $parameters = null){

		if(!isset($value)){
			return true;
		}

		if($parameters){
            foreach($parameters as $p_){
				$value = str_replace($p_,"",$value);
            }
		}

		$reg="/^[a-zA-Z0-9]+$/";

		if(preg_match($reg, $value)){
			return true;
		}

        return false;
    }

    /**
     * numeric
	 * 
     * @param String $value
     * @param Array $parameters
     */
    public function numeric($value, $parameters = null){

		if(!isset($value)){
			return true;
		}

        if($parameters){
            foreach($parameters as $p_){
				$value = str_replace($p_,"",$value);
            }
        }

        $reg="/^[0-9]+$/";

		if(preg_match($reg, $value)){
			return true;
		}

        return false;
    }

    /**
     * length
	 * 
     * @param String $value
     * @param Int $length
     */
    public function length($value, $length){

		if(!isset($value)){
			return true;
		}

		if(mb_strlen($value) == $length){
			return true;
		}

        return false;
    }

	/**
     * minLength
	 * 
     * @param String $value
     * @param Int $length
     */
    public function minLength($value, $length){

		if(!isset($value)){
			return true;
		}

		if(mb_strlen($value) >= $length){
			return true;
		}

        return false;
    }

	/**
     * maxLength
	 * 
     * @param String $value
     * @param Int $length
     */
    public function maxLength($value, $length){

		if(!isset($value)){
			return true;
		}

		if(mb_strlen($value) <= $length){
			return true;
		}

        return false;
    }

	/**
     * betweenLength
	 * 
     * @param String $value
     * @param Int $begin
	 * @param Int $end
     */
    public function betweenLength($value, $begin, $end){

		if(!isset($value)){
			return true;
		}

		if(
			mb_strlen($value) >= $begin && 
			mb_strlen($value) <= $end
		){
			return true;
		}
        
        return false;
    }

	/**
     * value
	 * 
     * @param String $value
     * @param Int $targetValue
     */
    public function value($value, $targetValue){

		if(!isset($value)){
			return true;
		}

		if(intval($value) == intval($targetValue)){
			return true;
		}
    
        return false;
    }

	/**
     * minValue
	 * 
     * @param String $value
     * @param Int $targetValue
     */
    public function minValue($value, $targetValue){

		if(!isset($value)){
			return true;
		}

		if(intval($value) >= intval($targetValue)){
			return true;
		}
        
        return false;
    }

	/**
     * maxValue
	 * 
     * @param String $value
     * @param Int $targetValue
     */
    public function maxValue($value, $targetValue){

		if(!isset($value)){
			return true;
		}

		if(intval($value) <= intval($targetValue)){
			return true;
        }
        
		return false;
    }

	/**
     * betweenValue
	 * 
     * @param String $value
     * @param Int $begin
	 * @param Int $end
     */
    public function betweenValue($value, $begin, $end){

		if(!isset($value)){
			return true;
		}

        if(
			intval($value) >= intval($begin) &&
			intval($value) <= intval($end)
        ){
			return true;
		}
        
        return false;
    }

	/**
     * selectedCount
	 * 
     * @param Array $value
     * @param Int $count
	 */
	public function selectedCount($value, $count){

		if(!isset($value)){
			return true;
		}

		if(count($value) == intval($count)){
			return true;
		}

		return false;
	}

	/**
     * minSelectedCount
	 * 
     * @param Array $value
     * @param Int $count
	 */
	public function minSelectedCount($value, $count){

		if(!isset($value)){
			return true;
		}

		if(count($value) >= intval($count)){
			return true;
		}

		return false;
	}

	/**
     * maxSelectedCount
	 * 
     * @param Array $value
     * @param Int $count
	 */
	public function maxSelectedCount($value, $count){

		if(!isset($value)){
			return true;
		}

		if(count($value) <= intval($count)){
			return true;
		}

		return false;
	}

	/**
     * betweenSelectedCount
	 * 
     * @param Array $value
     * @param Int $begin
	 * @param Int $end
	 */
	public function betweenSelectedCount($value, $begin, $end){

		if(!isset($value)){
			return true;
		}

		if(
			count($value) >= intval($begin) &&  
			count($value) <= intval($end)
		){
			return true;
		}

		return false;
	}

	/**
     * equal
	 * 
     * @param String $value
     * @param String $targetValue
     */
    public function equal($value, $targetValue){

		if(!isset($value)){
			return true;
		}

		if(
			(string)$value === (string)$targetValue
		){
			return true;
		}
    
        return false;
    }


	/**
     * like
	 * 
     * @param String $value
     * @param String $likeStr
     */
    public function like($value, $likeStr){

		if(!isset($value)){
			return true;
		}
		
		if(strpos($value,$likeStr) > -1){
			return true;
        }
        
		return false;
	}
	
	/**
     * any
	 * 
     * @param String $value
     * @param Array $params
     */
    public function any($value, $params){

		if(!isset($value)){
			return true;
        }

		foreach($params as $p_){
            if((string)$value === (string)$p_){
                return true;
			}
        }

		return false;
    }

	/**
     * date
	 * 
     * @param String $value
     */
    public function date($value){

		if(!isset($value)){
			return true;
		}

		if(date("U", strtotime($value))){
			return true;
        }
        
		return false;
    }

    /**
     * minDate
	 * 
     * @param String $value
	 * @param String $targetDate
     */
	public function minDate($value, $targetDate){

		if(!isset($value)){
			return true;
		}

		$target = intval(date("U", strtotime($value)));
		$jum = intval(date("U", strtotime($targetDate)));
		
		if($target >= $jum){
			return true;
		}

		return false;
	}

    /**
     * maxDate
	 * 
     * @param String $value
     * @param String $targetDate
     */
	public function maxDate($value, $targetDate){

		if(!isset($value)){
			return true;
		}

		$target = intval(date("U", strtotime($value)));
		$jum = intval(date("U", strtotime($targetDate)));

		if($target <= $jum){
			return true;
		}

		return false;
    }

    /**
     * betweenDate
	 * 
     * @param String $value
     * @param String $begin
     * @param String $end
     */
	public function betweenDate($value, $begin, $end){

		if(!isset($value)){
			return true;
		}

		$target = intval(date("U", strtotime($value)));
		$start = intval(date("U", strtotime($begin)));
		$exit = intval(date("U", strtotime($end)));
	
		if($target >= $start && $target <= $exit){
			return true;
		}

		return false;
	}

    /**
     * isInt
	 * 
     * @param any $value
     */
	public function isInt($value){

		if(!isset($value)){
			return true;
		}

		if(is_int($value)){
			return true;
        }
        
		return false;
	}

    /**
     * isBool
	 * 
     * @param any $values
     */
	public function isBool($value,$parameters){

		if(!isset($value)){
			return true;
		}

		if(is_bool($value)){
			return true;
		}

		return false;
	}

    /**
     * isEmail
	 * 
     * @param String $value
     */
	public function isEmail($value){

		if($value == ""){
			return true;
		}

		if($value == "0"){
			return false;
		}

		if(!preg_match("|^[0-9a-z_./?-]+@([0-9a-z_./?-]+\.)+[0-9a-z-]+$|",$value)){
			return false;
		}

		return true;
    }

    /**
     * isTel
	 * 
     * @param String $value
     */
	public function isTel($value,$parameters){

		if(!isset($value)){
			return true;
		}

		if(preg_match('/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/i',$value)){
			return true;
		}

		if(preg_match('/^[0-9]{6,15}$/i',$value)){
			return true;
		}

		return false;
	}

    /**
     * isIp
	 * 
     * @param String $value
     */
	public function isIp($value){

		if(!isset($value)){
			return true;
		}

		if(preg_match("/(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])/",$value)){
			return true;
		}

		return false;
	}

    /**
     * isUrl
	 * 
     * @param string $value
     */
	public function isUrl($value){

		if(!isset($value)){
			return true;
		}

		if(preg_match("/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i",$value)){
			return true;
		}

		return false;
	}

    /**
     * Regex
	 * 
     * @param String $value
     * @param String $regex
     */
	public function Regex($value, $regex){

		if(!isset($value)){
			return true;
		}

		if(preg_match($regex, $value)){
			return true;
		}

		return false;
	}

    /**
     * isZipJP
	 * 
     * @param String $value
     */
	public function isZipJP($value){

		if(!isset($value)){
			return true;
		}

		if(preg_match("/^([0-9]{3}-[0-9]{4})?$|^[0-9]{7}+$/i",$value)){
			return true;
		}

		return false;
	}

    /**
     * isKatakana
	 * 
     * @param String $value
     */
	public function isKatakana($value){

		if(empty($value)){ return true; }

		$value=str_replace("　","",$value);
		$value=str_replace(" ","",$value);

		if(preg_match("/^[ァ-ヶー]+$/u", $value)){
			return true;
		}

		return false;
	}

    /**
     * isHiragana
	 * 
     * @param String $value
     */
	public function isHiragana($value){

		if(empty($value)){ return true; }

		$value=str_replace("　","",$value);
		$value=str_replace(" ","",$value);

		if(preg_match("/^[ぁ-ん]+$/u", $value)){
			return true;
		}

		return false;
	}

	/**
	 * AllowedBeforeToday
	 * 
	 * @param String $value
	 */
	public function AllowedBeforeToday($value){

		if(!isset($value)){
			return true;
		}

		return $this->maxDate($value, date("Y/m/d 00:00:00"));
	}

	/**
	 * AllowedAfterToday
	 * 
	 * @param String $value
	 */
	public function AllowedAfterToday($value,$parameters){

		if(!isset($value)){
			return true;
		}

		return $this->minDate($value, date("Y/m/d 00:00:00"));
	}
	
	/**
	 * custom
	 * 
	 * @param String $value
	 * @param String $methodName
	 * @param any $optionValue
	 */
	public function custom($value, $methodName, $optionValue = null){
		
		if(!method_exists($this->_context, $methodName)){
			return true;
		}

		return $this->_context->{$methodName}($value, $optionValue);
	}
}