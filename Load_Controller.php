<?php
defined('SUCCESS') or exit('Access denied');

class Load_Controller extends Base {
	protected function input($param = array()) {
		parent::input();	

		if($param['files']) {
			$files = $param['files'];
		} else exit(ERR);

		if($param['id']) {
			$id = $this->clear_int($param['id']);
		} else exit(ERR);

		$c_d = $this->ob_m->get_donw($id);
		$this->ob_m->upd_donw($id, ++$c_d);

		$file = 'files/'.$files;
		
		header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
		
		ob_clean();
        flush();
        readfile($file);
        
		exit();
	}

	protected function output() {
		$this->page = parent::output();
		return $this->page;
	}
}
?>