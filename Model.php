<?php
class Model {
	static $instance;
	public $ins_driver;

	static function get_instance() {
		if(self::$instance instanceof self) {
			return self::$instance;
		}
		return self::$instance = new self;
	}

	private function __construct() {
		try {$this->ins_driver = Model_Driver::get_instance();}
		catch(DbException $e) {exit();}
	}

	public function get_map_page() {
		$result = $this->ins_driver->select(
			array('id','title','type'),
			'page',
			array(),
			'position'
		);
		return $result;	
	}

	public function get_map_books() {
		$result = $this->ins_driver->select(
			array('id','title'),
			'books',
			array('show_hide'=>'1'),
	        'title'
		);
		return $result;	
	}

	public function get_map_authors() {
		$result = $this->ins_driver->select(
	    	array('id','name'),
			'authors',
			array(),
			'name'
		);
		return $result;	
	}

	public function get_all_catalog() {
		$result = $this->ins_driver->select(
			array('id','title', 'author_id','img'),
			'books',
			array('show_hide'=>'1'),
			'title'
		);
		return $result;	
	}

	public function get_home_page() {
		$result = $this->ins_driver->select(
			array('id','title','author_id','img','rat','count_view'),
				'books',
				array('show_hide'=>'1'),
				'rat',
				'DESC',
				10
			);
		return $result;									
	}

	public function get_name_author($id) {
		$result = $this->ins_driver->select(
			array('name'),
				'authors',
				array('id' => $id),
				false,
				false,
				1
			);
		return $result[0]['name'];									
	}

	public function get_home_text() {
		$result = $this->ins_driver->select(
			array('id','title','text','keywords','description'),
				'page',
				array('type' => 'index'),
				false,
				false,
				1
			);
		return $result[0];									
	}

	public function get_about() {
		$result = $this->ins_driver->select(
			array('id','title','text','keywords','description'),
				'page',
				array('type' => 'about'),
				false,
				false,
				1
			);
		return $result[0];									
	}
	
	public function get_open() {
		$result = $this->ins_driver->select(
			array('id','title','text','keywords','description'),
				'page',
				array('type' => 'open'),
				false,
				false,
				1
			);
		return $result[0];									
	}

	public function get_one_book($id) {
		$result = $this->ins_driver->select(
			array(
				'id',
				'title',
				'text',
				'keywords',
				'description',
				'link_ozon',
				'link_doc',
				'link_pdf',
				'link_djvu',
				'link_epub',
				'link_fb2',
				'link_audio',
				'author_id',
				'year',
				'img',
				'count_donw',
				'count_view',
				'count_page',
				'data_add',
				'cat_id',
				'show_hide',
				'rat'
			),
				'books',
				array('id' => $id, 'show_hide' => '1'),
				false,
				false,
				1
			);
		return $result[0];									
	}
	
	public function get_one_book_a($id) {
		$result = $this->ins_driver->select(
			array(
				'id',
				'title',
				'text',
				'keywords',
				'description',
				'link_ozon',
				'link_doc',
				'link_pdf',
				'link_djvu',
				'link_epub',
				'link_fb2',
				'link_audio',
				'author_id',
				'year',
				'img',
				'count_donw',
				'count_view',
				'count_page',
				'data_add',
				'cat_id',
				'show_hide',
				'rat'
			),
				'books',
				array('id' => $id),
				false,
				false,
				1
			);
		return $result[0];									
	}

	public function get_header_menu() {}

	public function get_cat() {
		$result = $this->ins_driver->select(
			array('id','title','position'),
				'cat',
				array(),
				'position',
				false
			);
		return $result;									
	}

	public function get_id_week() {
		$result = $this->ins_driver->select(
            array('on_b','id_b','w_vk','w_ans','description'),
				'sett',
				array('id'=>'1'),
				false,
				false,
                1	
			);
		return $result;									
	}

	public function get_quot() {
		return $this->ins_driver->quote();							
	}

