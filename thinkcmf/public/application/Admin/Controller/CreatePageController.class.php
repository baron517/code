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

class CreatePageController extends AdminbaseController {

	protected $CreatePage_model;
	protected $term_relationships_model;
	protected $terms_model;

	function _initialize() {
		parent::_initialize();
	
	}

	// 后台文章管理列表
	public function index(){
		
		$db = M();
		$dbName=$db->query('select database() as db_name');
		
		$dbName=$dbName[0]["db_name"];
		
        $list=$db->query('show tables');
        $array=[];
        
       for($i=0;$i<count($list);$i++)
       {
           
           $table=$list[$i]["tables_in_".$dbName];
           
           if(strpos($table,'auto') !==false)
           {
               array_push($array,$table);
           }
       }
		
		$this->assign("array",$array);
		$this->display();
	}

	// 文章添加
	public function add(){
	    
		$this->display();
	}

	// 文章添加提交
	public function add_post(){

		if (IS_POST) {

            
            $db = M();
            
            for($i=0;$i<count($_POST['post']);$i++)
            {
                
                 $sql="select COLUMN_NAME as ziduan,column_comment as zhushi from INFORMATION_SCHEMA.Columns where table_name='".$_POST['post'][$i]."'";
    		    $list=$db->query($sql);
    		    
    		    
    		    
    		    $wenjianjia=explode("_",$_POST['post'][$i]);
    		    $biaoName=ucfirst(substr($_POST['post'][$i],3));
    		    $fileName="";
    		    for($j=0;$j<count($wenjianjia);$j++)
    		    {
    		        if($j>0)
    		        {
    		            
    		           $fileName=$fileName.ucfirst($wenjianjia[$j]); 
    		        }
    		    }
    		    
    		    $path="admin/themes/simplebootx/Admin/".$fileName;
    		    
    		    $dir = iconv("UTF-8", "GBK", $path);
                if (!file_exists($dir)){
                    mkdir ($dir,0777,true);
                }
                
                $createform="";
                $tableHeader="";
                $tableBody="";
                $phpHouduan="";
                $phpHouduanAdd="";
                $phpEditor="";
                $searchHtml="";
                for($k=0;$k<count($list);$k++)
                {
                    
                     $ziduan=$list[$k]["ziduan"];
                     
                      $zhushiList=json_decode($list[$k]["zhushi"],1);
                      $label=$zhushiList["name"];
                    
                    
                    if($k>0)
                    {
                        
                       
                        
                        if(!$zhushiList["table_hide"])
                        {
                            
                            $tableHeader=$tableHeader.
                                "
                                <th >".$label."</th>";
                            
                            if($zhushiList["upload"]=="doc")
                            {
                                
                                $tableBody=$tableBody.
                                '
                                <td><a target="_blank" href="{$vo.'.$ziduan.'}">预览下载</a></td>';
                        
                            }
                            else if($zhushiList["upload"]=="img")
                            {
                                 
                                
                                
                                $tableBody=$tableBody.
                                '
                                <td><a href="{$vo.'.$ziduan.'}" target="_blank"><img style="max-width:120px;" src="{$vo.'.$ziduan.'}"/></a></td>';
                            }
                            else
                            {
                                
                                $tableBody=$tableBody.
                                '
                                <td>{$vo.'.$ziduan.'}</td>';
                            }
                            
                            
                            //搜索
                            if($zhushiList["search"])
                            {
                                
                            if($zhushiList["date"])
                           {
                               
                                $searchHtml=$searchHtml.
                            '
                             <span>
                			<label>'.$label.'</label>
                			<input type="text" class="laydate"  name="post['.$ziduan.']" style="width: 200px;" value="{$post.'.$ziduan.'|default=""}">
                			</span>';
                               
                           }
                           else if($zhushiList["select"])
                           {
                               $select_url="";
                               if($zhushiList["select_url"])
                               {
                                   $select_url=$zhushiList["select_url"];
                               }
                               
                               $optionHtml="";
                               
                               
                               
                                $searchHtml=$searchHtml.
                            '
                             <span>
                			<label>'.$label.'</label>
                			<select type="text" id="'.$ziduan.'"  name="post['.$ziduan.']" style="width: 216px;" data-url="'.$select_url.'"  data-value="{$post.'.$ziduan.'|default=""}"><option></option></select>
                			</span>';
                               
                           }
                           else{
                               
                                $searchHtml=$searchHtml.
                            '
                             <span>
                			<label>'.$label.'</label>
                			<input type="text" name="post['.$ziduan.']" style="width: 200px;" value="{$post.'.$ziduan.'|default=""}">
                			</span>';
                           }
                                
                           
                            }
                            
                            
                            
                            
                        }
                        
                       
                       if(!$zhushiList["form_hide"]&&!$zhushiList["create_time"])
                       {
                           
                           if($zhushiList["select"])
                           {
                               
                                $select_url="";
                               if($zhushiList["select_url"])
                               {
                                   $select_url=$zhushiList["select_url"];
                               }
                               
                                $createform=$createform.'
                             <tr>
    							<th>'.$label.'</th>
    							<td>
    								<select  style="width:416px;"  id="'.$ziduan.'" name="post['.$ziduan.']" data-url="'.$select_url.'"   data-value="{$post.'.$ziduan.'}" ></select>
    							</td>
    						</tr>';
                               
                           }
                           else if($zhushiList["checkbox"])
                           {
                               
                               
                               $checkboxList=explode("#",$zhushiList["checkbox"]);
                               $checkboxHtml="";
                               for($n=0;$n<count($checkboxList);$n++)
                               {
                                   	$checkboxHtml=$checkboxHtml.'<span><input type="checkbox" data-value="{$post.'.$ziduan.'}"   name="post['.$ziduan.']"   value="'.$checkboxList[$n].'" /><label>'.$checkboxList[$n].'</label></span>';
                               }
                               
                               
                            $createform=$createform.'
                             <tr>
    							<th>'.$label.'</th>
    							<td class="checkbox-col">'.$checkboxHtml.'</td>
    						</tr>';
                               
                           }
                           
                           else if($zhushiList["radio"])
                           {
                               
                               
                               $checkboxList=explode("#",$zhushiList["radio"]);
                               $checkboxHtml="";
                               for($n=0;$n<count($checkboxList);$n++)
                               {
                                   	$checkboxHtml=$checkboxHtml.'<span><input type="radio"    data-value="{$post.'.$ziduan.'}" name="post['.$ziduan.']"   value="'.$checkboxList[$n].'" /><label>'.$checkboxList[$n].'</label></span>';
                               }
                               
                               
                            $createform=$createform.'
                             <tr>
    							<th>'.$label.'</th>
    							<td class="checkbox-col">'.$checkboxHtml.'</td>
    						</tr>';
                               
                           }
                           
                           else if($zhushiList["upload"])
                           {
                               if($zhushiList["upload"]=="doc")
                               {
                                    $createform=$createform.'
                                     <tr>
            							<th>'.$label.'</th>
            							<td>
            							    <span class="upload-col" >选择文件
            								<input type="file" class="file"  data-type="doc" style="width:400px;" id="'.$ziduan.'"  /><input type="hidden" name="post['.$ziduan.']"   value="{$post.'.$ziduan.'}"></span><a target="_blank" class="file-doc" href="{$post.'.$ziduan.'}"></a>
            							</td>
            						</tr>';
                               }
                               else if($zhushiList["upload"]=="img")
                               {
                                    $createform=$createform.'
                                     <tr>
            							<th>'.$label.'</th>
            							<td>
            							    <span class="upload-col" >选择图片
            								<input class="file" type="file"  data-type="img" style="width:400px;" id="'.$ziduan.'"  /><input type="hidden" name="post['.$ziduan.']"   value="{$post.'.$ziduan.'}"></span><a target="_blank" class="file-img" href="{$post.'.$ziduan.'}"></a>
            							</td>
            						</tr>';
                               }
                               
                               
                           }
                           
                           else if($zhushiList["date"])
                           {
                               
                                $createform=$createform.'
                             <tr>
    							<th>'.$label.'</th>
    							<td>
    								<input type="text" class="laydate" style="width:400px;" id="'.$ziduan.'" name="post['.$ziduan.']"   value="{$post.'.$ziduan.'}" />
    							</td>
    						</tr>';
                               
                           }
                           else if($zhushiList["textarea"])
                           {
                               
                                $createform=$createform.'
                             <tr>
    							<th>'.$label.'</th>
    							<td>
    								<textarea  style="width:400px;" id="'.$ziduan.'" name="post['.$ziduan.']"   >{$post.'.$ziduan.'}</textarea>
    							</td>
    						</tr>';
                               
                           }
                            else if($zhushiList["editor"])
                            {
                               $chakanHtml="";
                               if($zhushiList["editor_chakan"])
                               {
                                   $chakanHtml='<div id="chakan">{$post.'.$ziduan.'}</div>';
                               }
                                $createform=$createform.'
                             <tr>
    							<th>'.$label.'</th>
    							<td>
    							<script type="text/plain" id="content" name="post['.$ziduan.']">{$post.'.$ziduan.'}</script>'.$chakanHtml.'
    							
    							</td>
    						</tr>';
    						
    						$phpEditor="\$article['".$ziduan."']=htmlspecialchars_decode(\$article['".$ziduan."']);";
                               
                               
                           }
                           
                           else{
                               
                                $createform=$createform.'
                             <tr>
    							<th width="100">'.$label.'</th>
    							<td>
    								<input type="text" style="width:400px;" id="'.$ziduan.'" name="post['.$ziduan.']"   value="{$post.'.$ziduan.'}" />
    							</td>
    						</tr>';
                               
                               
                           }
                           
                          
                       }
                       else if($zhushiList["create_time"])
                       {
                           $phpHouduan="\$_POST['post']['".$ziduan."']=date('Y-m-d H:i:s');";
                           $phpHouduanAdd=$phpHouduan;
                       }
                       else if($zhushiList["bianhao"])
                       {
                           
                           
            
                            $phpHouduanAdd=$phpHouduanAdd."\n          \$dateStr=date('Ym');";
                            
                            $phpHouduanAdd=$phpHouduanAdd.
                            "\n          \$findData['".$ziduan."']=array('like','%'.\$dateStr.'%');";
                            
                            $phpHouduanAdd=$phpHouduanAdd.
                            "\n          \$countList=\$this->AutoTag_model->where(\$findData)->count();";
                            
                             $phpHouduanAdd=$phpHouduanAdd.
                            "\n          \$countList=\$countList+1;";
                            
                            $phpHouduanAdd=$phpHouduanAdd.
                            "\n          \$countList=sprintf('%03d',\$countList);";
                            
                            $phpHouduanAdd=$phpHouduanAdd.
                            "\n          \$_POST['post']['".$ziduan."']=\$dateStr.\$countList;";
                            
                            
                       }
                       
                        
                        
                        
                         
                    }
                    else{
                        
                        $createform=$createform.'
    								<input type="hidden" style="width:400px;"  id="'.$ziduan.'" name="post['.$ziduan.']"   value="{$post.'.$ziduan.'}" />';
                        
                        
                        
                        $tableHeader=$tableHeader.
                        "
                        <th>".$label."</th>";
                        
                         $tableBody=$tableBody.
                        ' 
                        <td>{$vo.'.$ziduan.'}</td>';
                    }
                    
                    
                    
                   
                    
                   
                }
                
                $tableHeader=$tableHeader.
                "
                <th width='70'>操作</th>";
                
                $tableBody=$tableBody.
                        "
                        <td><a href={:U('{$fileName}/edit',array('id'=>\$vo['".$list[0]['ziduan']."']))}>{:L('EDIT')}</a> |
						<a href={:U('{$fileName}/delete',array('id'=>\$vo['".$list[0]['ziduan']."']))} class='js-ajax-delete'>{:L('DELETE')}</a></td>";
						
				$biaoId=$list[0]['ziduan'];

$myfile = fopen("application/Admin/Controller/".$fileName."Controller.class.php", "w");         
$houduan=<<<EOT
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

class {$fileName}Controller extends AdminbaseController {

	protected \${$fileName}_model;
	protected \$term_relationships_model;
	protected \$terms_model;

	function _initialize() {
		parent::_initialize();
		\$this->{$fileName}_model = D("Admin/{$biaoName}");
		\$this->terms_model = D("Portal/Terms");
		\$this->term_relationships_model = D("Portal/TermRelationships");
	}

	// 后台文章管理列表
	public function index(){
		\$this->_lists(\$_POST["post"]);
		\$this->display();
	}

	// 文章添加
	public function add(){
		\$this->display();
	}

	// 文章添加提交
	public function add_post(){

		if (IS_POST) {

            
            
            {$phpHouduanAdd}
            
			\$article=I("post.post");
            
            {$phpEditor}

		

			\$result=\$this->{$fileName}_model->add(\$article);

			if (\$result) {
				\$this->success("添加成功！");
			} else {
				\$this->error("添加失败！");
			}

		}
	}

	// 文章编辑
	public function edit(){
		\$id=  I("get.id",0,'intval');

		\$terms=\$this->terms_model->select();
		\$post=\$this->{$fileName}_model->where("{$biaoId}=\$id")->find();
		\$this->assign("post",\$post);
		\$this->display();
	}

	// 文章编辑提交
	public function edit_post(){
		if (IS_POST) {


            {$phpHouduan}
			\$article=I("post.post");

			{$phpEditor}
			
			\$result=\$this->{$fileName}_model->save(\$article);
			if (\$result!==false) {
				\$this->success("保存成功！");
			} else {
				\$this->error("保存失败！");
			}
		}
	}

	// 文章排序
	public function listorders() {
		\$status = parent::_listorders($this->term_relationships_model);
		if (\$status) {
			\$this->success("排序更新成功！");
		} else {
			\$this->error("排序更新失败！");
		}
	}

	/**
	 * 文章列表处理方法,根据不同条件显示不同的列表
	 * @param array $where 查询条件
	 */
	private function _lists(\$keyword){


	    foreach(\$keyword as \$key=>\$value)
        
        {
         if(\$value)
         {
             if(strpos(\$value,'min') !==false)
             {
             
                 \$where[\$key]=array("egt",\$value);
             }
             else if(strpos(\$value,'max') !==false)
             {
                 \$where[\$key]=array("elt",\$value);
             }
             else{
                 \$where[\$key]=array('like','%'.\$value.'%');
             }
             
         }
        
        
        }

		\$this->{$fileName}_model
			->alias("a");


		\$count=\$this->{$fileName}_model->where(\$where)->count();

		\$page = \$this->page(\$count, 20);

		\$this->{$fileName}_model
			->alias("a")
			->limit(\$page->firstRow , \$page->listRows)
			->where(\$where)
			->order("a.{$biaoId} desc");

		\$posts=\$this->{$fileName}_model->select();

		//echo $this->{$fileName}_model->getLastSql();

		\$this->assign("page", \$page->show('Admin'));
		\$this->assign("post",\$keyword);
		\$this->assign("posts",\$posts);
	}

	// 文章删除
	public function delete(){
		if(isset(\$_GET['id'])){
			\$id = I("get.id",0,'intval');
			if(\$this->{$fileName}_model->where(array('{$biaoId}'=>\$id))->delete() !==false)
			{
				\$this->success("删除成功！");
			} else {
				\$this->error("删除失败！");
			}
		}

		if(isset(\$_POST['ids'])){
			\$ids = I('post.ids/a');

			if (\$this->{$fileName}_model->where(array('id'=>array('in',\$ids)))->delete()!==false) {
				\$this->success("删除成功！");
			} else {
				\$this->error("删除失败！");
			}
		}
	}

	// 文章审核
	public function check(){
		if(isset(\$_POST['ids']) && \$_GET["check"]){
			\$ids = I('post.ids/a');

			if ( \$this->{$fileName}_model->where(array('id'=>array('in',$ids)))->save(array('post_status'=>1)) !== false ) {
				\$this->success("审核成功！");
			} else {
				\$this->error("审核失败！");
			}
		}
		if(isset(\$_POST['ids']) && \$_GET["uncheck"]){
			\$ids = I('post.ids/a');

			if (\$this->{$fileName}_model->where(array('id'=>array('in',$ids)))->save(array('post_status'=>0)) !== false) {
				\$this->success("取消审核成功！");
			} else {
				\$this->error("取消审核失败！");
			}
		}
	}

	// 文章置顶
	public function top(){
		if(isset(\$_POST['ids']) && \$_GET["top"]){
			\$ids = I('post.ids/a');

			if (\$this->{$fileName}_model->where(array('id'=>array('in',\$ids)))->save(array('istop'=>1))!==false) 
			{
				\$this->success("置顶成功！");
			} else {
				\$this->error("置顶失败！");
			}
		}
		if(isset(\$_POST['ids']) && \$_GET["untop"]){
			\$ids = I('post.ids/a');

			if ( \$this->{$fileName}_model->where(array('id'=>array('in',$ids)))->save(array('istop'=>0))!==false) {
				\$this->success("取消置顶成功！");
			} else {
			\$this->error("取消置顶失败！");
			}
		}
	}

	// 文章推荐
	public function recommend(){
		if(isset(\$_POST['ids']) && \$_GET["recommend"]){
			\$ids = I('post.ids/a');

			if (\$this->{$fileName}_model->where(array('id'=>array('in',$ids)))->save(array('recommended'=>1))!==false) {
				\$this->success("推荐成功！");
			} else {
				\$this->error("推荐失败！");
			}
		}
		if(isset(\$_POST['ids']) && \$_GET["unrecommend"]){
			\$ids = I('post.ids/a');

			if ( \$this->{$fileName}_model->where(array('id'=>array('in',\$ids)))->save(array('recommended'=>0))!==false) {
				\$this->success("取消推荐成功！");
			} else {
				\$this->error("取消推荐失败！");
			}
		}
	}

	// 文章批量移动
	public function move(){
		if(IS_POST){
			if(isset(\$_GET['ids']) && \$_GET['old_term_id'] && isset(\$_POST['term_id'])){
				\$old_term_id=I('get.old_term_id',0,'intval');
				\$term_id=I('post.term_id',0,'intval');
				if(\$old_term_id!=\$term_id){
				
					\$ids=explode(',', I('get.ids/s'));
					\$ids=array_map('intval', \$ids);

					foreach (\$ids as \$id){
						\$this->term_relationships_model->where(array('object_id'=>\$id,'term_id'=>\$old_term_id))->delete();
						\$find_relation_count=\$this->term_relationships_model->where(array('object_id'=>\$id,'term_id'=>\$term_id))->count();
						if(\$find_relation_count==0){
							\$this->term_relationships_model->add(array('object_id'=>\$id,'term_id'=>\$term_id));
						}
					}

				}

				\$this->success("移动成功！");
			}
		}else{
			\$tree = new \Tree();
			\$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
			\$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			\$terms =\$this->terms_model->order(array("path"=>"ASC"))->select();
			\$new_terms=array();
			foreach (\$terms as \$r) {
				\$r['id']=\$r['term_id'];
				\$r['parentid']=\$r['parent'];
				\$new_terms[] = \$r;
			}
			\$tree->init(\$new_terms);
			\$tree_tpl="<option value='\$id'>\$spacer\$name</option>";
			\$tree=\$tree->get_tree(0,\$tree_tpl);

			\$this->assign("terms_tree",\$tree);
			\$this->display();
		}
	}

	// 文章批量复制
	public function copy(){
		if(IS_POST){
			if(isset(\$_GET['ids']) && isset(\$_POST['term_id'])){
				\$ids=explode(',', I('get.ids/s'));
				\$ids=array_map('intval', \$ids);
				\$uid=sp_get_current_admin_id();
				\$term_id=I('post.term_id',0,'intval');
				\$term_count=\$terms_model=M('Terms')->where(array('term_id'=>\$term_id))->count();
				if(\$term_count==0){
					\$this->error('分类不存在！');
				}

				\$data=array();

				foreach (\$ids as \$id){
					\$find_post=\$this->{$fileName}_model->field('post_keywords,post_source,post_content,post_title,post_excerpt,smeta')->where(array('id'=>\$id))->find();
					if(\$find_post){
						\$find_post['post_author']=\$uid;
						\$find_post['post_date']=date('Y-m-d H:i:s');
						\$find_post['post_modified']=date('Y-m-d H:i:s');
						\$post_id=\$this->{$fileName}_model->add(\$find_post);
						if(\$post_id>0){
							array_push(\$data, array('object_id'=>\$post_id,'term_id'=>\$term_id));
						}
					}
				}

				if ( \$this->term_relationships_model->addAll($data) !== false) {
					\$this->success("复制成功！");
				} else {
					\$this->error("复制失败！");
				}
			}
		}else{
			\$tree = new \Tree();
			\$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
			\$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
			\$terms = \$this->terms_model->order(array("path"=>"ASC"))->select();
			\$new_terms=array();
			foreach (\$terms as \$r) {
				\$r['id']=\$r['term_id'];
				\$r['parentid']=\$r['parent'];
				\$new_terms[] = \$r;
			}
			\$tree->init($new_terms);
			\$tree_tpl="<option value='\$id'>\$spacer\$name</option>";
			\$tree=\$tree->get_tree(0,\$tree_tpl);

			\$this->assign("terms_tree",\$tree);
			\$this->display();
		}
	}

	// 文章回收站列表
	public function recyclebin(){
		\$this->_lists(array('post_status'=>array('eq',3)));
		\$this->_getTree();
		\$this->display();
	}

	// 清除已经删除的文章
	public function clean(){
		if(isset(\$_POST['ids'])){
			\$ids = I('post.ids/a');
			\$ids = array_map('intval', \$ids);
			\$status=\$this->{$fileName}_model->where(array("id"=>array('in',\$ids),'post_status'=>3))->delete();
			\$this->term_relationships_model->where(array('object_id'=>array('in',\$ids)))->delete();

			if (\$status!==false) {
				\$this->success("删除成功！");
			} else {
				\$this->error("删除失败！");
			}
		}else{
			if(isset(\$_GET['id'])){
				\$id = I("get.id",0,'intval');
				\$status=\$this->{$fileName}_model->where(array("id"=>\$id,'post_status'=>3))->delete();
				\$this->term_relationships_model->where(array('object_id'=>\$id))->delete();

				if (\$status!==false) {
					\$this->success("删除成功！");
				} else {
					\$this->error("删除失败！");
				}
			}
		}
	}

	// 文章还原
	public function restore(){
		if(isset(\$_GET['id'])){
			\$id = I("get.id",0,'intval');
			if (\$this->{$fileName}_model->where(array("id"=>\$id,'post_status'=>3))->save(array("post_status"=>"1"))) {
				\$this->success("还原成功！");
			} else {
				\$this->error("还原失败！");
			}
		}
	}

}

EOT;

fwrite($myfile, $houduan);

fclose($myfile);
                
                
                
                $myfile = fopen($path."/add.html", "w");
		    
$txt=<<<EOT
            <admintpl file="header" />
<style type="text/css">
.pic-list li {
	margin-bottom: 5px;
}
</style>
<script type="text/html" id="photos-item-wrapper">
	<li id="savedimage{id}">
		<input id="photo-{id}" type="hidden" name="photos_url[]" value="{filepath}"> 
		<input id="photo-{id}-name" type="text" name="photos_alt[]" value="{name}" style="width: 160px;" title="图片名称">
		<img id="photo-{id}-preview" src="{url}" style="height:36px;width: 36px;" onclick="parent.image_preview_dialog(this.src);">
		<a href="javascript:upload_one_image('图片上传','#photo-{id}');">替换</a>
		<a href="javascript:(function(){\$('#savedimage{id}').remove();})();">移除</a>
	</li>
</script>
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li><a href="{:U('{$fileName}/index')}">内容管理</a></li>
			<li class="active"><a href="{:U('{$fileName}/add')}" target="_self">添加内容</a></li>
		</ul>
		<form action="{:U('{$fileName}/add_post')}" method="post" class="form-horizontal js-ajax-forms" enctype="multipart/form-data">
			<div class="row-fluid">
				<div class="span12">
					<table class="table table-bordered">
					    
				    	{$createform}
					    
					 
					</table>
				</div>
			
			</div>
			<div class="form-actions">
				<button class="btn btn-primary js-ajax-submit" type="submit">提交</button>
				<a class="btn" href="{:U('{$fileName}/index')}">返回</a>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="__PUBLIC__/js/common.js"></script>
	<script type="text/javascript">
		//编辑器路径定义
		var editorURL = GV.WEB_ROOT;
	</script>
	<script type="text/javascript" src="__PUBLIC__/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/ueditor/ueditor.all.min.js"></script>
	<script type="text/javascript" src="/public/js/laydate/laydate.js"></script>
	<script type="text/javascript">
		$(function() {
			$(".js-ajax-close-btn").on('click', function(e) {
				e.preventDefault();
				Wind.use("artDialog", function() {
					art.dialog({
						id : "question",
						icon : "question",
						fixed : true,
						lock : true,
						background : "#CCCCCC",
						opacity : 0,
						content : "您确定需要关闭当前页面嘛？",
						ok : function() {
							setCookie("refersh_time", 1);
							window.close();
							return true;
						}
					});
				});
			});
			/////---------------------
			Wind.use('validate', 'ajaxForm', 'artDialog', function() {
				//javascript

				//编辑器
				editorcontent = new baidu.editor.ui.Editor();
				editorcontent.render('content');
				try {
					editorcontent.sync();
				} catch (err) {
				}
				//增加编辑器验证规则
				jQuery.validator.addMethod('editorcontent', function() {
					try {
						editorcontent.sync();
					} catch (err) {
					}
					return editorcontent.hasContents();
				});
				var form = $('form.js-ajax-forms');
				//ie处理placeholder提交问题
				if ($.browser && $.browser.msie) {
					form.find('[placeholder]').each(function() {
						var input = $(this);
						if (input.val() == input.attr('placeholder')) {
							input.val('');
						}
					});
				}

				var formloading = false;
				//表单验证开始
				form.validate({
					//是否在获取焦点时验证
					onfocusout : false,
					//是否在敲击键盘时验证
					onkeyup : false,
					//当鼠标掉级时验证
					onclick : false,
					//验证错误
					showErrors : function(errorMap, errorArr) {
						//errorMap {'name':'错误信息'}
						//errorArr [{'message':'错误信息',element:({})}]
						try {
							$(errorArr[0].element).focus();
							art.dialog({
								id : 'error',
								icon : 'error',
								lock : true,
								fixed : true,
								background : "#CCCCCC",
								opacity : 0,
								content : errorArr[0].message,
								cancelVal : '确定',
								cancel : function() {
									$(errorArr[0].element).focus();
								}
							});
						} catch (err) {
						}
					},
					//验证规则
					rules : {
						'post[post_title]' : {
							required : 1
						},
						'post[post_content]' : {
							editorcontent : true
						}
					},
					//验证未通过提示消息
					messages : {
						'post[post_title]' : {
							required : '请输入标题'
						},
						'post[post_content]' : {
							editorcontent : '内容不能为空'
						}
					},
					//给未通过验证的元素加效果,闪烁等
					highlight : false,
					//是否在获取焦点时验证
					onfocusout : false,
					//验证通过，提交表单
					submitHandler : function(forms) {
						if (formloading)
							return;
						$(forms).ajaxSubmit({
							url : form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
							dataType : 'json',
							beforeSubmit : function(arr, \$form, options) {
								formloading = true;
							},
							success : function(data, statusText, xhr, $form) {
								formloading = false;
								if (data.status) {
									setCookie("refersh_time", 1);
									//添加成功
									Wind.use("artDialog", function() {
										art.dialog({
											id : "succeed",
											icon : "succeed",
											fixed : true,
											lock : true,
											background : "#CCCCCC",
											opacity : 0,
											content : data.info,
											button : [ {
												name : '继续添加？',
												callback : function() {
													reloadPage(window);
													return true;
												},
												focus : true
											}, {
												name : '返回列表页',
												callback : function() {
													location = "{:U('{$fileName}/index')}";
													return true;
												}
											} ]
										});
									});
								} else {
									artdialog_alert(data.info);
								}
							}
						});
					}
				});
			});
			////-------------------------
		});
	</script>
</body>
</html>
EOT;

    		    
fwrite($myfile, $txt);

fclose($myfile);	    
    		    
    		    
    		    
$myfile = fopen($path."/edit.html", "w");
	
	
$addtxt=<<<EOT

<admintpl file="header" />
<style type="text/css">
.pic-list li {
	margin-bottom: 5px;
}
</style>
<script type="text/html" id="photos-item-wrapper">
	<li id="savedimage{id}">
		<input id="photo-{id}" type="hidden" name="photos_url[]" value="{filepath}"> 
		<input id="photo-{id}-name" type="text" name="photos_alt[]" value="{name}" style="width: 160px;" title="图片名称">
		<img id="photo-{id}-preview" src="{url}" style="height:36px;width: 36px;" onclick="parent.image_preview_dialog(this.src);">
		<a href="javascript:upload_one_image('图片上传','#photo-{id}');">替换</a>
		<a href="javascript:(function(){\$('#savedimage{id}').remove();})();">移除</a>
	</li>
</script>
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li><a href="{:U('{$fileName}/index')}">内容管理</a></li>
			<li><a href="{:U('{$fileName}/add')}" target="_self">内容添加</a></li>
			<li class="active"><a href="#">内容编辑</a></li>
		</ul>
		<form action="{:U('{$fileName}/edit_post')}" method="post" class="form-horizontal js-ajax-forms" enctype="multipart/form-data">
			<div class="row-fluid">
				<div class="span12">
					<table class="table table-bordered">


                        {$createform}

					</table>
				</div>
			</div>
			<div class="form-actions">
				<button class="btn btn-primary js-ajax-submit" type="submit">提交</button>
				<a class="btn" href="{:U('{$fileName}/index')}">返回</a>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="__PUBLIC__/js/common.js"></script>
	<script type="text/javascript">
		//编辑器路径定义
		var editorURL = GV.WEB_ROOT;
	</script>
	<script type="text/javascript" src="__PUBLIC__/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="__PUBLIC__/js/ueditor/ueditor.all.min.js"></script>
	<script type="text/javascript" src="/public/js/laydate/laydate.js"></script>
	<script type="text/javascript">
		$(function() {
			
			//setInterval(function(){public_lock_renewal();}, 10000);
			$(".js-ajax-close-btn").on('click', function(e) {
				e.preventDefault();
				Wind.use("artDialog", function() {
					art.dialog({
						id : "question",
						icon : "question",
						fixed : true,
						lock : true,
						background : "#CCCCCC",
						opacity : 0,
						content : "您确定需要关闭当前页面嘛？",
						ok : function() {
							setCookie("refersh_time", 1);
							window.close();
							return true;
						}
					});
				});
			});
			/////---------------------
			Wind.use('validate', 'ajaxForm', 'artDialog', function() {
				//javascript

				//编辑器
				editorcontent = new baidu.editor.ui.Editor();
				editorcontent.render('content');
				try {
					editorcontent.sync();
				} catch (err) {
				}
				//增加编辑器验证规则
				jQuery.validator.addMethod('editorcontent', function() {
					try {
						editorcontent.sync();
					} catch (err) {
					}
					;
					return editorcontent.hasContents();
				});
				var form = $('form.js-ajax-forms');
				//ie处理placeholder提交问题
				if ($.browser && $.browser.msie) {
					form.find('[placeholder]').each(function() {
						var input = $(this);
						if (input.val() == input.attr('placeholder')) {
							input.val('');
						}
					});
				}
				//表单验证开始
				form.validate({
					//是否在获取焦点时验证
					onfocusout : false,
					//是否在敲击键盘时验证
					onkeyup : false,
					//当鼠标掉级时验证
					onclick : false,
					//验证错误
					showErrors : function(errorMap, errorArr) {
						//errorMap {'name':'错误信息'}
						//errorArr [{'message':'错误信息',element:({})}]
						try {
							$(errorArr[0].element).focus();
							art.dialog({
								id : 'error',
								icon : 'error',
								lock : true,
								fixed : true,
								background : "#CCCCCC",
								opacity : 0,
								content : errorArr[0].message,
								cancelVal : '确定',
								cancel : function() {
									$(errorArr[0].element).focus();
								}
							});
						} catch (err) {
						}
					},
					//验证规则
					rules : {
						'post[post_title]' : {
							required : 1
						},
						'post[post_content]' : {
							editorcontent : true
						}
					},
					//验证未通过提示消息
					messages : {
						'post[post_title]' : {
							required : '请输入标题'
						},
						'post[post_content]' : {
							editorcontent : '内容不能为空'
						}
					},
					//给未通过验证的元素加效果,闪烁等
					highlight : false,
					//是否在获取焦点时验证
					onfocusout : false,
					//验证通过，提交表单
					submitHandler : function(forms) {
						$(forms).ajaxSubmit({
							url : form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
							dataType : 'json',
							beforeSubmit : function(arr, \$form, options) {

							},
							success : function(data, statusText, xhr, $form) {
								if (data.status) {
									setCookie("refersh_time", 1);
									//添加成功
									Wind.use("artDialog", function() {
										art.dialog({
											id : "succeed",
											icon : "succeed",
											fixed : true,
											lock : true,
											background : "#CCCCCC",
											opacity : 0,
											content : data.info,
											button : [ {
												name : '继续编辑？',
												callback : function() {
													//reloadPage(window);
													return true;
												},
												focus : true
											}, {
												name : '返回列表页',
												callback : function() {
													location = "{:U('{$fileName}/index')}";
													return true;
												}
											} ]
										});
									});
								} else {
									artdialog_alert(data.info);
								}
							}
						});
					}
				});
			});
			////-------------------------
		});
	</script>
</body>
</html>

EOT;




fwrite($myfile, $addtxt);

fclose($myfile);


$myfile = fopen($path."/index.html", "w");

$indexHtml=<<<EOT

<admintpl file="header" />
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="javascript:;">内容管理</a></li>
			<li><a href="{:U('{$fileName}/add')}" target="_self">添加内容</a></li>
		</ul>
		<form class="well form-search form-search-col clearfix" method="post" action="{:U('{$fileName}/index')}">
		
		   {$searchHtml}
		
			<span>
			<input type="submit" class="btn btn-primary" value="搜索" />
			<a class="btn btn-danger" href="{:U('{$fileName}/index')}">清空</a>
			</span>
		</form>
		<form class="js-ajax-form" action="" method="post">

			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
					
						{$tableHeader}
					</tr>
				</thead>
			    <foreach name="posts" item="vo">
			    <tr>
			    {$tableBody}
			    </tr>
			    </foreach>
			    
			</table>

			<div class="pagination">{\$page}</div>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/laydate/laydate.js"></script>
	<script src="__PUBLIC__/js/common.js"></script>
	<script>
		function refersh_window() {
			var refersh_time = getCookie('refersh_time');
			if (refersh_time == 1) {
				
			}
		}
		setInterval(function() {
			refersh_window();
		}, 2000);
		$(function() {
			setCookie("refersh_time", 0);
			Wind.use('ajaxForm', 'artDialog', 'iframeTools', function() {
				//批量复制
				$('.js-articles-copy').click(function(e) {
					var ids=[];
					$("input[name='ids[]']").each(function() {
						if ($(this).is(':checked')) {
							ids.push($(this).val());
						}
					});
					
					if (ids.length == 0) {
						art.dialog.through({
							id : 'error',
							icon : 'error',
							content : '您没有勾选信息，无法进行操作！',
							cancelVal : '关闭',
							cancel : true
						});
						return false;
					}
					
					ids= ids.join(',');
					art.dialog.open("__ROOT__/index.php?g=portal&m=AdminPost&a=copy&ids="+ ids, {
						title : "批量复制",
						width : "300px"
					});
				});
				//批量移动
				$('.js-articles-move').click(function(e) {
					var ids=[];
					$("input[name='ids[]']").each(function() {
						if ($(this).is(':checked')) {
							ids.push($(this).val());
						}
					});
					
					if (ids.length == 0) {
						art.dialog.through({
							id : 'error',
							icon : 'error',
							content : '您没有勾选信息，无法进行操作！',
							cancelVal : '关闭',
							cancel : true
						});
						return false;
					}
					
					ids= ids.join(',');
					art.dialog.open("__ROOT__/index.php?g=portal&m=AdminPost&a=move&old_term_id={\$term.term_id|default=0}&ids="+ ids, {
						title : "批量移动",
						width : "300px"
					});
				});
			});
		});
	</script>
</body>
</html>

EOT;

fwrite($myfile, $indexHtml);

fclose($myfile);


                
                
}
			
		
		  
		

			if (1) {
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
		$post=$this->CreatePage_model->where("t_id=$id")->find();
		$this->assign("post",$post);
		$this->display();
	}

	// 文章编辑提交
	public function edit_post(){
		if (IS_POST) {

			$_POST['post']['img'] = sp_asset_relative_url($_POST['post']['img']);

            $_POST['post']['t_create_time']=date("Y-m-d H:i:s");
			$article=I("post.post");

			$article['detail']=htmlspecialchars_decode($article['detail']);
			$result=$this->CreatePage_model->save($article);
			if ($result!==false) {
				$this->success("保存成功！");
			} else {
				$this->error("保存失败！");
			}
		}
	}

	// 文章排序
	public function listorders() {
		$status = parent::_listorders($this->term_relationships_model);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}

	/**
	 * 文章列表处理方法,根据不同条件显示不同的列表
	 * @param array $where 查询条件
	 */
	private function _lists($keyword,$type){


		$where["t_name"]=array('like','%'.$keyword.'%');
		
		if($type)
		{
		    $where["type"]=$type;
		    
		}

		$this->CreatePage_model
			->alias("a");


		$count=$this->CreatePage_model->count();

		$page = $this->page($count, 20);

		$this->CreatePage_model
			->alias("a")
			->limit($page->firstRow , $page->listRows)
			->where($where)
			->order("a.t_id asc");

		$posts=$this->CreatePage_model->select();

		//echo $this->CreatePage_model->getLastSql();

		$this->assign("page", $page->show('Admin'));
		$this->assign("keyword",$keyword);
		$this->assign("type",$type);
		$this->assign("posts",$posts);
	}

	// 文章删除
	public function delete(){
		if(isset($_GET['id'])){
			$id = I("get.id",0,'intval');
			if ($this->CreatePage_model->where(array('t_id'=>$id))->delete() !==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}

		if(isset($_POST['ids'])){
			$ids = I('post.ids/a');

			if ($this->CreatePage_model->where(array('id'=>array('in',$ids)))->delete()!==false) {
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

			if ( $this->CreatePage_model->where(array('id'=>array('in',$ids)))->save(array('post_status'=>1)) !== false ) {
				$this->success("审核成功！");
			} else {
				$this->error("审核失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["uncheck"]){
			$ids = I('post.ids/a');

			if ( $this->CreatePage_model->where(array('id'=>array('in',$ids)))->save(array('post_status'=>0)) !== false) {
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

			if ( $this->CreatePage_model->where(array('id'=>array('in',$ids)))->save(array('istop'=>1))!==false) {
				$this->success("置顶成功！");
			} else {
				$this->error("置顶失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["untop"]){
			$ids = I('post.ids/a');

			if ( $this->CreatePage_model->where(array('id'=>array('in',$ids)))->save(array('istop'=>0))!==false) {
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

			if ( $this->CreatePage_model->where(array('id'=>array('in',$ids)))->save(array('recommended'=>1))!==false) {
				$this->success("推荐成功！");
			} else {
				$this->error("推荐失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["unrecommend"]){
			$ids = I('post.ids/a');

			if ( $this->CreatePage_model->where(array('id'=>array('in',$ids)))->save(array('recommended'=>0))!==false) {
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
			$terms = $this->terms_model->order(array("path"=>"ASC"))->select();
			$new_terms=array();
			foreach ($terms as $r) {
				$r['id']=$r['term_id'];
				$r['parentid']=$r['parent'];
				$new_terms[] = $r;
			}
			$tree->init($new_terms);
			$tree_tpl="<option value='\$id'>\$spacer\$name</option>";
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
					$find_post=$this->CreatePage_model->field('post_keywords,post_source,post_content,post_title,post_excerpt,smeta')->where(array('id'=>$id))->find();
					if($find_post){
						$find_post['post_author']=$uid;
						$find_post['post_date']=date('Y-m-d H:i:s');
						$find_post['post_modified']=date('Y-m-d H:i:s');
						$post_id=$this->CreatePage_model->add($find_post);
						if($post_id>0){
							array_push($data, array('object_id'=>$post_id,'term_id'=>$term_id));
						}
					}
				}

				if ( $this->term_relationships_model->addAll($data) !== false) {
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
			$tree->init($new_terms);
			$tree_tpl="<option value='\$id'>\$spacer\$name</option>";
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
			$status=$this->CreatePage_model->where(array("id"=>array('in',$ids),'post_status'=>3))->delete();
			$this->term_relationships_model->where(array('object_id'=>array('in',$ids)))->delete();

			if ($status!==false) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}else{
			if(isset($_GET['id'])){
				$id = I("get.id",0,'intval');
				$status=$this->CreatePage_model->where(array("id"=>$id,'post_status'=>3))->delete();
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
			if ($this->CreatePage_model->where(array("id"=>$id,'post_status'=>3))->save(array("post_status"=>"1"))) {
				$this->success("还原成功！");
			} else {
				$this->error("还原失败！");
			}
		}
	}

}