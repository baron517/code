<?php if (!defined('THINK_PATH')) exit();?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
	<script type="text/javascript">
	//全局变量
	var GV = {
	    ROOT: "/",
	    WEB_ROOT: "/",
	    JS_ROOT: "public/js/",
	    APP:'<?php echo (MODULE_NAME); ?>'/*当前应用名*/
	};
	</script>
    <script src="/public/js/jquery.js"></script>
    <script src="/public/js/wind.js"></script>
    <script src="/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script>
    	$(function(){
    		$("[data-toggle='tooltip']").tooltip();
    	});
    </script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
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
		<a href="javascript:(function(){$('#savedimage{id}').remove();})();">移除</a>
	</li>
</script>
</head>
<body data-url="https://sy.pro.youzewang.com">
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo U('AutoType/index');?>">内容管理</a></li>
			<li><a href="<?php echo U('AutoType/add');?>" target="_self">内容添加</a></li>
			<li class="active"><a href="#">内容编辑</a></li>
		</ul>
		<form action="<?php echo U('AutoType/edit_post');?>" id="form" method="post" class="form-horizontal js-ajax-forms" enctype="multipart/form-data">
			<div class="row-fluid">
				<div class="span12">
					<table class="table table-bordered">


                        
    								<input type="hidden" style="width:400px;"  id="t_id" name="post[t_id]"   value="<?php echo ($post["t_id"]); ?>" />
                             <tr>
    							<th width="100">中文名</th>
    							<td>
    								<input type="text" style="width:400px;" id="t_zw_name" name="post[t_zw_name]"   value="<?php echo ($post["t_zw_name"]); ?>" />
    							</td>
    						</tr>
                             <tr>
    							<th width="100">英文名</th>
    							<td>
    								<input type="text" style="width:400px;" id="t_yw_name" name="post[t_yw_name]"   value="<?php echo ($post["t_yw_name"]); ?>" />
    							</td>
    						</tr>
                             <tr>
    							<th>颜色</th>
    							<td>
    								<input type="text" class="picker" style="width:100px;" id="t_color" name="post[t_color]"   value="<?php echo ($post["t_color"]); ?>" /> 例如：#ffffff
    							</td>
    						</tr>
                             <tr>
    							<th>首页图片</th>
    							<td id="t_img_indexMu" >
    							
    							    <input type="hidden" style="width:200px;" class="add-list-hidden" id="t_img_index" name="post[t_img_index]"   value="<?php echo ($post["t_img_index"]); ?>" />
    							    
    							    <div  class="add-list" >
    							    <div class="add-row"><span class="label-text">名称</span><input type="text" data-name="name" class="name"> <span class="upload-col" >选择图片
            								<input class="file" type="file"  data-type="img" style="width:400px;"   /><input data-type="hidden" data-name="img" type="hidden" ></span><a target="_blank" class="file-img" href=""></a> <button type="button" class="small-btn add-btn">新增</button></div>
    							    </div>
    							</td>
    						</tr>
                             <tr>
    							<th>详情图片</th>
    							<td id="t_img_detailMu" >
    							
    							    <input type="hidden" style="width:200px;" class="add-list-hidden" id="t_img_detail" name="post[t_img_detail]"   value="<?php echo ($post["t_img_detail"]); ?>" />
    							    
    							    <div  class="add-list" >
    							    <div class="add-row"><span class="label-text">名称</span><input type="text" data-name="name" class="name"> <span class="upload-col" >选择图片
            								<input class="file" type="file"  data-type="img" style="width:400px;"   /><input data-type="hidden" data-name="img" type="hidden" ></span><a target="_blank" class="file-img" href=""></a> <button type="button" class="small-btn add-btn">新增</button></div>
    							    </div>
    							</td>
    						</tr>
                             <tr>
    							<th>套餐</th>
    							<td id="t_taocanMu" >
    							
    							    <input type="hidden" style="width:200px;" class="add-list-hidden" id="t_taocan" name="post[t_taocan]"   value="<?php echo ($post["t_taocan"]); ?>" />
    							    
    							    <div  class="add-list" >
    							    <div class="add-row"><span class="label-text">名称</span><input type="text" data-name="name" class="name"><span class="label-text">价格</span><input type="text" data-name="price" class="price"><button type="button" class="small-btn add-btn">新增</button></div>
    							    </div>
    							</td>
    						</tr>
                             <tr>
    							<th width="100">主题数</th>
    							<td>
    								<input type="text" style="width:400px;" id="t_info1" name="post[t_info1]"   value="<?php echo ($post["t_info1"]); ?>" />
    							</td>
    						</tr>
                             <tr>
    							<th width="100">拍摄数量</th>
    							<td>
    								<input type="text" style="width:400px;" id="t_info2" name="post[t_info2]"   value="<?php echo ($post["t_info2"]); ?>" />
    							</td>
    						</tr>
                             <tr>
    							<th width="100">精修</th>
    							<td>
    								<input type="text" style="width:400px;" id="t_info3" name="post[t_info3]"   value="<?php echo ($post["t_info3"]); ?>" />
    							</td>
    						</tr>
                             <tr>
    							<th width="100">赠送相框</th>
    							<td>
    								<input type="text" style="width:400px;" id="t_info4" name="post[t_info4]"   value="<?php echo ($post["t_info4"]); ?>" />
    							</td>
    						</tr>
                             <tr>
    							<th width="100">底片</th>
    							<td>
    								<input type="text" style="width:400px;" id="t_info5" name="post[t_info5]"   value="<?php echo ($post["t_info5"]); ?>" />
    							</td>
    						</tr>
                             <tr>
    							<th width="100">适合年龄</th>
    							<td>
    								<input type="text" style="width:400px;" id="t_for_age" name="post[t_for_age]"   value="<?php echo ($post["t_for_age"]); ?>" />
    							</td>
    						</tr>
                             <tr>
    							<th>特别说明</th>
    							<td>
    							<script type="text/plain" id="content" name="post[t_shuoming]"><?php echo ($post["t_shuoming"]); ?></script>
    							
    							</td>
    						</tr>

					</table>
				</div>
			</div>
			<div class="form-actions">
				<button class="btn btn-primary js-ajax-submit" type="button" id="submitBtn">提交</button>
				<a class="btn" href="<?php echo U('AutoType/index');?>">返回</a>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/common.js"></script>
	<script type="text/javascript" src="/public/js/main.js"></script>
	<script type="text/javascript">
		//编辑器路径定义
		var editorURL = GV.WEB_ROOT;
	</script>
	<script type="text/javascript" src="/public/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="/public/js/ueditor/ueditor.all.min.js"></script>
	<script type="text/javascript" src="/public/js/laydate/laydate.js"></script>
	<script type="text/javascript">
	
	     $("#submitBtn").click(function()
		    {
		    
		      
		      
		      $(".add-list").each(function()
		      {
		          var addJson=[];
		           $(this).find(".add-row").each(function()
    		      {
    		          var obj={};
    		          $(this).find("input").each(function()
    		          {
    		              if($(this).attr("data-type")!="img")
    		              {
    		                   obj[$(this).attr("data-name")]=$(this).val();
    		              }
    		          
    		             
    		          });
    		          addJson.push(obj);
    		          
    		      });
    		      
    		      $(this).prev().val(JSON.stringify(addJson));
    		          
		      });
		      
		     
		      
		    
		    
		       $("form").submit(); 
		       
		       
		       
		    });
	
	
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
							beforeSubmit : function(arr, $form, options) {

							},
							success : function(data, statusText, xhr, ) {
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
													location = "<?php echo U('AutoType/index');?>";
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