	public function get_foot_pop() {
		$result = $this->ins_driver->select(
			array('id','title', 'rat'),
				'books',
				array('show_hide'=>'1'),
				'rat',
				'DESC',
				5
			);
		return $result;									
	}

	public function get_foot_news() {
		$result = $this->ins_driver->select(
			array('id','title', 'data_add'),
				'books',
				array('show_hide'=>'1'),
				'data_add',
				'DESC',
				5
			);
		return $result;									
	}

	public function get_name_cat($cat) {
		$result = $this->ins_driver->select(
			array('id','title'),
				'cat',
				array('id' => $cat),
				false,
				false,
				1
			);
		return $result[0];									
	}

	public function get_author($id) {
		$result = $this->ins_driver->select(
			array('id', 'keywords', 'description', 'name','text','img'),
				'authors',
				array('id' => $id),
				false,
				false,
				1
			);
		return $result[0];									
	}

	public function get_author_name($id) {
		$result = $this->ins_driver->select(
			array('name'),
				'authors',
				array('id' => $id),
				false,
				false,
				1
			);
		return $result[0]["name"];									
	}

	public function get_cat_one($id) {
		$result = $this->ins_driver->select(
			array('id','title','position'),
				'cat',
				array('id' => $id),
				false,
				false,
				1
			);
		return $result[0];									
	}

	public function get_page_one($id) {
		$result = $this->ins_driver->select(
			array('id','title','text','type','description','keywords'),
				'page',
				array('id' => $id),
				false,
				false,
				1
			);
		return $result[0];									
	}

	public function get_all_in_one($table, $where) {
		$result = $this->ins_driver->get_all_in_one_bd($table, $where);
 	return	$result;									
	}

	public function get_quote_one($id) {
		$result = $this->ins_driver->select(
			array('id','text','author'),
				'quote',
				array('id' => $id),
				false,
				false,
				1
			);
		return $result[0];									
	}

	public function get_book_author($id) {
		$result = $this->ins_driver->select(
			array('id','title','img'),
			'books',
			array('author_id' => $id,'show_hide'=>'1'),
			false,
			false,
			'50'
		);
		return $result;									
	}

	public function search_author($author) {
		$result = $this->ins_driver->select(
			array('id','name','text','img'),
			'authors',
			array(),
			false,
			false,
			100,
			array("="),
			array('name,text' =>$author)
		);
		return $result;									
	}

	public function add_view($id, $cou) {
		$cou++;

		$res = $this->ins_driver->update(
			'books',
			array('count_view'),
			array($cou),
			array('id' => $id)
		);
		
		return $res;								
	}
	
	public function get_donw($id) {
		$res = $this->ins_driver->select(
			array('count_donw'),
			'books',
			array('id' => $id),
			false,
			false,
			1
		);
		return $res[0]['count_donw'];								
	}

	public function upd_donw($id,$cou) {
		$res = $this->ins_driver->update(
			'books',
			array('count_donw'),
			array($cou),
			array('id' => $id)
		);
		return $res;									
	}

	public function get_book() {
		$result = $this->ins_driver->select(
			array('id','title','count_donw','count_view','show_hide', 'link_ozon'),
			'books',
			array(),
			'id',
			'DESC',
			1000
		);
		return $result;									
	}

	public function get_offer() {
		$result = $this->ins_driver->select(
			array('ip','text','id','data'),
			'new_book',
			array(),
			'id',
			'DESC',
			1000
		);
		return $result;									
	}
	
	public function delete_offer($id){
		$res = $this->ins_driver->delete('new_book', array('id' => $id));
		return $res;
	}

	public function get_authors() {
		$result = $this->ins_driver->select(
			array('id','name'),
			'authors',
			array(),
			false,
			false,
			1000
		);
		return $result;									
	}

	public function get_pages() {
		$result = $this->ins_driver->select(
			array('id','title'),
			'page',
			array(),
			false,
			false,
			1000
		);
		return $result;									
	}

