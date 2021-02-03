<?php
/*��֪���⣺1.��ͼƬ���Ź����У�ʹ��imagecreatetruecolor����������������ʹ��͸�������㷨����PNG��ʽ��ͼƬ�޷�͸������imagecreate���������������Խ��������⣬�������ų�����ͼƬɫ��̫����
 *
 *
 *typeֵ��
 * ��1��������ʹ��ͼƬ���Ź��ܣ���ʱ��$value1�������ź�ͼƬ�Ŀ�ȣ�$value2�������ź�ͼƬ�ĸ߶�
 * ��2��:����ʹ��ͼƬ�ü����ܣ���ʱ��$value1����ü���ʼ������꣬������ԭ�㿪ʼ���ǡ�0,0��ǰ����x�������y�ᣬ�м���,�ָ���$value2����ü��Ŀ�Ⱥ͸߶ȣ�ͬ��Ҳ�ǡ�20��20������ʽʹ��
 * ��3��:����ʹ�ü�ͼƬˮӡ���ܣ���ʱ��$value1����ˮӡͼƬ���ļ�����$value2����ˮӡ��ͼƬ�е�λ�ã���10ֵ������ѡ,1�������ϣ�2�������У�3�������ң�4��������5�������У�6�������ң�7����������8�������У�9�������ң�0�������λ��
 
 
 	$image=new image("1.jpg", 1, "300", "400", "11.jpg");   //ʹ��ͼƬ���Ź���    ԭͼ��1���ţ������ߣ���ͼλ��  �����У���߻������һ�������ȱ����ţ�
	$image=new image("1.jpg", 2, "0,0", "200,200", "12.jpg"); //ʹ��ͼƬ�ü�����   ԭͼ��2�ü�����ʼ����XY�����Ͻǿ�ʼ������СXY����ͼλ��
	$image=new image("1.jpg", 3, "12.jpg", "9", "13.jpg");   //ʹ�ü�ͼƬˮӡ���� ԭͼ��3ˮӡ��ˮӡͼƬ��ˮӡ��Сȡ����ͼ��С����λ��9����0�������ͼλ��
	$image->outimage();
	
	
 *
 */

class image{
	private $types;	//ʹ�õĹ��ܱ�ţ�1ΪͼƬ���Ź���  2ΪͼƬ�ü�����   3,ΪͼƬ��ͼƬˮӡ����
	private $imgtype;//ͼƬ�ĸ�ʽ
	private $image;	//ͼƬ��Դ
	private $width;//ͼƬ���
	private $height;//ͼƬ�߶�
	private $value1;//��������typeֵ�Ĳ�ͬ��$value1�ֱ����ͬ��ֵ
	private $value2;//��������typeֵ�Ĳ�ͬ��$value2�ֱ����ͬ��ֵ
	private $endaddress;//�����ĵ�ַ+�ļ���
	

	function __construct($imageaddress, $types, $value1="", $value2="", $endaddress){
		$this->types=$types;
		$this->image=$this->imagesources($imageaddress);
		$this->width=$this->imagesizex();
		$this->height=$this->imagesizey();
		$this->value1=$value1;
		$this->value2=$value2;
		$this->endaddress=$endaddress;
	}
	

	function outimage(){	//���ݴ���typeֵ�Ĳ�ͬ�������ͬ�Ĺ���
		switch($this->types){
			case 1:
				$this->scaling();
				break;
			case 2:
				$this->clipping();
				break;
			case 3:
				$this->imagewater();
				break;
			default:
				return false;

		}
	}

	private function imagewater(){	//��ͼƬˮӡ����
		//�ú�����ȡˮӡ�ļ��ĳ��Ϳ�
		$imagearrs=$this->getimagearr($this->value1);
		//���ú��������ˮӡ���ص�λ��
		$positionarr=$this->position($this->value2, $imagearrs[0], $imagearrs[1]);
		//��ˮӡ
		imagecopy($this->image, $this->imagesources($this->value1), $positionarr[0], $positionarr[1], 0, 0, $imagearrs[0], $imagearrs[1]);
		//���������������
		$this->output($this->image);
	}

