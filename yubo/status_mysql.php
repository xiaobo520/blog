<?
include_once("../mdaima_var_inc/config_system.php");//�����ȵ��û�ȡ�������� 
include_once("../mdaima_var_inc/config_system_info.php");//�����ȵ��û�ȡ��������
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
<? include_once("js/js_alert.php"); //����MODULE������?>
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
            renderTo: 'container', //ͼ����õ�������DIV 
            defaultSeriesType: 'spline', //ͼ������Ϊ����ͼ 
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
            text: "<span style='font-family:����;line-height:35px;'>������������Ĳ�ѯ����</span>"  //ͼ����� 
        }, 
        xAxis: { //����X�� 
			type: 'datetime',  //X��Ϊ����ʱ������ 
            tickPixelInterval:150 //X���ǩ��� 
        }, 
        yAxis: { //����Y�� 
			title: {
                text:"��ѯ����",//��<br>/<br>��<br>
	         	rotation:0

            }
            //max: 100, //Y�����ֵ 
            //min: 10000  //Y����Сֵ 
        }, 
        tooltip: {//������������ݵ�ʱ����ʾ�� 
            formatter: function() { //��ʽ����ʾ��Ϣ 
                return '��ѯ������'+Highcharts.numberFormat(this.y,0)+' �Σ�ʱ�䣺'+Highcharts.dateFormat('%H:%M:%S', this.x);
            } 
        }, 
		
		legend: {                                                               
				enabled: browser                                                      
		},  
		
        exporting: { 
            enabled: false  //���õ�����ť������ 
        }, 
        credits: { 
            text: '', //����LOGO������ 
            url: '' //����LOGO���ӵ�ַ 
        }, 
        series: [{ 
            name:'MYSQL��ѯ����ͳ��',
			data: (function() { //����Ĭ�����ݣ� 
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
