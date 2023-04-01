<?php

namespace Reald\Validate;

require "Rules.php";
require "ValidateResCollection.php";

trait ValidateTrait{

    public $rules = [];

    public $multiMessageFlg = false;
    
    private $_inputData;

    /**
     * __construct
     * 
     * @param Array $validateRules
     */
    public function __construct($validateRules = null){

        if($validateRules){
            $this->rules = $validateRules;
        }
    }

    /**
     * verify
     * 
     * @param Array/RequestControl $inputData
     * @param Array $myRules
     */
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

            if(!isset($inputData[$key])){
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

                    if(!$this->multiMessageFlg){
                        break;
                    }
                }
            }
        }

        $res = new ValidateResCollection($messages);

        return $res;
    }

    /**
     * merge
     * 
     * @param Validator $validator
     */
    public function merge($validator){

        if(gettype($validator) == "object"){
            if(!isset($validator->rules)){
                return;
            }
            $addValidateRule = $validator->rules;
        }
        else if(is_array($validator)){
            $addValidateRule = $validator;
        }
        else{
            return;
        }

        foreach($addValidateRule as $key => $value){

            if(empty($this->rules[$key])){
                $this->rules[$key] = $value;
            }
            else{
                foreach($value as $index => $v_){
                    $this->rules[$key][] = $v_;
                }
            }
        }

        return $this;
    }
}
