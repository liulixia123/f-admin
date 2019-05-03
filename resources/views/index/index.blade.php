
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0" charset="UTF-8">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<title>游戏前台首页</title>
		<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
		
		<style type="text/css">
     .cardtd .gamenametd{
        text-align:left;padding-left:15px;
     }
     #cardtype{
        height:20px;width:20px;
     }
     .spantd{
      color: #FF0000;font-size: 18px;
     }
     .gametd,.language,.size_range{
      text-align:center;
     }
     .gamebox{
      height:20px;width:20px;
     }
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
		<!--页头-->
		<header class="header">
			<table width="100%" border="0" align="left" cellpadding="0" style="margin:0 auto;" cellspacing="1">
			<tr>
			<td width="60%" style="text-align:left;padding-left:5px;"><span class="STYLE1">卡片实际容量:<span id="mycardrl">0</span></span></td>
			<td rowspan="3" style="text-align:center;">
				<button class="BigBtn2" id="selover" onclick="order()">选好提交</button>
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
			</table>
		</header>				
		<section class="main" id="groupForm">
			<div class="DeInfo_Inpet DeInfo_Inpet2">
				<div style="width:100%; height:95px; left:0;top:0;">
          <table width="100%" border="0" align="left" cellpadding="0" style="margin:0 auto;" cellspacing="1" bgcolor="#C4D8ED">
          	<tr>
          	<td style="text-align:left;padding-left:5px;" colspan="2">
          	<span style="color: #FF0000;font-size: 18px;">请先选择游戏机型:</span></td></tr>
          	<tr>
              
              <td style="text-align:left;padding-left:15px;" colspan="2">
              @foreach($typelist as $tlist)  
              <input id="machtype" name="machtype" type="radio" value="{{$tlist['type_name']}}" onchange="typeChange('{{$tlist['type_name']}}-{{$tlist['id']}}')"  style="height:20px;width:20px;" {{(isset($tlist['id'])&&$tlist['id'] == $id) ? 'checked' : ''}}/>
              <span style="color: #FF0000;font-size: 18px;">{{$tlist['type_name']}}</span>
              @endforeach
              	</td>
              </tr>

          </table>					
          <table id="tabcardtype" width="100%" border="0" align="left" cellpadding="0" style="margin:0 auto;" cellspacing="1" bgcolor="#C4D8ED">
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
        <div id="divGameInfo" style="width:100%; left:0;top:0;display: block">					
          <table width="100%" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor="#C4D8ED" id="gametable">
            <tr class="TdUl">
              <td colspan=6>可以选择的游戏信息</td>
            </tr>
           
            @foreach($games as $game)
              <tr id="row_{{$game['id']}}" class="gamelist">
                <td width="5%" style="text-align:center;"><input type="checkbox"  name="selarray[]" id="{{$game['id']}}" value="{{$game['id']}}" onChange='check()'  style="height:20px;width:20px;"/></td>
                <td width="10%" style="text-align:center;">{{$game['number']}}</td>
                <td width="40%" style="text-align:left;padding-left:5px;">{{$game['game_name']}}</td>
                <td width="10%" style="text-align:center;">{{$game['language']}}</td>
                <td width="15%" style="text-align:center;" id="gb_{{$game['id']}}">{{$game['size_range']}}{{$game['danwei']}}B</td>
              </tr>
            @endforeach
           
          </table>
        </div>
				</div>
			</section>
			
		</div>
		
<script type="text/javascript">
	$(document).ready(function(){

		


	});	
 
	function typeChange(machtype){
    type = machtype.split('-');
		$.get("{{url('/home/edit')}}",{id:type[1],type_name:type[0]},function(data){
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
            $("#gametable tr:not(:first)").remove();
            //添加游戏列表元素
            gametable = document.getElementById("gametable");
            for(var i =0 ;i<games.length;i++){
                gametable.appendChild(getGameDataRow(games[i]));
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
    var row = document.createElement('tr');
        row.id = "row_"+h.id;
    var td = document.createElement('td');
    td.className = "gametd";
    var tdinput = document.createElement('input');
        tdinput.setAttribute('type','checkbox');
        tdinput.setAttribute('id',h.id);
        tdinput.setAttribute('name','selarray[]');
        tdinput.setAttribute('value',h.id);
        tdinput.setAttribute('onChange','check()');
        //tdinput.onpropertychange = check();
        tdinput.setAttribute('class','gamebox'); 
    td.appendChild(tdinput); 
    row.appendChild(td);
    var bianhao = document.createElement('td');
        bianhao.innerHTML = h.number;
        bianhao.className = "gametd";
    row.appendChild(bianhao);
    var name = document.createElement('td');
        name.innerHTML = h.game_name;
        name.className = "gamenametd";
    row.appendChild(name);
    var language = document.createElement('td');
        language.innerHTML = h.language;
        language.className = "languagetd";
    row.appendChild(language);
    var size_range = document.createElement('td');
        size_range.innerHTML = h.size_range+h.danwei+"B";
        size_range.className = "size_range";
        size_range.id ='gb_'+h.id;
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
      var typeid = document.getElementById('machtype').value;      
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
      $.get("{{url('/home/checkorder')}}",{type:typeid,card:cardsize_range,gameid:gameid},function(data){
          if(data['code']==0){
            window.location.href="{{url('/home/confirm')}}?type="+typeid+"&card="+card+"&gameid="+gameid.join(',');
          }else{
             layer.msg('失败');
          }

      },'json');

  }
</script>		
	</body>
</html>