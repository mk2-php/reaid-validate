<?php

namespace Reald\Validate;

require "Rules.php";

trait ValidateTrait{

    public $rules = [];
    private $_inputData;

    public function verify($inputData, $myRules = []){

        if(gettype($inputData) == "object"){
            $className = get_class($inputData);
            if($className == "Reald\Core\RequestControl"){
                $inputData = $inputData->all();
            }
        }

        $this->_inputData = $inputData;

        if(!$myRules){
            $myRules = $this->rules;
        }

        $realdRules = new Rules($this, $inputData);

        $messages = [];

        foreach($myRules as $key => $rules){

            if(empty($inputData[$key])){
                $inputData[$key] = null;
            }

            $value = $inputData[$key];

            foreach($rules as $rule){

                if(gettype($rule["rule"]) == "string"){
                    $rule["rule"] = [ $rule["rule"] ];
                }

                $method = $rule["rule"][0];

                $arg1 = null;
                $arg2 = null;
                if(!empty( $rule["rule"][1])){
                    $arg1 = $rule["rule"][1];
                }
                if(!empty( $rule["rule"][2])){
                    $arg2 = $rule["rule"][2];    
                }

                if(method_exists($realdRules,$method)){

                    if($arg1 && $arg2){
                        $juge = $realdRules->{$method}($value, $arg1, $arg2);
                    }
                    else if($arg1){
                        $juge = $realdRules->{$method}($value, $arg1);
                    }
                    else{
                        $juge = $realdRules->{$method}($value);
                    }
                }

                if(!$juge){
                    if(empty($mesages[$key])){
                        $mesages[$key] = [];
                    }

                    $message = "field = ". $key .", rule = " . $method;
                    if(!empty($rule["message"])){
                        $message = $rule["message"];
                    }
                    $messages[$key][] = $message;
                }
            }
        }

        $res = new ValidateResCollection($messages);

        return $res;
    }

    public function getInputValue($key = null){
        
        if($key){
            if(!empty($this->_inputData[$key])){
                return $this->_inputData[$key];
            }    
        }
        else{
            return $this->_inputData;
        }
    }
}

class ValidateResCollection{

    private $_response;

    public function __construct($response){
        $this->_response = $response;
    }

    public function toJuge(){

        if(count($this->_response)){
            return false;
        }

        return true;
    }

    public function toArray(){
        return $this->_response;
    }

    public function toString(){
        $str = "";
        
        $ind = 0;
        foreach($this->_response as $r_){
            if($ind){
                $str .= "\n";
            }
            $str .= join("\n", $r_);
            $ind++;
        }

        return $str;
    }

    public function getMessage($key, $sepalate = "\n"){
        if(!empty($this->_response[$key])){
            return;
        }

        $message = $this->_response[$key];

        return join($sepalate, $message);
    }
}