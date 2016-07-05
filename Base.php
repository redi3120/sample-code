<?php
	abstract class Base extends Base_Controller {
		protected $ob_m;
		protected $title;
		protected $style;
		protected $script;
		protected $header;
		protected $content;
		protected $left_bar;
    	protected $get_foot_pop;
    	protected $get_foot_news;
    	protected $quot;
    	protected $footer;
		protected $cat;
        protected $id_week;
        
		protected function input() {
			foreach($this->styles as $style) {
				$this->style[] = SITE_URL.VIEW.$style;
			}

			foreach($this->scripts as $script) {
				$this->script[] = SITE_URL.VIEW.$script;
			}

			$this->ob_m = Model::get_instance();
			$this->cat = $this->ob_m->get_cat();
			$this->quot = $this->ob_m->get_quot();

			$cou = $this->ob_m->count_us();
			if(empty($cou)) {
				$this->ob_m->cau_del();
				$this->ob_m->cou_ins_m();
				$this->ob_m->cou_ins_m_2();
			} else {
				$res = $this->ob_m->cou_ins_m_3();

				if(count($res) == 1){
					$this->ob_m->cou_ins_m_4();
				} else {
					$this->ob_m->cou_ins_m_5();
					$this->ob_m->cou_ins_m_6();	
				}
			}
	}

	protected function output() {
		if(URL_CONT == 'books') {
			$id_it_menu = URL_NUM;
		} else $id_it_menu;
        
        $ar_set = $this->ob_m->get_id_week();
        $act_week = $ar_set[0]['on_b'];
        $id_book = $ar_set[0]['id_b'];
        $act_wid_week_book = ($ar_set)? $this->ob_m->get_one_book($id_book) : false;
        
		$this->left_bar = $this->render(VIEW.'left_bar',array(
			'cat'=> $this->cat,
			'act_m' => $id_it_menu,
            'act_week' => $act_week,
            'id_wid' => $act_wid_week_book,
            'w_vk' => $ar_set[0]['w_vk'],
            'w_ans' => $ar_set[0]['w_ans'],
            'descript' => $ar_set[0]['description'],
            'id_book' => $id_book,
		));

		$page = $this->render(VIEW.'index',
			array(
				'header'=>$this->header,
				'left_bar' =>$this->left_bar,
				'content' => $this->content,
				'footer' => $this->footer
			));

		$this->get_foot_pop = $this->ob_m->get_foot_pop();
		$this->get_foot_news = $this->ob_m->get_foot_news();

		foreach($this->get_foot_pop as $key => $val){
			$this->get_foot_pop[$key]['title'] = $this->foo_min($val['title'], 35);
		}

		foreach($this->get_foot_news as $key => $val){
			$this->get_foot_news[$key]['title'] = $this->foo_min($val['title'], 30);
			$this->get_foot_news[$key]['data_add'] = date('j', $val['data_add']).' '.$this->mon_post(date('n',$val['data_add']));
		}

		$this->footer = $this->render(VIEW.'footer', array(
			'get_foot_pop' => $this->get_foot_pop,
			'get_foot_news' => $this->get_foot_news,
		));

		$this->header = $this->render(VIEW.'header',array(
			'styles' => $this->style,
			'scripts' => $this->script,
			'quot' => $this->quot,
			'title' => $this->title,
			'keywords' => $this->keywords,
			'description' => $this->description
		));											

		$page = $this->render(VIEW.'index',array(
			'header'=>$this->header,
			'left_bar' =>$this->left_bar,
			'content' => $this->content,
			'footer' => $this->footer
		));
		return $page;									
	}
}
?>