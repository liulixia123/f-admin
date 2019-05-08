
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0" charset="UTF-8">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<title>游戏前台首页</title>
    <link rel="stylesheet" type="text/css" href="/static/index/style.css">
		<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
		<script type="text/javascript" src="/static/index/jQuery-jcContact.js"></script>
		<style type="text/css">
    .jcContact{position:absolute;top:0;left:0;z-index:99;width:215px;}
    .jcConraper{width:174px;background:#ddd;overflow:hidden;top:100px;border-radius: 5px;}
    .jcConBtn{position:absolute;top:0;left:0;width:88%;height:150px;cursor:pointer;background:#ddd;border-radius: 5px;}
    .divrel {float:left;position:relative; width:52px; height:52px;margin-right: 10px;}
.radio {display:none}
.divs {display: inline;border-radius:15px; position:absolute; left:0; top:38px;width:52px; height:52px;color:#000;text-align: center;line-height: 50px;}
.divimg{display: inline;border-radius:15px;}
.divimgnone{border-radius:15px;display: none;}

     
<!--
.STYLE1 {
	color: #000000;
	font-size: 8px;
	font-weight: bold;
}
.STYLE2 {
	color: #ff0000;
	font-weight: bold;
}
-->
</style>
</head>
<body>
	<div class="wrapper">		
    <div id="demo2" class="jcContact">
     <div class="jcConraper">
         <!-- 自定义部分 -->
         
         <!-- 自定义部分 结束 -->
     </div>
     <div class="jcConBtn">
        <table width="100%" border="0" align="left" cellpadding="0" style="margin:0 auto;" cellspacing="1">
        <tr>
        <td width="60%" style="text-align:left;padding-left:5px;"><span class="STYLE1">卡片实际容量:<span id="mycardrl">0</span></span></td>
        <td rowspan="3" style="text-align:center;">
          
          <input id="typeid" type="hidden" value=""/>
          <input id="card" type="hidden" value=""/>
          <input id="gameid" type="hidden" value=""/>
          </td>
        </tr>
        <tr>
        <td style="text-align:left;padding-left:5px;"><span class="STYLE1">已选游戏总容量:<span id="selrlsum">0</span></span></td>
        </tr>
        <tr>
        <td style="text-align:left;padding-left:5px;"><span class="STYLE1">卡片剩余容量:<span id="havecardrl">0</span></span></td>
        </tr>
            <tr>
            <td style="text-align:left;padding-left:5px;"><span class="STYLE1">填写手机号:<input type="text" name="mobile" id="mobile" placeholder="请填写收货手机号码" class="DeInfo_text" data-regtest="^1[3|4|5|7|8]\d{9}$ "></td>
            </tr>
            <tr>
              <td><button class="BigBtn2" id="selover" onclick="order()">选好提交</button></td>
            </tr>
        </table>
      </div>
    </div>
		<section class="main" id="groupForm">
			<div class="DeInfo_Inpet DeInfo_Inpet2">
				<div style="width:100%; height:95px; left:0;top:0;">
          <table width="100%" border="0" align="left" cellpadding="0" style="margin:0 auto;" cellspacing="1">
          	<tr>
          	<td style="text-align:left;padding-left:5px;" colspan="2">
          	<span style="color: #FF0000;font-size: 18px;">请先选择游戏机型:</span></td></tr>
          	<tr>
              
              <td style="text-align:left;padding-left:15px;" colspan="2">
              @foreach($typelist as $tlist)  
              <!-- <input id="machtype" name="machtype" type="radio" value="{{$tlist['type_name']}}" onchange="typeChange('{{$tlist['type_name']}}-{{$tlist['id']}}')"  style="height:20px;width:20px;" {{(isset($tlist['id'])&&$tlist['id'] == $id) ? 'checked' : ''}}/>
              <span style="color: #FF0000;font-size: 18px;">{{$tlist['type_name']}}</span> -->
              <div class="divrel" onclick="getfun(this.id)" id="{{$tlist['id']}}">
                <input type="radio" value= "{{$tlist['type_name']}}" id="radio_{{$tlist['id']}}" name="machtype"  class="radio" onchange="typeChange('{{$tlist['type_name']}}-{{$tlist['id']}}')">
                <div  class="divs" id="{{$tlist['id']}}">{{$tlist['type_name']}}</div><img src="{{$tlist['picfile']}}" width="52" height="52" class="divimg" id='1'/><img src="{{$tlist['checkedpicfile']}}" width="52" height="52" class="divimgnone" />
              </div>
              @endforeach
              	</td>
              </tr>

          </table>					
          <table id="tabcardtype" width="100%" border="0" align="left" cellpadding="0" style="margin-top:20px;">
          	<tr id = 'cardtypetr'>
            	<td style="text-align:left;padding-left:5px;" colspan="2">
            	<span style="color: #FF0000;font-size: 18px;">请先选择卡片类型:</span></td>
            </tr>
            
          	@foreach($card_type as $ctype)
          	<tr class = "cardtypediv"> 
              <td class="cardtd">
              <input id="cardtype" name="cardtype" type="radio" value="{{$ctype['min_capacity']}}{{$ctype['min_capacity_danwei']}}B" onchange="cardClick('{{$ctype['min_capacity']}}{{$ctype['min_capacity_danwei']}}B')"/>
            	<span class="spantd">{{$ctype['max_capacity']}}{{$ctype['max_capacity_danwei']}}B={{$ctype['min_capacity']}}{{$ctype['min_capacity_danwei']}}B</span>
              </td>
            </tr> 
            @endforeach
          	
            </table>
      </div>
        
        <div>可以选择的游戏信息</div>
        <div class="biaoti">
          <span class="spandiv xuan"></span>
          <span class="spandiv bianhao">编号</span>
          <span class="spandiv name">名称</span>
          <span class="spandiv yuyuan">语言</span>
          <span class="spandiv capacity">容量</span>
        </div>
        <div style="max-height: 500px;overflow-y: scroll;">
            @foreach($games as $game)
              <div id="row_{{$game['id']}}" class="div1">
                <span class="spandiv xuan" ><input type="checkbox"  name="selarray[]" id="box{{$game['id']}}" value="{{$game['id']}}" onChange='check()'  onclick="update()"  class="gcs-checkbox"/><label for="box{{$game['id']}}"></label></span>
                <span  class="spandiv bianhao">{{$game['number']}}</span>
                <span  class="spandiv name">{{$game['game_name']}}</span>
                <span  class="spandiv yuyan">{{$game['language']}}</span>
                <span class="spandiv capacity" id="gb_{{$game['id']}}">{{$game['size_range']}}{{$game['danwei']}}B</span>
              </div>
            @endforeach
        <div>
				</div>
			</section>
			
		</div>
	<script>
$(function(){

   
  
  $('#demo2').jcContact({
    speed:700,
    position:'top',
    posOffsetY : 55,
    btnPosition : 'top',
    btnPosoffsetY : 44 ,
    float:'right',
    Event : "click"       
  });  
  
});
</script>	
<script type="text/javascript">

	$(document).ready(function(){

		


	});	

   function bgcChange(obj)
  {
    obj.onmouseover=function(){
      obj.style.backgroundColor="#f2f2f2";
    }
    obj.onmouseout=function(){
      obj.style.backgroundColor="#fff";
    }
  }
  function notbgcChange(obj)
  {
    obj.onmouseover=function(){
      obj.style.backgroundColor="#f5bb1c";
    }
    obj.onmouseout=function(){
      obj.style.backgroundColor="#f5bb1c";
    }
  }
  //复选框选择的行变色
  function update(){
  $("input[type='checkbox']").click(function(e){  
        e.stopPropagation();   
  });  //点击checkbox后防止tr的点击事件也被触发；
  
  $(':checkbox:not(:checked)').each(function(){  //对于未被选中checkbox的行
    id = parseInt(this.id.substr(3));   
    var par_node=document.getElementById(this.id).parentNode.parentNode;//这里的this代表input元素（节点），向上追述两个父级即可进入tr元素
    if(id&1){//基数行
      document.getElementById(par_node.id).style.background="#ffffff";//控制tr的背景色
      document.getElementById(par_node.id).style.color="#000000";//控制tr的字体色
    }else{//偶数行
      document.getElementById(par_node.id).style.background="#ffffff";//控制tr的背景色
      document.getElementById(par_node.id).style.color="#000000";//控制tr的字体色
    }
    bgcChange(document.getElementById(par_node.id));
       
  });
 
  $(':checkbox:checked').each(function(){   
    var par_node=document.getElementById(this.id).parentNode.parentNode;
    document.getElementById(par_node.id).style.background="#f5bb1c";
    document.getElementById(par_node.id).style.color="#ffffff";//控制tr的字体色
    //document.getElementById(par_node.id).onunbind('mouseenter');
    //document.getElementById(par_node.id).onunbind('mouseleave');
    notbgcChange(document.getElementById(par_node.id));
  });
}
   //机型图片点击交换

  function getfun(sId){
    var oImg = $(".divs");
    for (var i = 0; i < oImg.length; i++) {
      var oldimg = oImg[i].nextSibling.nextSibling.src;         
          var newimg = oImg[i].nextSibling.src;
          if (oImg[i].id == sId) {            
            if(oImg[i].previousSibling.previousSibling.checked==false){         
              oImg[i].previousSibling.previousSibling.checked = true;              
              oImg[i].nextSibling.nextSibling.src = newimg;
              oImg[i].nextSibling.src = oldimg;
              oImg[i].nextSibling.nextSibling.id='2';
              document.getElementById("radio_"+sId).checked=true;
              typeChange(sId);
            }
            
          } else {
            document.getElementById("radio_"+oImg[i].id).checked=false;
            if(oImg[i].nextSibling.nextSibling.id=='2'){
              oImg[i].nextSibling.nextSibling.src = newimg;
              oImg[i].nextSibling.src = oldimg;
              oImg[i].nextSibling.nextSibling.id="1";
            }

          }         
      }


  }
  //获取卡片类型
	function typeChange(machtype){
    console.log(machtype);
    //type = machtype.split('-');
		$.get("{{url('/home/edit')}}",{id:machtype},function(data){
        if(data['status']==1){
            typecard = data['data'][0];
            games = data['data'][1]['games'];
            var str = "";
            var gamestr = ""; 
            //移除table 下的tr
            $("#tabcardtype tr:not(:first)").remove();
            //添加卡片类型元素
            tab = document.getElementById("tabcardtype");
            for(var i =0 ;i<typecard.length;i++){
                tab.appendChild(getDataRow(typecard[i]));
            }
            //移除table 下的tr
            $(".div1").remove();
            //添加游戏列表元素
            gametable = $(".biaoti:last");
            for(var i =0 ;i<games.length;i++){
                gametable.after(getGameDataRow(games[i]));
            }          
            $("#mycardrl").text(0);
            $("#selrlsum").text(0);
            $("#havecardrl").text(0);
        }else{
          layer.msg('操作失败');
        }
    },'json');
	}

  //插入卡片类型表格元素
  function getDataRow(h){
    var row = document.createElement('tr');
    var td = document.createElement('td');
    td.className = "cardtd";
    var tdinput = document.createElement('input');
        tdinput.setAttribute('type','radio');
        tdinput.setAttribute('id','cardtype');
        tdinput.setAttribute('name','cardtype');
        tdinput.setAttribute('value',h.min_capacity+h.min_capacity_danwei+'B');
        tdinput.setAttribute('onchange','cardClick("'+h.min_capacity+h.min_capacity_danwei+'B'+'")'); 
    var spantd = document.createElement('span'); 
        spantd.className = "spantd"; 
        spantd.innerHTML= h.max_capacity+h.max_capacity_danwei+'='+h.min_capacity+h.min_capacity_danwei;
    td.appendChild(tdinput);
    td.appendChild(spantd);    
    row.appendChild(td);
    return row;

  }


  //插入游戏列表表格元素
  function getGameDataRow(h){
    var row = document.createElement('div');
        row.id = "row_"+h.id;
        row.className = "div1";
    var xuanspan = document.createElement('span'); 
        xuanspan.className = "spandiv xuan";   
    var tdinput = document.createElement('input');
        tdinput.setAttribute('type','checkbox');
        tdinput.setAttribute('id',"box"+h.id);
        tdinput.setAttribute('name','selarray[]');
        tdinput.setAttribute('value',h.id);
        tdinput.setAttribute('onChange','check()');
        tdinput.setAttribute('onclick','update()');
        //tdinput.onpropertychange = check();
        tdinput.setAttribute('class','gcs-checkbox'); 
    var label = document.createElement('label');        
        label.setAttribute('for',"box"+h.id); 
    xuanspan.appendChild(tdinput); 
    xuanspan.appendChild(label); 
    row.appendChild(xuanspan);
   var biaohaospan = document.createElement('span'); 
       biaohaospan.className = "spandiv bianhao";
      biaohaospan.innerHTML = h.number;
    row.appendChild(biaohaospan);
    var namespan = document.createElement('span'); 
        namespan.className = "spandiv name";
        namespan.innerHTML = h.game_name;
    row.appendChild(namespan);
    var language = document.createElement('span');
        language.className = "spandiv yuyan";
        language.innerHTML = h.language;        
    row.appendChild(language);
    var size_range = document.createElement('span');
        size_range.className = "spandiv capacity";
        size_range.id ='gb_'+h.id;
        size_range.innerHTML = h.size_range+h.danwei+"B";     
    row.appendChild(size_range);     
    return row;

  }
  function cardClick(s){

      $("#mycardrl").text(s);
  }
  //判断单位大小转换
  function getDanwei(size_range,danwei){
    if(danwei=="GB"){
      size_range = size_range*1000;
    }else if(danwei=="TB"){
      size_range = size_range*1000*1000;
    }else{
      size_range = size_range;
    }
    return size_range;
  }
  //判断是否选择游戏
  function check(){
   
    var chk_value =[];
    var card = $('input[name="cardtype"]:checked').val();
    if(!card){
      layer.msg("请选择卡片类型");
      return false;
    }
    carddanwei = card.substr(card.length-2,2);              
    cardsize_range = parseFloat(card.substr(0,card.length-2));
    cardsize = getDanwei(cardsize_range,carddanwei);
    var f = 0;
    $('input[name="selarray[]"]:checked').each(function(){
          id = $(this).val();
          str = $("#gb_"+id).text();
          danwei = str.substr(str.length-2,2);              
          size_range = parseFloat(str.substr(0,str.length-2));
          //计算选择游戏的和
          f += getDanwei(size_range,danwei);        
          if(f>cardsize){
            layer.msg("所选游戏超出卡片容量请重新选择");
            return false;
          }
          $("#selrlsum").text(f/1000);
          havecard = (cardsize-f)/1000;
          $("#havecardrl").text(havecard);
          chk_value.push($(this).val());
    });
    //console.log(chk_value);
  }

  //选好提交订单
  function order(){
       var mycardrl = $("#mycardrl").text();
      var selrlsum = $("#selrlsum").text();
      var havecardrl = parseFloat($("#havecardrl").text());     
      if(mycardrl==0){
        layer.msg("请选游戏卡片类型");
        return false;
      }
      if(selrlsum==0){
        layer.msg("请选游戏");
        return false;
      }
      if(havecardrl<0.00){
        layer.msg("选择的游戏已经超过了卡片的最大容量,请确定后再操作");
        return false;
      }
      //var typeid = document.getElementById('machtype').value; 
      var typeid = $('input[name="machtype"]:checked').val();     
      var card = document.getElementById('cardtype').value;
      carddanwei = card.substr(card.length-2,2);              
      cardsize_range = parseFloat(card.substr(0,card.length-2));
      cardsize = getDanwei(cardsize_range,carddanwei);
      /*console.log(card);*/
      var gameid =[]; 
      var f=0;     
      $('input[name="selarray[]"]:checked').each(function(){
          id = $(this).val();
          str = $("#gb_"+id).text();
          danwei = str.substr(str.length-2,2);              
          size_range = parseFloat(str.substr(0,str.length-2));
          //计算选择游戏的和
          f += getDanwei(size_range,danwei); 
          gameid.push($(this).val());
         
      }); 
      if(f>cardsize){
            layer.msg("所选游戏超出卡片容量请重新选择");
            return false;
      }
      var mobile=$("#mobile").val();
      if (mobile==""){
        layer.open({
            title: '提示信息'
            ,content: '填写收货手机号码不能为空！'
          }); 
        $("#mobile").focus();
        return false;
      }
      if (!mobile.match(/^1[34578]\d{9}$/)) { 
        layer.open({
            title: '提示信息'
            ,content: '手机号码格式不正确！'
          }); 
        //$("#moileMsg").html("<font color='red'>手机号码格式不正确！请重新输入！</font>"); 
        $("#mobile").focus();
        return false; 
      }     
      $.get("{{url('/home/checkorder')}}",{type:typeid,card:cardsize_range,gameid:gameid,mobile:mobile},function(data){
          if(data['code']==0){
            //window.location.href="{{url('/home/confirm')}}?type="+typeid+"&card="+card+"&gameid="+gameid.join(',');
            //询问框

              layer.confirm('是否确认提交？', {
                btn: ['确定','取消'] //按钮
              }, function(){
                confirmOrder();
              }, function(){
                layer.msg('取消成功', {
                  time: 2000, //20s后自动关闭
                });
              });
          }else{
             layer.msg('失败');
          }

      },'json');

  }

   function confirmOrder(){
    var type = $('input[name="machtype"]:checked').val(); 
    var card = document.getElementById('cardtype').value;
      carddanwei = card.substr(card.length-2,2);              
      cardsize_range = parseFloat(card.substr(0,card.length-2));
      cardsize = getDanwei(cardsize_range,carddanwei);
    var mobile=$("#mobile").val();
    var f=0;
    gameid=[];
    $('input[name="selarray[]"]:checked').each(function(){
          id = $(this).val();
          str = $("#gb_"+id).text();
          danwei = str.substr(str.length-2,2);              
          size_range = parseFloat(str.substr(0,str.length-2));
          //计算选择游戏的和
          f += getDanwei(size_range,danwei); 
          gameid.push($(this).val());
         
      }); 
    $.post("{{url('/home/confirm')}}",{type:type,selcartype:cardsize,mobile:mobile,gameid:gameid,_token:"{{ csrf_token() }}"},function(data){
      if(data['code']==0){
        layer.msg('已提交成功', {
                  time: 20000, //20s后自动关闭
                });
           setTimeout(window.location.href="{{url('/home')}}",3000);
      }else{
        layer.msg('提交失败', {
                  time: 2000, //20s后自动关闭
                });
      }
    },'json');
   }

</script>		
	</body>
</html>