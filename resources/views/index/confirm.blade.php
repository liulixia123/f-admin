<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0" charset=utf-8"UTF-8">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<title>提交游戏采购</title>		
		
		<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
	
	<script language="javascript" type="text/javascript">
	<!--
	$(function(){
	    $("#add_button").click(function(){    	
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
			var selcartype=$("#selcartype").val();
			if (selcartype==""){
				layer.open({
					  title: '提示信息'
					  ,content: '用户选择存储卡片信息丢失,请刷新本页重新操作！'
					}); 
				return false;
			}
			var selgameconent=$("#selgameconent").val();
			if (selgameconent==""){
				layer.open({
					  title: '提示信息'
					  ,content: '用户选择游戏列表信息丢失,请刷新本页重新操作！'
					}); 
				return false;
			}
		})
	})
	-->
	function formSubmit() {
		if(check()){
			document.getElementById("form1").submit();
		}
	    
	}
	</script>
	<style type="text/css">
	<!--
	.STYLE1 {
		color: #ff0000;
		font-size: 15px;
		font-weight: bold;
	}
	-->
	</style>
</head>
<body>
	<form name="form1" method="post" action="{{url('/home/confirm')}}" id="form1" onsubmit="return check()">
		<div class="wrapper">
			<!--页头-->
			<header class="header">
				<a href="index.php" class="return floatL"></a>
				<h3 class="floatL Logo headTit">提交游戏采购</h3>
			</header>				
			<section class="main" id="groupForm">
				<div class="DeInfo_Inpet DeInfo_Inpet2">
				填写用户信息<span class="STYLE1">(注意：本店会按照你选的游戏进行拷贝，不少拷也不多考，请确认选好后再提交，谢谢~！)</span>
					<div class="DeInfoInput LoginInput">
						<label class="icon-1 floatL"></label>
						<label style="display: none;">请填写收货手机号码：</label>
						<input type="text" name="mobile" id="mobile" placeholder="请填写收货手机号码" class="DeInfo_text" data-regtest="^1[3|4|5|7|8]\d{9}$ ">
					</div>
					<p class="errorShow">不能为空</p>
					
					<table width="100%" border="1" align="left" cellpadding="0" cellspacing="1" bgcolor="#C4D8ED">
					  <tr class="TdUl">
						<td colspan=5 align="left">已经选择的游戏游戏信息</td>
					  </tr>
						@foreach($gamearr as $game)
						   <tr class="TdSecond" id="row_{{$game['id']}}">
							  <td style="text-align:left;padding-left:5px;">{{$game['game_name']}}</td>
							  <td style="text-align:left;padding-left:5px;">{{$game['number']}}</td>
							  <td style="text-align:left;padding-left:5px;">{{$game['language']}}</td>
							  <td style="text-align:left;padding-left:5px;" id="gb_PCSD00021">{{$game['size_range']}}</td>
						  </tr>	
					  	@endforeach
					   <tr>
						   <td colspan="4">
						   	  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
						   	  <input name="type" id="type" type="hidden" value='{{request()->input("type")}}'/>
							  <input name="selcartype" id="selcartype" type="hidden" value='{{request()->input("card")}}'/>
							  <input name="gameid" id="selgameconent" type="hidden" value='{{request()->input("gameid")}}'/>
							  <input type="submit" name="submit" value="提交游戏采购单" id="add_button" style="width:100%;height:50px;">
							</td>
						</tr>
						</table>
					</div>				
				</section>
									
			</div>
		</form>
	</body>
</html>