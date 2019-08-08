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
class CommonApiController extends BaseController  {

	public function getSelectList()
	{
	    $tableName=$_GET["table"];
	    
	    $db = M();
	    $sql="select * from ".$tableName;
	    $list=$db->query($sql);
	    
	    echo json_encode($list);
	    
	}


    //上传文件
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
    
    
    //上传多个文件
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
    
    
    //获取轮播
    public function getLunbo()
	{
	    $M= M("Auto_lunbo");
	    $list=$M->select();
        $res["code"]="1000";
        $res["msg"]="成功";
        $res["data"]=$list;
	    echo json_encode($res);
	}
	
	
	//获取用户信息
	 public function getUserInfo()
	{
	     $M= M("Auto_member");
	    $data["m_openid"]=$_GET["m_openid"];
	    
	    $rs=$M->where($data)->find();
	    
	    $res["code"]="1000";
        $res["msg"]="成功";
        $res["data"]=$rs;
        
	    echo json_encode($res);
	}
	
	//保存用户信息
	public function userInfoSave()
	{
	    
	    $Member = M("Auto_member");
	    $data=$Member->create();
	    
	    $findData["m_openid"]=$data["m_openid"];
	    
	    if($data["m_openid"])
	    {
	         if($Member->where($findData)->find($data))
    	    {
    	        $rs=$Member->where($findData)->save($data); 
    	    }
    	    else{
    	        $rs=$Member->add($data); 
    	    }
	    
        
	         $res["code"]="1000";
	        $res["msg"]="用户信息保存成功";
    	    
	    }
	    else{
	        $res["code"]="1002";
	        $res["msg"]="openid 不能为空！";
	    }
	    
	    echo json_encode($res);
	    
	}
	
    //发送短信验证码
    public function sendCode()
	{
	        //$_POST["phone"]="17373349812";
            		
    		function generate_code($length = 6) {
                return rand(pow(10,($length-1)), pow(10,$length)-1);
            }
            
            $msgCode=generate_code();
        	$phone=$_POST["phone"];
            $data["code"]=$msgCode;
            $data["phone"]=$phone;
            $data["create_time"]=date("Y-m-d H:i:s");
            
            $Msg_code = M("Msg_code");
	     	$rs=$Msg_code->where("phone='".$phone."'")->find();
	     	if($rs)
	     	{
	     	    $rs1=$Msg_code->where("msg_code_id=".$rs['msg_code_id'])->save($data);
	     	}
	     	else{
	     	    $rs1=$Msg_code->add($data);
	     	}
	     	
            
               
            $phone=$_POST["phone"];
            $TemplateCode="SMS_137065009";
            
            $bianliang=Array (
                        "product" => "888",
                        "code"=>$msgCode
                    );
        
            $sendCodeRs=$this->sendMobileMsg($phone,$TemplateCode,$bianliang);
               
                
                sp_log($sendCodeRs."##############".$_POST["phone"]."\n","phoneCode.txt");
                
                
                if($sendCodeRs=="OK")
                {
                    $dataRs["code"]=1000;
                    $dataRs["msg"]="发送成功";
                    $dataRs["data"]=$sendCodeRs;
                }
                else{
                    $dataRs["code"]=1001;
                    $dataRs["msg"]="发送失败";
                    $dataRs["data"]=$sendCodeRs;
                }
                echo json_encode($dataRs);
            	     	
           
            		
           
	}
    	
	//绑定手机
	public function bindPost()
	{
	    
	    $phone=$_POST["phone"];
	    
        $Msg_code = M("Msg_code");
     	$codeData=$Msg_code->where("phone='".$phone."'")->find();
	    
	    
	    if($_POST["openid"])
	    {
	        
             if($codeData["code"]!=$_POST["code"])
    	    {
    	        $res["code"]="1001";
    	        $res["msg"]="验证码不正确";
    	       
    	        
    	    }
    	     else if($codeData["phone"]!=$_POST["phone"])
    	    {
    	        $res["code"]="1002";
    	        $res["msg"]="验证码发送的不是这个手机";
    	    }
    	    else{
            	$User = M("Auto_member");
            	$data["m_phone"]=$_POST["phone"];
            	$data["m_create_time"]=date("Y-m-d H:i:s");
        	    $findData["m_openid"]=$_POST["openid"];
        	   
        	    $rs=$User->where($findData)->find();
        	    if($rs)
        	    {
        	        	$rs=$User->where($findData)->save($data);
            	    	if($rs === FALSE)
            	    	{
            	    	    $res["code"]="1004";
                             $res["msg"]="绑定失败";
            	    	}
            	    	else if($rs==0)
            	    	{
            	    	    $res["code"]="1003";
                             $res["msg"]="已经绑定过此号码";
            	    	}
            	    	else{
                             
                              $res["code"]="1000";
                            $res["msg"]="绑定成功";
            	    	}
        	    }
        	    else{
        	        
        	        $data["m_openid"]=$_POST["openid"];
        	        $rs=$User->add($data);
        	        if($rs)
        	    	{
        	    	    $res["code"]="1000";
                         $res["msg"]="绑定成功";
        	    	}
        	    	else{
        	    	    $res["code"]="1005";
                         $res["msg"]="绑定失败";
        	    	}
        	        
        	    }
            
	    }
	        
	    }
	    else{
	        
	        $res["code"]="1001";
	        $res["msg"]="参数不正确";
	        
	    }
	   
	    
	    echo json_encode($res);
	    
	    
	    
	    
	}



}


