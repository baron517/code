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
class CommonApiController extends Controller {

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
	
	private function this_monday($timestamp=0,$is_return_timestamp=true){ 
            static $cache ; 
            $id = $timestamp.$is_return_timestamp; 
            if(!isset($cache[$id])){ 
                if(!$timestamp) $timestamp = time(); 
                $monday_date = date('Y-m-d', $timestamp-86400*date('w',$timestamp)+(date('w',$timestamp)>0?86400:-/*6*86400*/518400)); 
                if($is_return_timestamp){ 
                    $cache[$id] = strtotime($monday_date); 
                }else{ 
                    $cache[$id] = $monday_date; 
                } 
            } 
            return $cache[$id]; 
   
    } 
	
	 public function uploadFile()
    {
         function get_extension($file)
        {
          return end(explode('.', $file));
        }
        
        $DST_DIR = 'data/upload/'.time();  
        if ($_FILES['file']['name'] == '')
        {  
            
             $res["code"]="1001";
	         $res["msg"]="文件不能为空";
            
            
        }  
        else {  
            
            
            if ($_FILES['file']['error'] > 0) {  
                
                  $res["code"]="1002";
	              $res["msg"]="上传文件失败";
                
            }  
            else {  
                
                
                $fileUrl=$DST_DIR.".".get_extension($_FILES['file']['name']);
                
                $upload=move_uploaded_file($_FILES['file']['tmp_name'], $fileUrl); 
                if($upload)
                {
                   $res["code"]="1000";
	              $res["msg"]="上传文件成功"; 
	              $res["data"]["url"]=c("SERVER_URL")."/".$fileUrl;
                }
                else
                {
                      $res["code"]="1002";
	              $res["msg"]="上传文件失败";
                }
                
            }
            
        }
        
        echo json_encode($res);
        
    }
    
    
    public function uploadMultipleFile()
    {
         function get_extension($file)
        {
          return end(explode('.', $file));
        }
        
        $DST_DIR = c("SERVER_URL").'/data/upload/'.time();  
        if ($_FILES['file']['name'] == '')
        {  
            
             $res["code"]="1001";
	         $res["msg"]="文件不能为空";
            
            
        }  
        else {  
            
            
            if ($_FILES['file']['error'] > 0) {  
                
                  $res["code"]="1002";
	              $res["msg"]="上传文件失败";
                
            }  
            else {  
                
                
                $fileUrl=$DST_DIR.".".get_extension($_FILES['file']['name']);
                
                $upload=move_uploaded_file($_FILES['file']['tmp_name'], $fileUrl); 
                if($upload)
                {
                   $res["code"]="1000";
	              $res["msg"]="上传文件成功"; 
	              $res["data"]["url"]=$fileUrl;
                }
                else
                {
                      $res["code"]="1002";
	              $res["msg"]="上传文件失败";
                }
                
            }
            
        }
        
        echo json_encode($res);
        
    }


}


