<?php
session_start();
//��֤����
class ValidateCode {
	private $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';//�������
	private $code;//��֤��
	private $codelen = 4;//��֤�볤��
	private $width = 90;//���
	private $height = 30;//�߶�
	private $img;//ͼ����Դ���
	private $font;//ָ��������
	private $fontsize = 17;//ָ�������С
	private $fontcolor;//ָ��������ɫ
	//���췽����ʼ��
	public function __construct() {
		$this->font = dirname(__FILE__).'/css/font/Elephant.ttf';//ע������·��Ҫд�ԣ�������ʾ����ͼƬ
	}
	//���������
	private function createCode() {
		$_len = strlen($this->charset)-1;
		for ($i=0;$i<$this->codelen;$i++) {
			$this->code .= $this->charset[mt_rand(0,$_len)];
		}
	}
	//���ɱ���
	private function createBg() {
		$this->img = imagecreatetruecolor($this->width, $this->height);
		$color = imagecolorallocate($this->img, mt_rand(157,255), mt_rand(157,255), mt_rand(157,255));
		imagefilledrectangle($this->img,0,$this->height,$this->width,0,$color);
	}
	//��������
	private function createFont() {
		$_x = $this->width / $this->codelen;
		for ($i=0;$i<$this->codelen;$i++) {
		$this->fontcolor = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
		imagettftext($this->img,$this->fontsize,mt_rand(-30,30),$_x*$i+mt_rand(1,5),$this->height / 1.4,$this->fontcolor,$this->font,$this->code[$i]);
	}
	
}


//����������ѩ��
private function createLine() {
	//����
	for ($i=0;$i<6;$i++) {
		$color = imagecolorallocate($this->img,mt_rand(0,156),mt_rand(0,156),mt_rand(0,156));
		imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
	}
	//ѩ��
	for ($i=0;$i<100;$i++) {
		$color = imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
		imagestring($this->img,mt_rand(1,5),mt_rand(0,$this->width),mt_rand(0,$this->height),'*',$color);
	}
}

//���
private function outPut() {
		header('Content-type:image/jpeg');
		imagepng($this->img);
		imagedestroy($this->img);
}

//��������
public function doimg() {
		$this->createBg();
		$this->createCode();
		$this->createLine();
		$this->createFont();
		$this->outPut();
	}
	//��ȡ��֤��
	public function getCode() {
		return strtoupper($this->code);
	}
}

$_vc = new ValidateCode();  //ʵ����һ������
$_vc->doimg();  
$_SESSION['login_check_code'] = $_vc->getCode();//��֤�뱣�浽SESSION��

?>