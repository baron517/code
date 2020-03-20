<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Api\Controller;
use Think\Controller;

header("Access-Control-Allow-Origin: *");

/**
 * 首页
 */
class ProjectController extends BaseController  {

    
	public function getTypeList()
	{
	    $M= M("Auto_type");
	    $list=$M->select();
	    
	    
	    for($i=0;$i<count($list);$i++)
	    {
	        
	        $list[$i]["t_img_index"]=json_decode(htmlspecialchars_decode($list[$i]["t_img_index"]),1);
	        $list[$i]["t_img_detail"]=json_decode(htmlspecialchars_decode($list[$i]["t_img_detail"]),1);
	        $list[$i]["t_taocan"]=json_decode(htmlspecialchars_decode($list[$i]["t_taocan"]),1);
	        
	        
	    }
	    
        $res["code"]="1000";
        $res["msg"]="成功";
        
        $res["data"]=$list;
	    echo json_encode($res);
	}
	
	

}