	public function get_quotes() {
		$result = $this->ins_driver->select(
			array('id','text'),
			'quote',
			array(),
			false,
			false,
			1000
		);
		return $result;									
	}
    
	public function get_ab() {
		$result = $this->ins_driver->select(
			array('id','text','name','time','id_book'),
			'about',
			array(),
			'time',
			'DESC',
			1000
		);
		return $result;									
	}
    
	public function db_view() {
		$result = $this->ins_driver->select(
			array('count_view'),
			'books',
			array('show_hide'=>'1'),
			false,
			false,
			1000
		);

		$view = 0;
		foreach($result as $item){
			$view += (int)$item['count_view'];
		}
		return $view;									
	}

	public function db_donw() {
		$result = $this->ins_driver->select(
			array('count_donw'),
			'books',
			array('show_hide'=>'1'),
			false,
			false,
			1000
		);

		$view = 0;

		foreach($result as $item){
			$view += (int)$item['count_donw'];
		}
		return $view;									
	}

	public function count_us(){
		$date = date('Y-m-d');
		
		$result = $this->ins_driver->select(
			array('id'),
				'count',
				array('date'=>$date),
				false,
				false,
				1
			);
		return $result;
	}

	public function cau_del(){$result = $this->ins_driver->cou_delete();}
	
	public function db_us_count($cou = 8) {
		$result = $this->ins_driver->select(
			array('date','host','hit'),
			'count',
			array(),
			'date',
			'DESC',
			$cou
		);
		return $result;									
	}

	public function add_cat($title, $position){
		$res = $this->ins_driver->insert(
			'cat', array('title', 'position'), array($title, $position)
		);
		return $res;
	}

	public function add_author($keywords, $description, $name, $text, $img){
		$res = $this->ins_driver->insert(
			'authors', array('keywords', 'description', 'name', 'text', 'img'), array($keywords, $description, $name, $text, $img)
		);
		return $res;
	}

	public function add_quote($author, $text){
		$res = $this->ins_driver->insert(
			'quote', array('author', 'text'), array($author, $text)
		);
		return $res;
	}

	public function add_new_book($text, $ip){
		$res = $this->ins_driver->insert(
			'new_book', array('text', 'ip','data'), array($text, $ip, time())
		);
		return $res;
	}

	public function delete_quote($id){
		$res = $this->ins_driver->delete('quote', array('id' => $id));
		return $res;
	}
    
	public function delete_about($id){
		$res = $this->ins_driver->delete('about', array('id' => $id));
		return $res;
	}

	public function delete_author($id){
		$res = $this->ins_driver->delete('authors', array('id' => $id));
		return $res;
	}

	public function delete_cat($id){
		$res = $this->ins_driver->delete('cat', array('id' => $id));
		return $res;
	}

	public function delete_book($id){
		$res = $this->ins_driver->delete('books', array('id' => $id));
		return $res;
	}

	public function add_book($rat, $title, $keywords, $description, $text, $year, $count_page, $count_view, $count_donw, $data_add, $link_ozon, $link_doc, $link_pdf, $link_djvu, $link_epub, $link_fb2, $link_audio, $show, $pat_img, $cat, $aut) {	
		$res = $this->ins_driver->insert(
			'books', array(
				'title',
				'keywords',
				'description',
				'text',
				'year',
				'count_page',
				'count_view',
				'count_donw',
				'data_add',
				'link_ozon',
				'link_doc',
				'link_pdf',
				'link_djvu',
				'link_epub',
				'link_fb2',
				'link_audio',
				'show_hide',
				'author_id',
				'cat_id',
				'img',
				'rat',
			),
			array(
				$title, 
				$keywords, 
				$description, 
				$text,
				$year, 
				$count_page, 
				$count_view, 
				$count_donw, 
				$data_add, 
				$link_ozon, 
				$link_doc, 
				$link_pdf, 
				$link_djvu, 
				$link_epub,
				$link_fb2, 
				$link_audio, 
				$show,
				$aut,
				$cat, 
				$pat_img,
				$rat
			)	
		);
		return $res;	
	}

