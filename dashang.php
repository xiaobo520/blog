<style type="text/css">
					.content{width:100%;margin:20px auto 60px auto; z-index: 999;}
					.hide_box{z-index:99999;filter:alpha(opacity=50);background:#666;opacity: 0.5;-moz-opacity: 0.5;left:0;top:0;height:100%;width:100%;position:fixed;display:none;}
					.shang_box{width:540px;height:440px;padding:10px;background-color:#fff;border-radius:10px;position:fixed;z-index:99999;left:50%;top:50%;margin-left:-280px;margin-top:-230px;border:1px dotted #dedede;display:none;}
					.shang_box img{border:none;border-width:0;}
					.dashang{display:block;width:100px;margin:5px auto;height:25px;line-height:25px;padding:10px;background-color:#E74851;color:#fff;text-align:center;text-decoration:none;border-radius:10px;font-weight:bold;font-size:16px;transition: all 0.3s;}
					
					.shang_close{float:right;display:inline-block;}
					.shang_logo{display:block;text-align:center;margin:20px auto;}
					.shang_tit{width: 100%;height: 75px;text-align: center;line-height: 66px;color: #a3a3a3;font-size: 16px;background: url('/images/dashang/cy-reward-title-bg.jpg');font-family: 'Microsoft YaHei';margin-top: 7px;margin-right:2px;}
					.shang_tit p{color:#a3a3a3;text-align:center;font-size:16px;}
					.shang_payimg{width:140px;padding:10px;/*border:6px solid #EA5F00;**/margin:0 auto;border-radius:3px;height:140px;}
					.shang_payimg img{display:block;text-align:center;width:140px;height:140px; }
					.pay_explain{text-align:center;margin:10px auto;font-size:12px;color:#545454;}
					.radiobox{width: 16px;height: 16px;background: url('/images/dashang/radio2.jpg');display: block;float: left;margin-top: 5px;margin-right: 14px;}
					.checked .radiobox{background:url('/images/dashang/radio1.jpg');}
					.shang_payselect{text-align:center;margin:0 auto;margin-top:40px;cursor:pointer;height:60px;width:280px;}
					.shang_payselect .pay_item{display:inline-block;margin-right:10px;float:left;}
					.shang_info{clear:both;}
					.shang_info p,.shang_info a{color:#C3C3C3;text-align:center;font-size:12px;text-decoration:none;line-height:2em;}
				</style>
				
				<div class="content">
				<p><a href="javascript:void(0)" onClick="dashangToggle()" class="dashang" title="���ͣ�֧��һ��">����</a></p>
				<div class="hide_box"></div>
				<div class="shang_box">
					<a class="shang_close" href="javascript:void(0)" onClick="dashangToggle()" title="�ر�"><img src="/images/dashang/close.jpg" alt="ȡ��" /></a>
					<div class="shang_tit">
						<p>��л����֧�֣��һ����Ŭ����!</p>
					</div>
					<div class="shang_payimg">
						<img src="/images/dashang/alipayimg.jpg" />
					</div>
						<div class="pay_explain">ɨ����ͣ���˵���پͶ���</div>
					<div class="shang_payselect">
						<div class="pay_item checked" data-id="alipay">
							<span class="radiobox"></span>
							<span class="pay_logo"><img src="/images/dashang/alipay.jpg" /></span>
						</div>
						<div class="pay_item" data-id="weipay">
							<span class="radiobox"></span>
							<span class="pay_logo"><img src="/images/dashang/wechat.jpg" /></span>
						</div>
					</div>
					<div class="shang_info">
						<p>��<span id="shang_pay_txt">֧����</span>ɨһɨ�����ɽ���ɨ�����Ŷ</p>
					</div>
				</div>
				</div>
				<script type="text/javascript">
				$(function(){
					$(".pay_item").click(function(){
						$(this).addClass('checked').siblings('.pay_item').removeClass('checked');
						var dataid=$(this).attr('data-id');
						$(".shang_payimg img").attr("src","/images/dashang/"+dataid+"img.jpg");
						$("#shang_pay_txt").text(dataid=="alipay"?"֧����":"΢��");
					});
				});
				function dashangToggle(){
					$(".hide_box").fadeToggle();
					$(".shang_box").fadeToggle();
				}
				</script>