	private function clipping(){	//ͼƬ�ü�����
		//����������ֵ�ֱ𸳸�����
		list($src_x, $src_y)=explode(",", $this->value1);
		list($dst_w, $dst_h)=explode(",", $this->value2);
		if($this->width < $src_x+$dst_w || $this->height < $src_y+$dst_h){	//����жϾ������Ʋ��ܽ�ȡ��ͼƬ����ȥ
			return false;
		}		
		//�����µĻ�����Դ
		$newimg=imagecreatetruecolor($dst_w, $dst_h);
		//���вü�
		imagecopyresampled($newimg, $this->image, 0, 0, $src_x, $src_y, $dst_w, $dst_h, $dst_w, $dst_h);
		//���������������
		$this->output($newimg);			
	}

	private function scaling(){	//ͼƬ���Ź���
		//��ȡ�ȱ����ŵĿ�͸�
		$this-> proimagesize();
		//���ݲ�����������,����������������洦�����ļ�
		$this->output($this->imagescaling());
	}

	private function imagesources($imgad){	//��ȡͼƬ���Ͳ���ͼ����Դ
		$imagearray=$this->getimagearr($imgad);
		switch($imagearray[2]){
			case 1://gif
				$this->imgtype=1;
				$img=imagecreatefromgif($imgad);
				break;
			case 2://jpeg
				$this->imgtype=2;
				$img=imagecreatefromjpeg($imgad);
				break;
			case 3://png
				$this->imgtype=3;
				$img=imagecreatefrompng($imgad);
				break;
			default:
				return false;
		}
		return $img;
	}

	private function imagesizex(){	//���ͼƬ���
		return imagesx($this->image);
	}

	private function imagesizey(){	//��ȡͼƬ�߶�
		return imagesy($this->image);
	}

	private function proimagesize(){	//����ȱ����ŵ�ͼƬ�Ŀ�͸�
		if($this->value1 && ($this->width < $this->height)) {	//�ȱ������㷨
			$this->value1=round(($this->value2/ $this->height)*$this->width);
		}else{
			$this->value2=round(($this->value1/ $this->width) * $this->height);
		}
	}

	private function imagescaling(){//ͼ�����Ź��ܣ����ش�����ͼ����Դ
		$newimg=imagecreatetruecolor($this->value1, $this->value2);
		
		$tran=imagecolortransparent($this->image);//����͸���㷨
		if($tran >= 0 && $tran < imagecolorstotal($this->image)){
			$tranarr=imagecolorsforindex($this->image, $tran);
			$newcolor=imagecolorallocate($newimg, $tranarr['red'], $tranarr['green'], $tranarr['blue']);
			imagefill($newimg, 0, 0, $newcolor);
			imagecolortransparent($newimg, $newcolor);
		}
   
		imagecopyresampled($newimg, $this->image, 0, 0, 0, 0, $this->value1, $this->value2, $this->width, $this->height);
		return $newimg;
	}

	private function output($image){//���ͼ��
		switch($this->imgtype){
			case 1:
				imagegif($image, $this->endaddress,100);
				break;
			case 2:
				imagejpeg($image, $this->endaddress,100);
				break;
			case 3:
				imagepng($image, $this->endaddress,100);
				break;
			default:
				return false;
		}
	}

	private function getimagearr($imagesou){//����ͼ���������鷽��
		return getimagesize($imagesou);
	}

	private function position($num, $width, $height){//���ݴ�������ַ���һ��λ�õ�����,$width��$height�ֱ�������ͼ��Ŀ�͸�
		switch($num){
			case 1:
				$positionarr[0]=0;
				$positionarr[1]=0;
				break;
			case 2:
				$positionarr[0]=($this->width-$width)/2;
				$positionarr[1]=0;
				break;
			case 3:
				$positionarr[0]=$this->width-$width;
				$positionarr[1]=0;
				break;
			case 4:
				$positionarr[0]=0;
				$positionarr[1]=($this->height-$height)/2;
				break;
			case 5:
				$positionarr[0]=($this->width-$width)/2;
				$positionarr[1]=($this->height-$height)/2;
				break;
			case 6:
				$positionarr[0]=$this->width-$width;
				$positionarr[1]=($this->height-$height)/2;
				break;
			case 7:
				$positionarr[0]=0;
				$positionarr[1]=$this->height-$height;
				break;
			case 8:
				$positionarr[0]=($this->width-$width)/2;
				$positionarr[1]=$this->height-$height;
				break;
			case 9:
				$positionarr[0]=$this->width-$width;
				$positionarr[1]=$this->height-$height;
				break;
			case 0:
				$positionarr[0]=rand(0, $this->width-$width);
				$positionarr[1]=rand(0, $this->height-$height);
				break;
		}
		return $positionarr;
	}

	function __destruct(){
		imagedestroy($this->image);
	}
	

}

?>