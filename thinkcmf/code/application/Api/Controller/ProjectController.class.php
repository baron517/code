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
class ProjectController extends Controller {

    private function curl_https($url, $data=array(), $header=array(), $timeout=30){

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
			//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

			$response = curl_exec($ch);

			if($error=curl_error($ch)){
				die($error);
			}

			curl_close($ch);

			return $response;

		}

    public function getImgList()
	{
	    $M= M("Auto_lunbo");
	    $list=$M->select();
        $res["code"]="1000";
        $res["msg"]="成功";
        $res["data"]=$list;
	    echo json_encode($res);
	}
	
	
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


