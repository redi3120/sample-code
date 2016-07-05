<?php
abstract class Base_Controller {
	protected $controller;
	protected $params;
	protected $styles,$styles_admin;
	protected $scripts,$scripts_admin;
	protected $error;
	protected $page;    

	public function route() {
		if(class_exists($this->controller)) {
			$ref = new ReflectionClass($this->controller);
			if($ref->hasMethod('request')) {
				if($ref->isInstantiable()) {
					$class = $ref->newInstance();
					$method = $ref->getMethod('request');
				$method->invoke($class,$this->get_params());
				}
			}
		} else {throw new ContrException(NOT_P);}
	}

	public function init() {
		global $conf;

		if(isset($conf['styles'])) {
			foreach($conf['styles'] as $style) {
				$this->styles[] = trim($style,'/');
			}
		}

		if(isset($conf['styles_admin'])) {
			foreach($conf['styles_admin'] as $style_admin) {
				$this->styles_admin[] = trim($style_admin,'/');
			}
		}

		if(isset($conf['scripts'])) {
			foreach($conf['scripts'] as $script) {
				$this->scripts[] = trim($script,'/');
			}
		}

		if(isset($conf['scripts_admin'])) {
			foreach($conf['scripts_admin'] as $script_admin) {
				$this->scripts_admin[] = trim($script_admin,'/');
			}
		}
	}

	protected function get_controller() {
		return $this->controller;
	}

	protected function get_params() {
		return $this->params;
	}

	protected function input() {}
	protected function output() {}

	public function request($param = array()) {
		$this->init();
		$this->input($param);
		$this->output();

		if(!empty($this->error)) {
			$this->write_error($this->error);
		}
		$this->get_page();
	}

	public function get_page() {echo $this->page;}

	protected function render($path,$param = array()) {
		extract($param);
		ob_start();

		if(!include($path.'.php')) {throw new ContrException(NOT_TPL);}
		return ob_get_clean();
	}

	public function clear_str($var) {
		if(is_array($var)) {
			$row = array();
			foreach($var as $key=>$item) {
				$row[$key] = trim(strip_tags($item));
			}
			return $row;
		}
		return trim(strip_tags($var));
	}

	public function clear_int($var) {return (int)$var;}

	public function sub_aut($string, $end = SUB_AUT) {
		$string = strip_tags($string);
		$string = mb_substr($string, 0, $end);
		$string = rtrim($string, '!,.-');
		$string = substr($string, 0, strrpos($string, ' '));
		$string = $string.'...';
		return $string;
	}

	public function sub_min($string, $end = SUB_AUT) {
		$string = strip_tags($string);
		$string = mb_substr($string, 0, $end);
		return $string;
	}
	
	public function foo_min($string, $end = SUB_AUT) {
		$string = strip_tags($string);
		$string = mb_substr($string, 0, $end);
		return $string;
	}

	public function is_post() {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {return true;}
		return false;
	}

	public static function month_post($date){
		global $month;
		return $month[--$date];
	}
	
	public static function mon_post($date){
		global $mon;
		return $mon[--$date];
	}

	public function check_auth() {
		$cookie = Model_User::get_instance();
		$res = $cookie->check_id_user();

		if(!$res) {
			header('Location:'.SITE_URL_2.'/login');
			exit();
		}
	}
}
?>