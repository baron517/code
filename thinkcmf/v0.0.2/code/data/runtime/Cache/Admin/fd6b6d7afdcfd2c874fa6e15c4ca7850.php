<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title><?php echo C("NAME") ?></title>
		<meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge" />
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta name="robots" content="noindex,nofollow">
		<link href="/admin/themes/simplebootx/Public/assets/css/admin_login.css" rel="stylesheet" />
		<style>
		   
		    html,body{width:100%;height:100%;}
		
		</style>
		<script>
			if (window.parent !== window.self) {
					document.write = '';
					window.parent.location.href = window.self.location.href;
					setTimeout(function () {
							document.body.innerHTML = '';
					}, 0);
			}
		</script>
		
	</head>
<body>
	
	
	<div class="login-box">
	    
	    
   <form method="post" name="login" action="<?php echo U('public/dologin');?>" autoComplete="off" class="js-ajax-form">
   <div class="input-content">
       
       <div class="login_tit">
          <div>
            <i class="tit-bg left"></i>
              <?php echo C("NAME") ?>
            <i class="tit-bg right"></i>
          </div>
     </div>    

       
     
     <p class="p user_icon">
       <input type="text" name="username" type="text" placeholder="<?php echo L('USERNAME_OR_EMAIL');?>" title="<?php echo L('USERNAME_OR_EMAIL');?>" value="<?php echo cookie('admin_username');?>" data-rule-required="true"  autoComplete="off" data-msg-required="" class="login_txtbx" id="username">
     </p> 
     <p class="p pwd_icon">
       <input  type="password" autocomplete="off" name="password" placeholder="<?php echo L('PASSWORD');?>" title="<?php echo L('PASSWORD');?>" data-rule-required="true"  data-msg-required="" class="login_txtbx">
     </p>     	
     <div class="p val_icon">
        <div class="checkcode">
          <input type="text" id="J_codetext" name="verify" placeholder="<?php echo L('ENTER_VERIFY_CODE');?>" autocomplete="off" maxlength="4" class="login_txtbx">
          
          
        </div>
        <a class="ver_btn">
            
            <?php echo sp_verifycode_img('length=4&font_size=20&width=248&height=42&use_noise=1&use_curve=0','style="cursor: pointer;" title="点击获取"');?>
        </a>
      </div>      
      <div class="signup">
      	  
      	  <button type="submit" name="submit" class="gv js-ajax-submit" data-loadingmsg="<?php echo L('LOADING');?>">登&nbsp;&nbsp;录</button>
      	  
          <a class="gv" href="#">清&nbsp;&nbsp;空</a>
     </div>
  </div>
   </form>    
  
  <div class="canvaszz"> </div>
  <canvas id="canvas"></canvas> 
</div>

	

<script>
var GV = {
    ROOT: "/",
    WEB_ROOT: "/",
    JS_ROOT: "public/js/"
};
</script>

<script>

//宇宙特效
"use strict";
var canvas = document.getElementById('canvas'),
  ctx = canvas.getContext('2d'),
  w = canvas.width = window.innerWidth,
  h = canvas.height = window.innerHeight,

  hue = 217,
  stars = [],
  count = 0,
  maxStars = 2500;//星星数量

var canvas2 = document.createElement('canvas'),
  ctx2 = canvas2.getContext('2d');
canvas2.width = 100;
canvas2.height = 100;
var half = canvas2.width / 2,
  gradient2 = ctx2.createRadialGradient(half, half, 0, half, half, half);
gradient2.addColorStop(0.025, '#CCC');
gradient2.addColorStop(0.1, 'hsl(' + hue + ', 61%, 33%)');
gradient2.addColorStop(0.25, 'hsl(' + hue + ', 64%, 6%)');
gradient2.addColorStop(1, 'transparent');

ctx2.fillStyle = gradient2;
ctx2.beginPath();
ctx2.arc(half, half, half, 0, Math.PI * 2);
ctx2.fill();

// End cache

function random(min, max) {
  if (arguments.length < 2) {
    max = min;
    min = 0;
  }

  if (min > max) {
    var hold = max;
    max = min;
    min = hold;
  }

  return Math.floor(Math.random() * (max - min + 1)) + min;
}

function maxOrbit(x, y) {
  var max = Math.max(x, y),
    diameter = Math.round(Math.sqrt(max * max + max * max));
  return diameter / 2;
  //星星移动范围，值越大范围越小，
}

var Star = function() {

  this.orbitRadius = random(maxOrbit(w, h));
  this.radius = random(60, this.orbitRadius) / 18; 
  //星星大小
  this.orbitX = w / 2;
  this.orbitY = h / 2;
  this.timePassed = random(0, maxStars);
  this.speed = random(this.orbitRadius) / 500000; 
  //星星移动速度
  this.alpha = random(2, 10) / 10;

  count++;
  stars[count] = this;
}

Star.prototype.draw = function() {
  var x = Math.sin(this.timePassed) * this.orbitRadius + this.orbitX,
    y = Math.cos(this.timePassed) * this.orbitRadius + this.orbitY,
    twinkle = random(10);

  if (twinkle === 1 && this.alpha > 0) {
    this.alpha -= 0.05;
  } else if (twinkle === 2 && this.alpha < 1) {
    this.alpha += 0.05;
  }

  ctx.globalAlpha = this.alpha;
  ctx.drawImage(canvas2, x - this.radius / 2, y - this.radius / 2, this.radius, this.radius);
  this.timePassed += this.speed;
}

for (var i = 0; i < maxStars; i++) {
  new Star();
}

function animation() {
  ctx.globalCompositeOperation = 'source-over';
  ctx.globalAlpha = 0.5; //尾巴
  ctx.fillStyle = 'hsla(' + hue + ', 64%, 6%, 2)';
  ctx.fillRect(0, 0, w, h)

  ctx.globalCompositeOperation = 'lighter';
  for (var i = 1, l = stars.length; i < l; i++) {
    stars[i].draw();
  };

  window.requestAnimationFrame(animation);
}

animation();

</script>


<script src="/public/js/wind.js"></script>
<script src="/public/js/jquery.js"></script>
<script type="text/javascript" src="/public/js/common.js"></script>
<script>
;(function(){
	document.getElementById('username').focus();
})();
</script>
</body>
</html>