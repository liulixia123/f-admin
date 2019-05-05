<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>@yield('title') | {{ Config::get('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="/static/admin/layui/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="/static/admin/css/admin.css" />
    <link rel="stylesheet" type="text/css" href="/static/admin/css/selectFilter.css" />  
   
    <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src = "https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
    <script src="/static/admin/js/selectFilter.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
.types_item {
  display: inline;
  width: 17%;
  height: 32px;
  position: absolute; 
  padding-right: 15px; 

}
.inputout{
  width: 65%;
  height:38px;
  padding: 5px;
  border: 1px solid #e6e6e6;
  margin-bottom: 5px;
  margin-left: -50px;
}
</style>
</head>
<body>
<div class="wrap-container">
    <form class="layui-form" style="width: 100%;padding-top: 20px;padding-right: 10px;" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <div class="layui-form-item">
        <label class="layui-form-label">机型名称:</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['type_name'] or ''}}" name="type_name" required lay-verify="type_name" placeholder="请输入2-12位数字字母或汉字" autocomplete="off" class="layui-input">
        </div>
    </div>
    
    <div class="layui-form-item">
        <input type="hidden" id="content" value="{{$count_type}}"/>
        <label class="layui-form-label">容量区间:</label><span onclick="add()" class="spanbutton"><i class="layui-icon">&#xe654;</i></span>
    </div>

    <div class="layui-form-item">
        <input type="file" id="chooseImage" name="picfile">
            <!-- 保存用户自定义的背景图片 -->
        <img id="cropedBigImg" value='custom' alt="lorem ipsum dolor sit" data-address='' title="自定义背景"/>
    </div>

    <div class="layui-form-item">
        <input type="file" id="chooseImage1" name="checkedpicfile">
            <!-- 保存用户自定义的背景图片 -->
        <img id="cropedBigImg1" value='custom' alt="lorem ipsum dolor sit" data-address='' title="自定义背景"/>
    </div>

    <div class="layui-form-item"> 
        @if(is_array($card_type)&&$card_type) 
        <table style="width: 100%;margin-bottom: 5px;" align="center">
        <thead style="margin-bottom: 5px;">
            <tr>
                <th>最小容量值</th>
                <th>最大容量值</th>
            </tr>
        </thead>
        
        <tbody width="100%">
        @foreach($card_type as $k =>$list) 
         <tr class="firsttr">
        <td  align="center" valign="middle" width="50%">
            <input type="text" name="card_type[{{$k}}][min_capacity]" onkeyup="checkP(this);"  onpaste="checkP(this);"  oncut="checkP(this);"  ondrop="checkP(this);"  onchange="checkP(this);" id="min_id_{{$k}}" onblur="checkinput({{$k}})" class="inputout" value="{{$list['min_capacity'] or '' }}">             
            <div class="types_item">              
                <div class="filter-box{{$k*2}}">
                    <div class="filter-text">
                        <input class="filter-title" type="text" readonly placeholder="pleace select" />
                        <i class="icon icon-filter-arrow"></i>
                    </div>
                    <select name="card_type[{{$k}}][min_capacity_danwei]" id="min_danwei_{{$k}}" onchange="checkchange({{$k}})">
                        <option value="M" {{isset($list['min_capacity_danwei'])&&$list['min_capacity_danwei']=='M'?'selected':''}}>MB</option>
                        <option value="G" {{isset($list['min_capacity_danwei'])&&$list['min_capacity_danwei']=='G'?'selected':''}}>GB</option>
                        <option value="T" {{isset($list['min_capacity_danwei'])&&$list['min_capacity_danwei']=='T'?'selected':''}}>TB</option>
                    </select>
                </div>                  
            </div>
        </td>
        <td  align="center" valign="middle" width="50%">
            <input type="text" name="card_type[{{$k}}][max_capacity]" onkeyup="checkP(this);"  onpaste="checkP(this);"  oncut="checkP(this);"  ondrop="checkP(this);"  onchange="checkP(this);" onblur="checkinput({{$k}})" id="max_id_{{$k}}" class="inputout" value="{{$list['max_capacity'] or '' }}">           
            <div class="types_item">              
                <div class="filter-box{{$k*2+1}}">
                    <div class="filter-text">
                        <input class="filter-title" type="text" readonly placeholder="pleace select" />
                        <i class="icon icon-filter-arrow"></i>
                    </div>
                    <select name="card_type[{{$k}}][max_capacity_danwei]" id="max_danwei_{{$k}}" onchange="checkchange({{$k}})">
                        <option value="M" {{isset($list['max_capacity_danwei'])&&$list['max_capacity_danwei']=='M'?'selected':''}}>MB</option>
                        <option value="G" {{isset($list['max_capacity_danwei'])&&$list['max_capacity_danwei']=='G'?'selected':''}}>GB</option>
                        <option value="T" {{isset($list['max_capacity_danwei'])&&$list['max_capacity_danwei']=='T'?'selected':''}}>TB</option>
                    </select>
                </div>              
            </div>
        </td>
        </tr>
       @endforeach
       </tbody>
       </table>
     @else
    <table style="width: 100%;margin-bottom: 5px;" align="center">
        <thead style="margin-bottom: 5px;">
            <tr>
                <th>最小容量值</th>
                <th>最大容量值</th>
            </tr>
        </thead>
        
        <tbody width="100%">
        <tr class="firsttr">
        <td  align="center" valign="middle" width="50%">
            <input type="text" name="card_type[0][min_capacity]" onkeyup="checkP(this);"  onpaste="checkP(this);"  oncut="checkP(this);"  ondrop="checkP(this);"  onchange="checkP(this);" id="min_id_0" onblur="checkinput(0)" class="inputout">             
            <div class="types_item">              
                <div class="filter-box0">
                    <div class="filter-text">
                        <input class="filter-title" type="text" readonly placeholder="pleace select" />
                        <i class="icon icon-filter-arrow"></i>
                    </div>
                    <select name="card_type[0][min_capacity_danwei]" id="min_danwei_0" onchange="checkchange(0)">
                        <option value="M">MB</option>
                        <option value="G" selected>GB</option>
                        <option value="T">TB</option>
                    </select>
                </div>                  
            </div>
        </td>
        <td  align="center" valign="middle" width="50%">
            <input type="text" name="card_type[0][max_capacity]" onkeyup="checkP(this);"  onpaste="checkP(this);"  oncut="checkP(this);"  ondrop="checkP(this);"  onchange="checkP(this);" onblur="checkinput(0)" id="max_id_0" class="inputout">            
            <div class="types_item">              
                <div class="filter-box1">
                    <div class="filter-text">
                        <input class="filter-title" type="text" readonly placeholder="pleace select" />
                        <i class="icon icon-filter-arrow"></i>
                    </div>
                    <select name="card_type[0][max_capacity_danwei]" id="max_danwei_0" onchange="checkchange(0)">
                        <option value="M">MB</option>
                        <option value="G" selected>GB</option>
                        <option value="T">TB</option>
                    </select>
                </div>              
            </div>
        </td>
        </tr>
        </tbody>
    </table>
     @endif         
    </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn layui-btn-normal" onclick="submit1()">立即提交</button>
                <!-- <button type="reset" class="layui-btn layui-btn-primary">重置</button> -->
            </div>
        </div>
        <input name="id" type="hidden" value="{{$info['id'] or ''}}">
    </form>


</body>
<script>
    //本小插件支持移动端哦    
    //这里是初始化
    var item = parseInt($("#content").val()); 
    for(var i=0;i<=item*2+1;i++){
         $('.filter-box'+i).selectFilter({
        callBack : function (val){
            //返回选择的值
            //console.log(val)
        }
    });
    }  
    
     $('#chooseImage').on('change',function(){
        var filePath = $(this).val(),         //获取到input的value，里面是文件的路径
            fileFormat = filePath.substring(filePath.lastIndexOf(".")).toLowerCase(),
            src = window.URL.createObjectURL(this.files[0]); //转成可以在本地预览的格式
            
        // 检查是否是图片
        if( !fileFormat.match(/.png|.jpg|.jpeg/) ) {
            error_prompt_alert('上传错误,文件格式必须为：png/jpg/jpeg');
            return;  
        }
  
        $('#cropedBigImg').attr('src',src);
});
     
     $('#chooseImage1').on('change',function(){
        var filePath = $(this).val(),         //获取到input的value，里面是文件的路径
            fileFormat = filePath.substring(filePath.lastIndexOf(".")).toLowerCase(),
            src = window.URL.createObjectURL(this.files[0]); //转成可以在本地预览的格式
            
        // 检查是否是图片
        if( !fileFormat.match(/.png|.jpg|.jpeg/) ) {
            error_prompt_alert('上传错误,文件格式必须为：png/jpg/jpeg');
            return;  
        }
  
        $('#cropedBigImg1').attr('src',src);
});


    function checkinput(s){
        max_capacity = parseFloat($("#max_id_"+s).val());
        min_capacity =  parseFloat($("#min_id_"+s).val());
        max_danwei= $("#max_danwei_"+s).val();
        min_danwei = $("#min_danwei_"+s).val();
        if(isNaN(min_capacity)){
            layer.msg("请输入最小值！");
            $("#min_id_"+s).focus();
            return false;
        }
        if(isNaN(max_capacity)){
            layer.msg("请输入最大值！");
            $("#max_id_"+s).focus();
            return false;
        }
        if(min_danwei=='G'){
            min_capacity = min_capacity*1000;
        }else if(min_danwei=='T'){
            min_capacity = min_capacity*1000*1000;
        }else{
            min_capacity = min_capacity;
        }
        if(max_danwei=='G'){
            max_capacity = max_capacity*1000;
        }else if(max_danwei=='T'){
            max_capacity = max_capacity*1000*1000;
        }else{
            max_capacity = max_capacity;
        }
        console.log(min_capacity);
        console.log(max_capacity);
        if(min_capacity>=max_capacity){
            layer.msg("最小值必须小于最大值！");
            $("#min_id_"+s).focus();
            return false;
        }
        return true;
        /*$("#AreaId").val();//获取当前选择项的值.
        var reg=/(^[1-9](\d+)?(\.\d{1,2})?$)|(^(0){1}$)|(^\d\.\d(\d)?$)/;
        if(!reg.test(s)){
            layer.msg("必须为合法数字(正数，最多两位小数)！");
        }else{
            alert("价格合法");
        }*/

    }
    function checkchange(s){
        max_capacity = parseFloat($("#max_id_"+s).val());
        min_capacity =  parseFloat($("#min_id_"+s).val());
        max_danwei= $("#max_danwei_"+s).val();
        min_danwei = $("#min_danwei_"+s).val();
        if(isNaN(min_capacity)){
            layer.msg("请输入最小值！");
            $("#min_id_"+s).focus();
            return false;
        }
        if(isNaN(max_capacity)){
            layer.msg("请输入最大值！");
            $("#max_id_"+s).focus();
            return false;
        }
        if(min_danwei=='G'){
            min_capacity = min_capacity*1000;
        }else if(min_danwei=='T'){
            min_capacity = min_capacity*1000*1000;
        }else{
            min_capacity = min_capacity;
        }
        if(max_danwei=='G'){
            max_capacity = max_capacity*1000;
        }else if(max_danwei=='T'){
            max_capacity = max_capacity*1000*1000;
        }else{
            max_capacity = max_capacity;
        }
        console.log(min_capacity);
        console.log(max_capacity);
        if(min_capacity>=max_capacity){
            layer.msg("最小值必须小于最大值！");
            $("#min_id_"+s).focus();
            return false;
        }
        return true;
    }
    function checkP(o){
        theV=isNaN(parseFloat(o.value))?0:parseFloat(o.value);
        theV=parseInt(theV*100)/100;
        if(theV!=o.value){
            theV=(theV*100).toString();
            if(theV.length>=2){
                theV=theV.substring(0,theV.length-2)+"."+theV.substring(theV.length-2,theV.length)
            }           
            o.value=theV;
        }
  
    }
    //插入容量表格样式
    function getDataRow(item){
    var jishu = item*2+1;
    var oushu = item*2;
    var row = document.createElement('tr');
    row.className ="firsttr"; 
    var td = document.createElement('td');      
    td.align ="center";
    td.valign="middle";
    var tdinput = document.createElement('input');
        tdinput.setAttribute('type','text');
        tdinput.setAttribute('id','min_id_'+item);
        tdinput.setAttribute('name','card_type['+item+'][min_capacity]');
        tdinput.setAttribute('class','inputout');
        tdinput.setAttribute('onkeyup','checkP(this)');
        tdinput.setAttribute('onpaste','checkP(this)'); 
        tdinput.setAttribute('oncut','checkP(this)'); 
        tdinput.setAttribute('ondrop','checkP(this)');  
        tdinput.setAttribute('onchange','checkP(this)'); 
        td.appendChild(tdinput);
    var mindiv = document.createElement('div');
        mindiv.className="types_item";
    var fiterdiv = document.createElement('div');
        fiterdiv.className="filter-box"+oushu;
    var fitertext = document.createElement('div');
        fitertext.className="filter-text";  
    var fiterinput = document.createElement('input');
        fiterinput.setAttribute('type','text');
        fiterinput.setAttribute('class','filter-title');
        fiterinput.setAttribute('readonly',true);
    var fiteri = document.createElement('i');
        fiteri.className="icon icon-filter-arrow";
        fitertext.appendChild(fiterinput);
        fitertext.appendChild(fiteri);
    var selectObj = document.createElement('select'); 
        selectObj.name = 'card_type['+item+'][min_capacity_danwei]'; 
        selectObj.id="min_danwei_"+item;
        selectObj.onpropertychange = checkchange(item);
    var myOption=document.createElement("option");
        myOption.setAttribute("value","M");
        myOption.appendChild(document.createTextNode("MB"));
     var myOption1=document.createElement("option");
        myOption1.setAttribute("value","G");
        myOption1.setAttribute("selected","selected");
        myOption1.appendChild(document.createTextNode("GB"))
     var myOption2 = document.createElement('option');
     myOption2.setAttribute("value","T");
     myOption2.appendChild(document.createTextNode("TB"));
     selectObj.appendChild(myOption);
     selectObj.appendChild(myOption1);
     selectObj.appendChild(myOption2);
     fiterdiv.appendChild(fitertext);
     fiterdiv.appendChild(selectObj);
     mindiv.appendChild(fiterdiv);
     td.appendChild(mindiv);
     row.appendChild(td);
     var rtd = document.createElement('td');      
    rtd.align ="center";
    rtd.valign="middle";
    var rtdinput = document.createElement('input');
        rtdinput.setAttribute('type','text');
        rtdinput.setAttribute('id','max_id_'+item);
        rtdinput.setAttribute('name','card_type['+item+'][max_capacity]');
        rtdinput.setAttribute('class','inputout');
        rtdinput.setAttribute('onkeyup','checkP(this)');
        rtdinput.setAttribute('onpaste','checkP(this)'); 
        rtdinput.setAttribute('oncut','checkP(this)'); 
        rtdinput.setAttribute('ondrop','checkP(this)');  
        rtdinput.setAttribute('onchange','checkP(this)'); 
        rtd.appendChild(rtdinput);
    var rmindiv = document.createElement('div');
        rmindiv.className="types_item";
    var rfiterdiv = document.createElement('div');
        rfiterdiv.className="filter-box"+jishu;
    var rfitertext = document.createElement('div');
        rfitertext.className="filter-text";  
    var rfiterinput = document.createElement('input');
        rfiterinput.setAttribute('type','text');
        rfiterinput.setAttribute('class','filter-title');
        rfiterinput.setAttribute('readonly',true);
    var rfiteri = document.createElement('i');
        rfiteri.className="icon icon-filter-arrow";
        rfitertext.appendChild(rfiterinput);
        rfitertext.appendChild(rfiteri);
    var rselectObj = document.createElement('select'); 
        rselectObj.name = 'card_type['+item+'][max_capacity_danwei]';   
        rselectObj.id="max_danwei_"+item;
        rselectObj.onpropertychange = checkchange(item);
    var rmyOption=document.createElement("option");
        rmyOption.setAttribute("value","M");
        rmyOption.appendChild(document.createTextNode("MB"));
     var rmyOption1=document.createElement("option");
        rmyOption1.setAttribute("value","G");
        rmyOption1.setAttribute("selected","selected");
        rmyOption1.appendChild(document.createTextNode("GB"))
    var rmyOption2 = document.createElement('option');
        rmyOption2.setAttribute("value","T");
        rmyOption2.appendChild(document.createTextNode("TB"));
     rselectObj.appendChild(rmyOption);
     rselectObj.appendChild(rmyOption1);
     rselectObj.appendChild(rmyOption2);

     rfiterdiv.appendChild(rfitertext);
     rfiterdiv.appendChild(rselectObj);
     rmindiv.appendChild(rfiterdiv);
     rtd.appendChild(rmindiv);

     row.appendChild(rtd);
    return row;

    }
    //添加容量表单元素按钮处理
    function add(){
        var item = parseInt($("#content").val());
        $("#content").val(item);
        var jishu = item*2+1;
        var oushu = item*2;
        $("#content").val(item+1);        
        $("tr[class=firsttr]:last").after(getDataRow(item));
        $('.filter-box'+oushu).selectFilter({
            callBack : function (val){
                //返回选择的值
                console.log(val)
            }
        });
        $('.filter-box'+jishu).selectFilter({
            callBack : function (val){
                //返回选择的值
                console.log(val)
            }
        });
        }

        function submit1(){ 
        var item = parseInt($("#content").val());
        /*for(var i=0;i<=item;i++){
            max_capacity = parseFloat($("#max_id_"+i).val());
            min_capacity =  parseFloat($("#min_id_"+i).val());
            max_danwei= $("#max_danwei_"+i).val();
            min_danwei = $("#min_danwei_"+i).val();
            if(isNaN(min_capacity)){
                layer.msg("请输入最小值！");
                $("#min_id_"+i).focus();
                return false;
            }
            if(isNaN(max_capacity)){
                layer.msg("请输入最大值！");
                $("#max_id_"+i).focus();
                return false;
            }
            if(min_danwei=='G'){
                min_capacity = min_capacity*1000;
            }else if(min_danwei=='T'){
                min_capacity = min_capacity*1000*1000;
            }else{
                min_capacity = min_capacity;
            }
            if(max_danwei=='G'){
                max_capacity = max_capacity*1000;
            }else if(max_danwei=='T'){
                max_capacity = max_capacity*1000*1000;
            }else{
                max_capacity = max_capacity;
            }           
            if(min_capacity>=max_capacity){
                layer.msg("最小值必须小于最大值！");
                $("#min_id_"+i).focus();
                return false;
            }
        }*/
        console.log($('form').serialize());
                $.ajax({
                    url:"{{url('/types/store')}}",
                    data:$('form').serialize(),
                    type:'post',
                    dataType:'json',
                    //mimeType:"multipart/form-data",
                    success:function(res){
                        console.log(res);
                        if(res.status == 1){
                            layer.msg(res.msg,{icon:6,time:1000});                            
                            var index = parent.layer.getFrameIndex(window.name);  
                            setTimeout(layer.close(layer.index),20000);                          
                            setTimeout(parent.layer.close(index),20000);
                        }else{
                            layer.msg(res.msg,{shift: 6,icon:5});
                        }
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                return false;
            
        }
</script>
</html>