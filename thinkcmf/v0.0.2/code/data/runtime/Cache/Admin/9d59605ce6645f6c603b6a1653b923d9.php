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
	<link href="/public/js/select2/css/select2.min.css" rel="stylesheet" />
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
	<script src="/public/js/layer/layer.js"></script>
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

<style>
    
    .jiequ{max-width: 200px;word-break:break-all;}
    
</style>

</head>
<body data-url="http://fawu.pro.youzewang.com">
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="javascript:;">内容管理</a></li>
			<li><a href="<?php echo U('AutoSystemLog/add');?>" target="_self">添加内容</a></li>
		</ul>
		<form class="well form-search form-search-col clearfix" method="post" action="<?php echo U('AutoSystemLog/index');?>">
		
		   
                             <span>
                			<label>用户名</label>
                			<input type="text" name="post[user_name]" style="width: 200px;" value="<?php echo ((isset($post["user_name"]) && ($post["user_name"] !== ""))?($post["user_name"]):""); ?>">
                			</span>
                             <span>
                			<label>名称</label>
                			<input type="text" name="post[name]" style="width: 200px;" value="<?php echo ((isset($post["name"]) && ($post["name"] !== ""))?($post["name"]):""); ?>">
                			</span>
		
			<span>
			<input type="submit" class="btn btn-primary" value="搜索" />
			<a class="btn btn-danger" href="<?php echo U('AutoSystemLog/index');?>">清空</a>
			
			</span>
		</form>
		<form class="js-ajax-form" action="" method="post">

			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
					
						
                        <th>id</th>
                                <th >用户id</th>
                                <th >用户名</th>
                                <th >应用名</th>
                                <th >控制器</th>
                                <th >方法</th>
                                <th >url参数</th>
                                <th >提交的参数</th>
                                <th >访问ip</th>
                                <th >创建时间</th>
                                <th >名称</th>
                <th width='70' class=>操作</th>
					</tr>
				</thead>
			    <?php if(is_array($posts)): foreach($posts as $key=>$vo): ?><tr>
			     
                        <td><?php echo ($vo["id"]); ?></td>
                        <td><?php echo ($vo["user_name"]); ?></td>
                                <td><?php echo ($vo["user"]); ?></td>
                                <td><?php echo ($vo["app"]); ?></td>
                                <td><?php echo ($vo["model"]); ?></td>
                                <td><?php echo ($vo["action"]); ?></td>
                                <td><?php echo ($vo["url_param"]); ?></td>
                                <td><div class="jiequ"><?php echo ($vo["post_param"]); ?></div></td>
                                <td><?php echo ($vo["ip"]); ?></td>
                                <td><?php echo ($vo["create_time"]); ?></td>
                                <td><?php echo ($vo["name"]); ?></td>
                        <td class=><a href=<?php echo U('AutoSystemLog/edit',array('id'=>$vo['id']));?>><?php echo L('EDIT');?></a> |
						<a href=<?php echo U('AutoSystemLog/delete',array('id'=>$vo['id']));?> class='js-ajax-delete'><?php echo L('DELETE');?></a></td>
			    </tr><?php endforeach; endif; ?>
			    
			</table>

			<div class="pagination"><?php echo ($page); ?></div>
		</form>
	</div>
	<script type="text/javascript" src="/public/js/laydate/laydate.js"></script>
	<script type="text/javascript" src="/public/js/select2/js/select2.min.js"></script>
	<script src="/public/js/common.js"></script>
	<script src="/public/js/main.js"></script>
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
					art.dialog.open("/index.php?g=portal&m=AdminPost&a=copy&ids="+ ids, {
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
					art.dialog.open("/index.php?g=portal&m=AdminPost&a=move&old_term_id=<?php echo ((isset($term["term_id"]) && ($term["term_id"] !== ""))?($term["term_id"]):0); ?>&ids="+ ids, {
						title : "批量移动",
						width : "300px"
					});
				});
			});
		});
	</script>
</body>
</html>