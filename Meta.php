<?php

trait Meta {
	
    protected $methods = array();
    protected $attributes = array();

    public function addMethod($methodName, Closure $closure) {
	    $this->methods[$methodName] = $closure;
    }

    public function addAttribute($attributeName) {
        $this->attributes[$attributeName] = null;
    }

    public function __get($attributeName) {
        if(false === array_key_exists($attributeName, $this->attributes)) {
          throw new \RuntimeException('unknown attribute');
	}
        return $this->attributes[$attributeName];
    }

    public function __set($attributeName, $value) {
       $this->attributes[$attributeName] = $value;  
    }

    public function __call($methodName, $arguments) {
       if(false === isset($this->methods[$methodName])) {
           throw new \RunTimeException('unknown method');
       }
       array_unshift($arguments,$this);
       return call_user_func_array($this->methods[$methodName], $arguments);
    }
}
