<?php
defined('SUCCESS') or exit('Access denied');

class Book_Controller extends Base {
	protected $book, $about;
	protected function input($param = array()) {
		parent::input();

        if($param['id']) {
			$id = $this->clear_int($param['id']);
		} else exit(ERR);
        
        if($this->is_post()) {
			if(isset($_POST['name'])) {
				$name = $this->clear_str($_POST['name']);
                setcookie('name_user',$name,time()+(60*60*24*30),'/');
				$text = $this->clear_str(nl2br($_POST['text']));
                echo $this->ob_m->send_about($name, $text, $id);
                exit();
			}
		}
        
		$this->book = $this->ob_m->get_one_book($id);

		if($this->book['year'] == 0) $this->book['year'] = "----";

		$name_cat = $this->ob_m->get_cat_one($this->book['cat_id']);
		$this->book['tit_cat'] = $name_cat['title'];

		$author_name = $this->ob_m->get_author_name($this->book['author_id']);
		$this->book['author_name'] = $author_name;

		$t = $this->book['data_add'];
		$this->book['data_add'] = date('j',$t).' '.$this->month_post(date('n',$t)).' '.date('Y',$t);

		$this->title = $this->book['title']." (".$this->book['author_name'].")";
		$this->keywords = $this->book['keywords'];
		$this->description = $this->book['description'];

		$this->ob_m->add_view($id, $this->book["count_view"]);
        
        $this->about = $this->ob_m->get_about_com($id);
        foreach($this->about as $key => $it) {
            $ti = $it['time'];
            $this->about[$key]['time'] = date('j',$ti).' '.$this->month_post(date('n',$ti)).' '.date('Y',$ti); 
        }
            
    }

	protected function output() {
		$this->content = $this->render(VIEW.'book',array(
			'book' => $this->book,
            'about' => $this->about
		));

		$this->page = parent::output();
		return $this->page;
	}
}
?>