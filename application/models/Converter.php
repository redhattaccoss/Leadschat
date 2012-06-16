<?php
final class Converter {
	static public function object_to_array(stdClass $Class){
		$Class = (array)$Class;
		foreach($Class as $key => $value){
			if(is_object($value)&&get_class($value)==='stdClass'){
				$Class[$key] = self::object_to_array($value);
			}
		}
		return $Class;
	}

	static public function array_to_object(array $array){
		foreach($array as $key => $value){
			if(is_array($value)){
				$array[$key] = self::array_to_object($value);
			}
		}
		return (object)$array;
	}
}