	public function upd_book($id, $rat, $title, $keywords, $description, $text, $year, $count_page, $count_view, $count_donw, $data_add, $link_ozon, $link_doc, $link_pdf, $link_djvu, $link_epub, $link_fb2, $link_audio, $show, $img, $cat, $aut) {
		$res = $this->ins_driver->update(
			'books', array(
				'title',
				'keywords',
				'description',
				'text',
				'year',
				'count_page',
				'count_view',
				'count_donw',
				'data_add',
				'link_ozon',
				'link_doc',
				'link_pdf',
				'link_djvu',
				'link_epub',
				'link_fb2',
				'link_audio',
				'show_hide',
				'author_id',
				'cat_id',
				'img',
				'rat',
			),
			array( $title, $keywords, $description, $text, $year, $count_page, $count_view, $count_donw, $data_add, $link_ozon, $link_doc, $link_pdf, $link_djvu, $link_epub, $link_fb2, $link_audio, $show, $aut, $cat, $img, $rat),
			array('id' => $id)		
		);
		return $res;
	}

	public function upd_quote($id, $author, $text){
		$res = $this->ins_driver->update(
			'quote',
			array('author', 'text'),
			array($author, $text),
			array('id' => $id)
		);
		return $res;
	}
    
 	public function upd_w_add_book($val){
		$res = $this->ins_driver->update(
			'sett',
			array('w_ans'),
			array($val),
			array('id' => 1)
		);
		return $res;
	}
    
  	public function upd_w_vk($val){
		$res = $this->ins_driver->update(
			'sett',
			array('w_vk'),
			array($val),
			array('id' => 1)
		);
		return $res;
	}
    
   	public function upd_w_top($val){
		$res = $this->ins_driver->update(
			'sett',
			array('on_b'),
			array($val),
			array('id' => 1)
		);
		return $res;
	}
    
   	public function upd_w_top_book($val){
        $res = $this->ins_driver->update(
			'sett',
			array('id_b'),
			array($val),
			array('id' => 1)
		);
		return $res;
	}
    
   	public function upd_w_top_book_desc($val){
        $res = $this->ins_driver->update(
			'sett',
			array('description'),
			array($val),
			array('id' => 1)
		);
		return $res;
	}

	public function upd_page($id, $description, $keywords, $title, $type, $text){	
		$res = $this->ins_driver->update(
			'page',
			array('description', 'keywords', 'title', 'type', 'text'),
			array($description, $keywords, $title, $type, $text),
			array('id' => $id)
		);
		return $res;
	}

	public function upd_author($id, $keywords, $description, $name, $text, $img){
		$res = $this->ins_driver->update(
			'authors',
			array('keywords', 'description', 'name', 'text', 'img'),
			array($keywords, $description, $name, $text, $img),
			array('id' => $id)
		);
		return $res;
	}

	public function upd_cat($id, $title, $position){
		$res = $this->ins_driver->update(
			'cat',
			array('title', 'position'),
			array($title, $position),
			array('id' => $id)
		);
	}

	public function view_nule() {
		$res = $this->ins_driver->update(
			'books',
			array('count_view'),
			array(0),
			array()
		);
		return $res;
	}

	public function donw_nule() {
		$res = $this->ins_driver->update(
			'books',
			array('count_donw'),
			array(0),
			array()
		);
		return $res;
	}
    
 	public function send_about($name, $text, $id){
		$res = $this->ins_driver->insert(
			'about',
            array('name', 'text', 'id_book', 'time'), 
            array($name, $text, $id, time())
		);
		return $res;
    }
    
 	public function get_about_com($id) {
		$result = $this->ins_driver->select(
			array('id','name','text','time'),
				'about',
				array('id_book' => $id),
				'time',
				'DESC',
				5
			);
		return $result;									
	}
}
?>