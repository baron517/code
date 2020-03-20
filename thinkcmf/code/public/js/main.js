//新增js
function addCSS(cssURL)
{

    var linkTag = $('<link href="' + cssURL + '" rel="stylesheet" type="text/css"  />');
// 请看清楚，是动态将link标签添加到head里   
$($('head')[0]).append(linkTag);
}


function addJS(Url)
{

    var tag = $('<script src="' + Url + '"   ></script>');

     $("body").append(tag);
}


addCSS("public/js/color/colpick.css");

addJS("public/js/color/colpick.js");







function bindEvent()
{
    $('.picker').colpick({

	layout:'hex',

	submit:0,
	onChange:function(hsb,hex,rgb,el,bySetColor) {

		$(el).css('border-color','#'+hex);

		if(!bySetColor) $(el).val("#"+hex);

	}
	

	
    });
    
}

bindEvent();


//处理列表类型字段
$(".status-text .hide").each(function()
{
    
    var obj=JSON.parse($(this).text());
    //console.log(obj);
    var dataValue=$(this).attr("data-value");
    for(var i in obj)
    {
       if(dataValue==i)
       {
           if(dataValue==1)
           {
             $(this).parent().append("<span style='color:red;'>"+obj[i]+"</span>");  
           }
           else
           {
               $(this).parent().append("<span>"+obj[i]+"</span>");   
           }
           
       }
    }
    
});


$("body").on("change",".import-col .file",function()
    {
        
        console.log($(this));
        var $that=$(this);
        
         var imageForm = new FormData();
        imageForm.append("file",$(this).get(0).files[0]);
		
		var layerIndex = layer.load(0, {   shade: [0.5,'#000'] });
    
        $.ajax({
           type: "POST",
           url: $(this).attr("data-url"),
           dataType:"json",
           processData: false,
           contentType: false,
           data: imageForm,
           success: function(data){
                   
                   console.log(data);
                   if(data.code=1000)
                   {
                       
                       layer.alert("导入成功");
                       setTimeout(function() {
                           window.location.reload();
                       }, 1000);
                   }
				   else
				   {
				       layer.alert("导入成功");
				   }
				   
                   
                   
              }
        });
        
    });


//编辑新增的多个表单处理
$(".add-list-json").each(function()
{
    
    if($(this).text())
    {
         
     var objList=JSON.parse($(this).text());
    
     console.log(objList);
    
    
    for(var i=0;i<objList.length;i++)
    {
        
        var h=0;
        var html="";
        
            console.log(objList[i]);
            
             for(var j in objList[i]) {
                 
                 console.log(j);
                 
                 if(i==0)
                 {
                     var inputObj=$(this).next().find(".add-row").eq(0).find("."+j);
                     
                     if(j.indexOf("img")==-1)
                     {
                          $(inputObj).val(objList[i][j]);
                     }
                     else
                     {
                         $(this).next().find(".add-row").eq(0).find(".img-hidden").val(objList[i][j]);
                         $(this).next().find(".add-row").eq(0).find(".file-img").attr("href",objList[i][j]);
                         
                         if(objList[i][j].indexOf(".mp4")>-1)
                         {
                             $(this).next().find(".add-row").eq(0).find("."+j+"-file-img").append('<span class="view-video">查看视频</span>');
                         }
                         else
                         {
                             $(this).next().find(".add-row").eq(0).find("."+j+"-file-img").append("<img style='max-width:90px;' src='"+objList[i][j]+"'>");
                         }
                         
                         
                        
                         
                     }
                     
                    
                     
                 }
                 else
                 {
                   
                    if(j.indexOf("img")==-1)
                    {
                           var labelText=$(this).next().find(".add-row").eq(0).find(".label-text").eq(h).text();    
                         html=html+"<span class='detail-col'><span class='label-text'>"+labelText+"</span><input data-name='"+j+"' class='"+j+"' value='"+objList[i][j]+"' type='text'></span>";
                     }
                     else
                     {
                         
                         
                     html=html+'<span class="detail-col"><span class="upload-col">选择文件<input class="file" type="file" data-type="img" style="width:400px;"><input data-name="img" data-type="hidden" value="'+objList[i][j]+'" class="'+j+'-hidden" type="hidden"></span><a target="_blank" class="file-img" href="'+objList[i][j]+'"><img style="max-width:90px;" src="'+objList[i][j]+'"></a></span>';
                         
                     }
                   
                   
                    
                 }
              
              h++;
             }
        //console.log(html);
        if(html)
        {
            $(this).next().append("<div class='add-row'>"+html+"<button type='button' class='small-btn delete-btn'>删除</button></div>");
        }
        
        
       }
    }
    
    
});


