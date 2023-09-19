<?php
/*
	@package NikSkroutzWP Plugin 
*/
	namespace classes;
	final class init{
		private $classesarray = array();
		private function get_classes(){
			$this->classesarray =[
					\admin\admin::class,
					Enqueue::class
			];

			return $this->classesarray;
		}

		public  function create_obj(){
			foreach($this->get_classes() as $class)
			{
				$class_obj =  self::instatiate_class($class);
		

				if( method_exists($class_obj,'register'))
				{
					$class_obj->register();
				} else {
					die("create a register method in $class asap!!!");
				}
			}
		}

		private static function instatiate_class($class){
			$class_obj = new $class;

			return $class_obj;
		}

	}
?>