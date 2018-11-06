<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tuolaji <479923197@qq.com>
// +----------------------------------------------------------------------
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class AutoOrderController extends AdminbaseController {

	protected $AutoOrder_model;
	protected $term_relationships_model;
	protected $terms_model;

	function _initialize() {
		parent::_initialize();
		$this->AutoOrder_model = D("Admin/Auto_order");
		$this->terms_model = D("Portal/Terms");
		$this->term_relationships_model = D("Portal/TermRelationships");
	}

	// 后台文章管理列表
	public function index(){
		$this->_lists($_POST["post"]);
		$this->display();
	}

	// 文章添加
	public function add(){
		$this->display();
	}

	// 文章添加提交
	public function add_post(){

		if (IS_POST) {

            
            
            
            
			$article=I("post.post");
            
            

		

			$result=$this->AutoOrder_model->add($article);

			if ($result) {
				$this->success("添加成功！");
			} else {
				$this->error("添加失败！");
			}

		}
	}

	// 文章编辑
	public function edit(){
		$id=  I("get.id",0,'intval');

		$terms=$this->terms_model->select();
		$post=$this->AutoOrder_model->where("o_id=$id")->find();
		$this->assign("post",$post);
		$this->display();
	}

	// 文章编辑提交
	public function edit_post(){
		if (IS_POST) {


            
			$article=I("post.post");

			
			
			$result=$this->AutoOrder_model->save($article);
			if ($result!==false) {
				$this->success("保存成功！");
			} else {
				$this->error("保存失败！");
			}
		}
	}

	// 文章排序
	public function listorders() {
		$status = parent::_listorders();
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}

	/**
	 * 文章列表处理方法,根据不同条件显示不同的列表
	 * @param array  查询条件
	 */
	private function _lists($keyword){


	    foreach($keyword as $key=>$value)
        
        {
         if($value)
         {
             if(strpos($value,'min') !==false)
             {
             
                 $where[$key]=array("egt",$value);
             }
             else if(strpos($value,'max') !==false)
             {
                 $where[$key]=array("elt",$value);
             }
             else{
                 $where[$key]=array('like','%'.$value.'%');
             }
             
         }
        
        
        }

		$this->AutoOrder_model
			->alias("a");


		$count=$this->AutoOrder_model->where($where)->count();

		$page = $this->page($count, 20);

		$this->AutoOrder_model
			->alias("a")
			->limit($page->firstRow , $page->listRows)
			->where($where)
			->order("a.o_id desc");

		$posts=$this->AutoOrder_model->select();

		//echo ->AutoOrder_model->getLastSql();

		$this->assign("page", $page->show('Admin'));
		$this->assign("post",$keyword);
		$this->assign("posts",$posts);
	}

	// 文章删除
	public function delete(){
		if(isset($_GET['id'])){
			$id = I("get.id",0,'intval');
			if($this->AutoOrder_model->where(array('o_id'=>$id))->delete() !==false)
			{
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}

		if(isset($_POST['ids'])){
			$ids = I('post.ids/a');

			if ($this->AutoOrder_model->where(array('id'=>array('in',$ids)))->delete()!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}

	// 文章审核
	public function check(){
		if(isset($_POST['ids']) && $_GET["check"]){
			$ids = I('post.ids/a');

			if ( $this->AutoOrder_model->where(array('id'=>array('in',)))->save(array('post_status'=>1)) !== false ) {
				$this->success("审核成功！");
			} else {
				$this->error("审核失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["uncheck"]){
			$ids = I('post.ids/a');

			if ($this->AutoOrder_model->where(array('id'=>array('in',)))->save(array('post_status'=>0)) !== false) {
				$this->success("取消审核成功！");
			} else {
				$this->error("取消审核失败！");
			}
		}
	}

	// 文章置顶
	public function top(){
		if(isset($_POST['ids']) && $_GET["top"]){
			$ids = I('post.ids/a');

			if ($this->AutoOrder_model->where(array('id'=>array('in',$ids)))->save(array('istop'=>1))!==false) 
			{
				$this->success("置顶成功！");
			} else {
				$this->error("置顶失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["untop"]){
			$ids = I('post.ids/a');

			if ( $this->AutoOrder_model->where(array('id'=>array('in',)))->save(array('istop'=>0))!==false) {
				$this->success("取消置顶成功！");
			} else {
			$this->error("取消置顶失败！");
			}
		}
	}

	// 文章推荐
	public function recommend(){
		if(isset($_POST['ids']) && $_GET["recommend"]){
			$ids = I('post.ids/a');

			if ($this->AutoOrder_model->where(array('id'=>array('in',)))->save(array('recommended'=>1))!==false) {
				$this->success("推荐成功！");
			} else {
				$this->error("推荐失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["unrecommend"]){
			$ids = I('post.ids/a');

			if ( $this->AutoOrder_model->where(array('id'=>array('in',$ids)))->save(array('recommended'=>0))!==false) {
				$this->success("取消推荐成功！");
			} else {
				$this->error("取消推荐失败！");
			}
		}
	}

	// 文章批量移动
	public function move(){
		if(IS_POST){
			if(isset($_GET['ids']) && $_GET['old_term_id'] && isset($_POST['term_id'])){
				$old_term_id=I('get.old_term_id',0,'intval');
				$term_id=I('post.term_id',0,'intval');
				if($old_term_id!=$term_id){
				
					$ids=explode(',', I('get.ids/s'));
					$ids=array_map('intval', $ids);

					foreach ($ids as $id){
						$this->term_relationships_model->where(array('object_id'=>$id,'term_id'=>$old_term_id))->delete();
						$find_relation_count=$this->term_relationships_model->where(array('object_id'=>$id,'term_id'=>$term_id))->count();
						if($find_relation_count==0){
							$this->term_relationships_model->add(array('object_id'=>$id,'term_id'=>$term_id));
						}
					}

				}

				$this->success("移动成功！");
			}
		}else{
			$tree = new \Tree();
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			$terms =$this->terms_model->order(array("path"=>"ASC"))->select();
			$new_terms=array();
			foreach ($terms as $r) {
				$r['id']=$r['term_id'];
				$r['parentid']=$r['parent'];
				$new_terms[] = $r;
			}
			$tree->init($new_terms);
			$tree_tpl="<option value='$id'>$spacer$name</option>";
			$tree=$tree->get_tree(0,$tree_tpl);

			$this->assign("terms_tree",$tree);
			$this->display();
		}
	}

	// 文章批量复制
	public function copy(){
		if(IS_POST){
			if(isset($_GET['ids']) && isset($_POST['term_id'])){
				$ids=explode(',', I('get.ids/s'));
				$ids=array_map('intval', $ids);
				$uid=sp_get_current_admin_id();
				$term_id=I('post.term_id',0,'intval');
				$term_count=$terms_model=M('Terms')->where(array('term_id'=>$term_id))->count();
				if($term_count==0){
					$this->error('分类不存在！');
				}

				$data=array();

				foreach ($ids as $id){
					$find_post=$this->AutoOrder_model->field('post_keywords,post_source,post_content,post_title,post_excerpt,smeta')->where(array('id'=>$id))->find();
					if($find_post){
						$find_post['post_author']=$uid;
						$find_post['post_date']=date('Y-m-d H:i:s');
						$find_post['post_modified']=date('Y-m-d H:i:s');
						$post_id=$this->AutoOrder_model->add($find_post);
						if($post_id>0){
							array_push($data, array('object_id'=>$post_id,'term_id'=>$term_id));
						}
					}
				}

				if ( $this->term_relationships_model->addAll() !== false) {
					$this->success("复制成功！");
				} else {
					$this->error("复制失败！");
				}
			}
		}else{
			$tree = new \Tree();
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			$terms = $this->terms_model->order(array("path"=>"ASC"))->select();
			$new_terms=array();
			foreach ($terms as $r) {
				$r['id']=$r['term_id'];
				$r['parentid']=$r['parent'];
				$new_terms[] = $r;
			}
			$tree->init();
			$tree_tpl="<option value='$id'>$spacer$name</option>";
			$tree=$tree->get_tree(0,$tree_tpl);

			$this->assign("terms_tree",$tree);
			$this->display();
		}
	}

	// 文章回收站列表
	public function recyclebin(){
		$this->_lists(array('post_status'=>array('eq',3)));
		$this->_getTree();
		$this->display();
	}

	// 清除已经删除的文章
	public function clean(){
		if(isset($_POST['ids'])){
			$ids = I('post.ids/a');
			$ids = array_map('intval', $ids);
			$status=$this->AutoOrder_model->where(array("id"=>array('in',$ids),'post_status'=>3))->delete();
			$this->term_relationships_model->where(array('object_id'=>array('in',$ids)))->delete();

			if ($status!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}else{
			if(isset($_GET['id'])){
				$id = I("get.id",0,'intval');
				$status=$this->AutoOrder_model->where(array("id"=>$id,'post_status'=>3))->delete();
				$this->term_relationships_model->where(array('object_id'=>$id))->delete();

				if ($status!==false) {
					$this->success("删除成功！");
				} else {
					$this->error("删除失败！");
				}
			}
		}
	}

	// 文章还原
	public function restore(){
		if(isset($_GET['id'])){
			$id = I("get.id",0,'intval');
			if ($this->AutoOrder_model->where(array("id"=>$id,'post_status'=>3))->save(array("post_status"=>"1"))) {
				$this->success("还原成功！");
			} else {
				$this->error("还原失败！");
			}
		}
	}

}
