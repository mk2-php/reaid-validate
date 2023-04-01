<?php

namespace Reald\Validate;

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

    public function merge($addResCollection){

        if(gettype($addResCollection) == "object"){
            $add = $addResCollection->toArray();
        }
        else{
            $add = $addResCollection;
        }

        foreach($add as $key => $value){
            if(empty($this->_response[$key])){
                $this->_response[$key] = $value;
            }
            else{
                foreach($value as $index => $v_){
                    $this->_response[$key][] = $v_;
                }
            }
        }

        return $this;
    }
}