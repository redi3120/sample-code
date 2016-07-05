<?php
defined('SUCCESS') or exit('Access denied');

class Editcat_Controller extends Base_Admin {
	protected $cat, $res, $cou;
	protected function input($param = array()) {
		parent::input();

		$this->title = 'Изменение категории';

		if($param['id']) {
			$id = $this->clear_int($param['id']);
		} else exit(ERR);

		if($param['delete']) {
			$this->quote = $this->ob_m->delete_cat($id);
			header('Location:/acategory');
			exit();
		}

		$this->cou = $this->ob_m->get_all_in_one('books', '`cat_id` = '.$id);

		$this->res = false;

		if($this->is_post()) {
			if(isset($_POST['upd_cat'])) {
				$title = $this->clear_str($_POST['title']);
				$position = $this->clear_str($_POST['position']);
				$this->res = $this->ob_m->upd_cat($id, $title, $position);
			}
		}

		$this->cat = $this->ob_m->get_cat_one($id);	
	}

	protected function output() {
		$this->content = $this->render(VIEW.'admin/editcat',array(
			'c'=>$this->cat,
			'res' => $this->res,
			'cou' => $this->cou
		));                             
		$this->page = parent::output();
		return $this->page;
	}
}
?>