//新增表单：
$(".add-btn").click(function()
{
    var html="";
    $(this).parent().find("input").each(function()
    {
        if($(this).attr("data-type")=="img"||$(this).attr("data-type")=="hidden")
        {
            if($(this).attr("data-type")=="img")
            {
                html=html+'<span class="detail-col"><span class="upload-col">选择文件<input class="file" type="file" data-type="img" style="width:400px;"><input data-type="hidden" data-name="img" type="hidden"></span><a target="_blank" class="file-img" href=""></a></span>';
            }
        }
        else
        {
            html=html+"<span class='detail-col'><span class='label-text'>"+$(this).prev().text()+"</span><input class='"+$(this).attr('class')+"' data-name="+$(this).attr("data-name")+" type='text'></span>";
        }
        
        
        
    });
    $(this).parent().parent().append("<div class='add-row'>"+html+"<button type='button' class='small-btn delete-btn'>删除</button></div>");
    
    bindEvent();
    
    
});

$("body").on("click",".delete-btn",function()
{
    
    $(this).parent().remove();
    
});

 
function jisuan()
    {
        
        
        var detail=[];
        var sq_jine=0;
        
        $(".more-row-col li").each(function()
        {
            var obj={};
            obj.zhaiyao=$(this).find(".zhaiyao").val();
            obj.jine=$(this).find(".jine").val()==""?0:$(this).find(".jine").val();
            sq_jine=sq_jine+parseFloat(obj.jine);
            obj.pingzheng=$(this).find(".pingzheng").val();
            obj.beizhu=$(this).find(".beizhu").val();
            detail.push(obj);
            
        });
        
        $(".more-row-info").val(JSON.stringify(detail));
      
      
      $("#sq_jine").val(sq_jine);
    }
    

