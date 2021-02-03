<?
include_once("../mdaima_var_inc/config_system.php");//必须先调用获取基本参数 
include_once("../mdaima_var_inc/config_system_info.php");//必须先调用获取基本参数
include_once("../mdaima_var_inc/checkall.php"); 
include_once("../mdaima_var_inc/conn.php"); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="css/admin_style.css" rel="stylesheet" type="text/css" />

<link href="css/bootstrap_modal.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/highcharts.js"></script>
</head>

<body>
<? include_once("js/js_alert.php"); //调用MODULE弹出框?>
<div id="container" style="margin:30px 60px 0 60px;"></div>


<script type='text/javascript'>


Highcharts.setOptions({ 
    global: { 
        useUTC: false 
    } 
}); 

if ($.browser.msie) {//mozilla  msie   safari  opera
	var  browser=false
} else{
	var  browser=true
}
					
var chart; 
$(function() { 
	Highcharts.setOptions({
		colors:['#FF6600']
	});
    chart = new Highcharts.Chart({ 
        chart: { 
            renderTo: 'container', //图表放置的容器，DIV 
            defaultSeriesType: 'spline', //图表类型为曲线图 
            //--------------------------
			events: {
				load: function () {
		
					// set up the updating of the chart each second
					var series = this.series[0];
					var LoadData = function () {
		
		
						var drp = 0;
						$.ajax({
							
							url: 'status_question.php?sid='+Math.random(),
							//url:'aaa',
							data: "{drp:"+drp+"}", 
							dataType: 'json',
							type: 'post',
							contentType: "application/json;charset=utf-8",
							success: function (data) {
		
								var x = (new Date()).getTime(); 
								var y = data+0;
								series.addPoint([x, y], true, true);
		
							},
							error: function () { /*alert('Error !');*/ }
						});

					};
					//LoadData();
					setInterval(LoadData, 5000);
				}
			}
			//------------------------------
        }, 
        title: { 
			useHTML:true,
            text: "<span style='font-family:黑体;line-height:35px;'>向服务器发出的查询次数</span>"  //图表标题 
        }, 
        xAxis: { //设置X轴 
			type: 'datetime',  //X轴为日期时间类型 
            tickPixelInterval:150 //X轴标签间隔 
        }, 
        yAxis: { //设置Y轴 
			title: {
                text:"查询次数",//人<br>/<br>次<br>
	         	rotation:0

            }
            //max: 100, //Y轴最大值 
            //min: 10000  //Y轴最小值 
        }, 
        tooltip: {//当鼠标悬置数据点时的提示框 
            formatter: function() { //格式化提示信息 
                return '查询次数：'+Highcharts.numberFormat(this.y,0)+' 次，时间：'+Highcharts.dateFormat('%H:%M:%S', this.x);
            } 
        }, 
		
		legend: {                                                               
				enabled: browser                                                      
		},  
		
        exporting: { 
            enabled: false  //设置导出按钮不可用 
        }, 
        credits: { 
            text: '', //设置LOGO区文字 
            url: '' //设置LOGO链接地址 
        }, 
        series: [{ 
            name:'MYSQL查询次数统计',
			data: (function() { //设置默认数据， 
                var data = [], 
                time = (new Date()).getTime(), 
                i; 
 
                for (i = -19; i <= 0; i++) { 
                    data.push({ 
                        x: time + i * 5000,  
                        y: Math.random()*1000
                    }); 
                } 
                return data; 
            }()) 
        }]
    }); 
}); 



	</script>
</body>
</html>