$(function()
{
    
    //导出excel
    $(".export-excel").click(function()
    {
       var tb=$(this).attr("data-table");
       console.log(tb);
       
       
       window.open("/Api/CommonApi/expExcel?tb_name="+tb);
       
        
    });
    
    
    
    $(".more-row-col .btn-col").click(function()
    {
       
       
       var addHtml="<li><label>摘要1</label><input class='zhaiyao' type='text'><label>金额</label><input class='jine' type='text'><span class='upload-col'>上传凭证<input type='file' class='file' data-type='doc' style='width:400px;'><input type='hidden' class='hidden pingzheng'></span><a target='_blank' class='file-doc' ></a><label>备注</label><input class='beizhu' type='text'><span class='delete-col'>删除</span></li>"; 
       $(this).next().append(addHtml);
        
    });
    
    $(".more-row-col").on("click",".delete-col",function()
    {
       console.log("remove");
       $(this).parent().remove(); 
        
    });
    
    
    //合计金额
    $(".more-row-col").on("input","input",function()
    {
         console.log("input");
        
       jisuan();
       
        
    });
    
   
    
    
    if($("#shenhe").length>0)
    {
         $.ajax({
           type: "GET",
           url: "index.php?g=Api&m=CommonApi&a=getSelectList",
           dataType:"json",
           data:{table:"tb_users"},
           success: function(data){
                   
                   console.log(data);
                   if(data.length>0)
                   {
                       
                       for(var i=0;i<data.length;i++)
                       {
                           if(!(data[i].user_login.indexOf("admin")>-1))
                           {
                               
                               var checkedList=JSON.parse($("#sq_shenpi").val());
                               var bucunzai=0;
                               for(var j=0;j<checkedList.length;j++)
                               {
                                   var nameStr=data[i].user_login+"-"+data[i].user_nicename;
                                   if(checkedList[j].name==nameStr)
                                   {
                                       bucunzai=1;
                                       break;
                                   }
                                  
                               }
                               
                               
                                if(bucunzai)
                                   {
                                        $("#shenhe").append("<span class='checkbox-col'><input checked type='checkbox' value='"+data[i].user_login+"-"+data[i].user_nicename+"' /><label>"+data[i].user_login+"-"+data[i].user_nicename+"</label></span>");
                                   }
                                   else{
                                        $("#shenhe").append("<span class='checkbox-col'><input type='checkbox' value='"+data[i].user_login+"-"+data[i].user_nicename+"' /><label>"+data[i].user_login+"-"+data[i].user_nicename+"</label></span>");
                                   }
                               
                               
                              
                           
                           }
                           
                       }
                       
                       
                      
                       
                       
                   }
                   
                   
              }
        });    
        
        
        
        
    }
    
    
    $(".checkbox-list").on("click",".checkbox-col input",function()
        {
            console.log("dianji");
            var sq_shenpi=[];
            $("#shenhe input").each(function()
            {
                
                if($(this).prop("checked"))
                {
                    var obj={};
                    obj.name=$(this).val();
                    obj.status=1;
                    sq_shenpi.push(obj);
                }
                
               
            });
            
            $("#sq_shenpi").val(JSON.stringify(sq_shenpi));
            
     });
    
    
    
    $("#chakan a").attr("target","_blank");
    
      $(".laydate").each(function()
    {
        var $that=$(this)[0];
        laydate.render({
          elem: $that
        });
        
    });
    
    $(".laydate-range").each(function()
    {
        var $that=$(this)[0];
       
	    laydate.render({
              elem: $that,
              range: true
            });
        
    });
    
    
    $("select").each(function()
    {
        
        var $that=$(this);
        
        if($(this).attr("data-url"))
        {
           $.ajax({
           type: "GET",
           url: "index.php?g=Api&m=CommonApi&a=getSelectList",
           dataType:"json",
           data:{table:$(this).attr("data-url")},
           success: function(data){
                   
                   console.log(data);
                   if(data.length>0)
                   {
                       
                       for(var i=0;i<data.length;i++)
                       {
                           
                           for(var j in data[i]) {

                               if(j.indexOf("name")>-1)
                               {
                                   if($that.attr("data-value")==data[i][j])
                                   {
                                       $that.append("<option selected>"+data[i][j]+"</option>");
                                   }
                                   else{
                                       $that.append("<option>"+data[i][j]+"</option>");
                                   }
                                   
                               }
                            
                            }
                           
                           
                       }
                   }
                   
                   
              }
        });
        }
        else{
            
            if($(this).parent().find(".select-html").length>0)
            {
                
                
                 var selectHtml=$(this).parent().find(".select-html");
            
            
                var selectHtmlObj=JSON.parse(selectHtml.text());
                for(var k in selectHtmlObj)
                {
                    if(k==$(this).attr("data-value"))
                    {
                         $(this).append('<option selected="selected" value="'+k+'">'+selectHtmlObj[k]+'</option>');
                    }
                    else
                    {
                         $(this).append('<option value="'+k+'">'+selectHtmlObj[k]+'</option>');
                    }
                   
                }
                
           
                
            }
            else
            {
                
                  if($(this).attr("data-value"))
                  {
                    var dataValue=$(this).attr("data-value");
                    $(this).find("option").each(function()
                    {
                       
                       if($(this).text()==dataValue||$(this).attr("value")==dataValue)
                       {
                           $(this).attr("selected","selected");
                       }
                        
                    });
                 }
                
            }
            
          
        }
        
    });
    
    
    $(".file-doc").each(function()
    {
        if($(this).attr("href"))
        {
            $(this).text("预览和下载");
        }
        
    });
    
    $(".file-video").each(function()
    {
        if($(this).attr("href"))
        {
            $(this).text("预览");
        }
        
    });
    
    
    
    $(".file-img").each(function()
    {
        if($(this).attr("href"))
        {
            
            console.log($(this).attr("href"));
            if($(this).attr("href").indexOf(".mp4")>-1)
            {
                $(this).html("<span class='view-video'>查看视频</span>");
               
            }
            else
            {
                 $(this).html("<img src='"+$(this).attr("href")+"' style='max-width:90px;'/>");
            }
            
        }
        
    });
    
    $(".checkbox-col input").each(function()
    {
        if($(this).attr("data-value")==$(this).val())
        {
            $(this).prop("checked","checked");
        }
        
    });
    
    
    $("body").on("change",".upload-col .file",function()
    {
        
        console.log($(this));
        var $that=$(this);
        
         var imageForm = new FormData();
        imageForm.append("file",$(this).get(0).files[0]);
		
		var layerIndex = layer.load(0, {   shade: [0.5,'#000'] });
    
        $.ajax({
           type: "POST",
           url: "index.php?g=Api&m=CommonApi&a=uploadFile",
           dataType:"json",
           processData: false,
           contentType: false,
           data: imageForm,
           success: function(data){
                   
                   console.log(data);
                   if(data.code=1000)
                   {
                       if($that.attr("data-type")=="img")
                       {
                           
                           if(data.data.url.indexOf(".mp4")>-1)
                           {
                                $that.parent().next().html('<span class="view-video">查看视频</span>');
                               $that.parent().next().attr("href",data.data.url);
                               $that.next().val(data.data.url);
                               
                           }
                           else
                           {
                               $that.parent().next().html("<img src='"+data.data.url+"' style='max-width:90px;'/>");
                               $that.parent().next().attr("href",data.data.url);
                               $that.next().val(data.data.url);
                              
                               
                           }
                           
                           
                           
                           
                           
                       }
                       else if($that.attr("data-type")=="video"){
                           $that.parent().next().html('<span class="view-video">查看视频</span>');
                           $that.parent().next().attr("href",data.data.url);
                           $that.next().val(data.data.url);
                       }
                       else{
                           $that.parent().next().html("预览和下载");
                           $that.parent().next().attr("href",data.data.url);
                           $that.next().val(data.data.url);
                       }
                       
                   }
				   
				   layer.close(layerIndex);
                   
                   
              }
        });
        
        
        
    });
    
    
    //select2
    $(".select2").select2({
      tags: true
    });
    
});
