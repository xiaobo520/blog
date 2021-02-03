/*��Ҫ��ע��

imgOrigArr �� imgRanfArr����������ֱ�����ȷ˳�����к��������е���Ƭ��Ϣ
����ṹ��arr[��Ƭ�ڵ��±�] = ��Ƭ��ʾλ��

 */

/**
 * [puzzleGame ��puzzleGame�������������]
 * @param  {[json��ʽ]} param [ͼƬ ·��+����]
 * @return       [��]
 */
var puzzleGame = function(param){
/************* �������� ******************/
	this.img = param.img || '';//��������ͼƬ

/************* �ڵ� ******************/
	this.btnStart = $('#start');//��ʼ��Ϸ��ť
	this.btnLevel = $('#level');//�Ѷ�ѡ��ť
	this.imgArea = $('#imgArea');//ͼƬ��ʾ����

	this.imgCells = '';//���ڼ�¼��Ƭ�ڵ�ı���

/************* ���� ******************/	
	this.imgOrigArr = [];//ͼƬ��ֺ󣬴洢��ȷ���������
	this.imgRandArr = [];//ͼƬ����˳��󣬴洢��ǰ���������

	this.levelArr = [[3,3],[4,4],[6,6]];//�洢�Ѷȵȼ�������
	this.levelNow = 0;//��ʾ��ǰ�Ѷȵȼ��ı��������Ѷ�������ʹ��

	//ͼƬ����Ŀ��
	this.imgWidth = parseInt(this.imgArea.css('width'));
	this.imgHeight = parseInt(this.imgArea.css('height'));
	//���Ϊ��Ƭ��ÿһ����Ƭ�Ŀ��
	this.cellWidth = this.imgWidth/this.levelArr[this.levelNow][1];
	this.cellHeight = this.imgHeight/this.levelArr[this.levelNow][0];

	this.hasStart = 0;//��¼���Ƿ�ʼ�ı�����Ĭ��fasle��δ��ʼ
	this.moveTime = 400;//��¼animate�������˶�ʱ�䣬Ĭ��400����
	
	//���ó�ʼ�����������ͼƬ,�󶨰�ť����
	this.init();
}


/**
 * [prototype ��puzzleGame��������ӷ�������json��ʽ��ʾ]
 * @type {Object}
 */
puzzleGame.prototype = {
	/**
	 * [init ��ʼ����Ч����]
	 * @return [��]
	 */
	init:function(){
		this.imgSplit();
		this.levelSelect();
		this.gameState();
	},

	/**
	 * [imgSplit ��ͼƬ���Ϊ��Ƭ]
	 * @param  obj    [ͼƬ,·��+����]
	 * @param  cellW  [��Ƭ���]
	 * @param  cellH  [��Ƭ�߶�]
	 * @return        [��¼��ȷ���������]
	 */
	imgSplit:function(){
		this.imgOrigArr = [];//�����ȷ���������

		//�������ͼƬ�������Ƭ���룬����ÿһ�β��ͼƬ����֮ǰ��ֵ��ۻ�
		//�����һ�β��3x3,������9��div����û����գ��ڶ��β��4x4����ʱ����ǰ9��div֮���ٲ���14��div����9+16��div
		this.imgArea.html("");

		var cell = '';//��¼����ͼƬ��Ƭ�ı���
		for(var i=0;i<this.levelArr[this.levelNow][0];i++){
			for(var j=0;j<this.levelArr[this.levelNow][1];j++){
				//����Ƭ����div���±�������飬��������У���Ƿ��������
				this.imgOrigArr.push(i*this.levelArr[this.levelNow][1]+j);

				cell = document.createElement("div");
				cell.className = "imgCell";
				$(cell).css({
					'width':(this.cellWidth - 2) + 'px',
					'height':(this.cellHeight - 2) + 'px',
					'left':j * this.cellWidth + 'px',
					'top':i * this.cellHeight + 'px',
					"background":"url('"+this.img+"')",
					'backgroundPosition':(-j)*this.cellWidth + 'px ' + (-i)*this.cellHeight + 'px'
				});
				this.imgArea.append(cell);
			}
		}
		this.imgCells = $('#imgArea div.imgCell');//��Ƭ�ڵ�
	},

	levelSelect:function(){
		var len = this.levelArr.length;
		var self = this;
		this.btnLevel.bind('mousedown',function(){
			$(this).addClass('mouseOn');
		}).bind('mouseup',function(){
			$(this).removeClass('mouseOn');
		}).bind('click',function(){
			//�ж��Ƿ�����Ϸ��
			if(self.hasStart){
				//if(!confirm('���Ѿ�����Ϸ�У�ȷ��Ҫ�ı���Ϸ�Ѷ�ô��')){
				//	return false;
				//}else{
					self.hasStart = false;
					self.btnStart.text('��ʼ');
				//}
			}
			//���ݸı�
			self.levelNow ++;
			if(self.levelNow >= len){
				self.levelNow = 0;
			}
			//��ʾ���Ѷȸı�
			$(this).text(self.levelArr[self.levelNow][0] + 'x' + self.levelArr[self.levelNow][1]);
			//ͼƬ���²��(�����¼�����)
			self.cellWidth = self.imgWidth/self.levelArr[self.levelNow][1];
			self.cellHeight = self.imgHeight/self.levelArr[self.levelNow][0];
			self.imgSplit();
		});
	},

	/**
	 * [gameStart ��ʼ/�ظ� ��Ϸ�ĺ���]
	 * @return [��]
	 */
	gameState:function(){
		var self = this;

		this.btnStart.bind('mousedown',function(){
			$(this).addClass('mouseOn');
		}).bind('mouseup',function(){
			$(this).removeClass('mouseOn');
		}).bind('click',function(){
			if(self.hasStart == 0){//������Ϸ��
				//��ʼ��Ϸ�󲿷�ֵ����ʽ����
				$(this).text('��ԭ');
				self.hasStart = 1;

				//����ͼƬ
				self.randomArr();
				self.cellOrder(self.imgRandArr);

				//ͼƬ�¼�
				self.imgCells.css({
					'cursor':'pointer'
				}).bind('mouseover',function(){
					$(this).addClass('hover');
				}).bind('mouseout',function(){
					$(this).removeClass('hover');
				}).bind('mousedown',function(e){
					/*�˴���ͼƬ�ƶ�*/
					$(this).css('cursor','move');

					//��ѡͼƬ��Ƭ���±��Լ������Ը���Ƭ��λ��
					var cellIndex_1 = $(this).index();
					var cell_mouse_x = e.pageX - self.imgCells.eq(cellIndex_1).offset().left;
					var cell_mouse_y = e.pageY - self.imgCells.eq(cellIndex_1).offset().top;

					$(document).bind('mousemove',function(e2){
						self.imgCells.eq(cellIndex_1).css({
							'z-index':'40',
							'left':(e2.pageX - cell_mouse_x - self.imgArea.offset().left) + 'px',
							'top':(e2.pageY - cell_mouse_y - self.imgArea.offset().top) + 'px'
						});
					}).bind('mouseup',function(e3){
						//����������Ƭ�±�
						var cellIndex_2 = self.cellChangeIndex((e3.pageX-self.imgArea.offset().left),(e3.pageY-self.imgArea.offset().top),cellIndex_1);
						
						//��Ƭ����
						if(cellIndex_1 == cellIndex_2){
							self.cellReturn(cellIndex_1);
						}else{
							self.cellExchange(cellIndex_1,cellIndex_2);
						}

						//�Ƴ���
						$(document).unbind('mousemove').unbind('mouseup');
					});
				}).bind('mouseup',function(){
					$(this).css('cursor','pointer');
				});
			}else if(self.hasStart == 1){
				//if(!confirm('�Ѿ�����Ϸ�У�ȷ��Ҫ�ظ�ԭͼ��')){
				//	return false;
				//}
				//��ʽ�ָ�
				$(this).text('��ʼ');
				self.hasStart = 0;

				//��ԭͼƬ
				self.cellOrder(self.imgOrigArr);

				//ȡ���¼���
				self.imgCells.css('cursor','default').unbind('mouseover').unbind('mouseout').unbind('mousedown');				
			}
		});		
	},

	/**
	 * [randomArr ���ɲ��ظ����������ĺ���]
	 * @return [��]
	 */
	randomArr:function(){
		//�������
		this.imgRandArr = [];

		var order;//��¼���������¼ͼƬ������ʲôλ��
		for(var i=0,len=this.imgOrigArr.length;i<len;i++){
			order = Math.floor(Math.random()*len);
			if(this.imgRandArr.length > 0){
				while(jQuery.inArray(order,this.imgRandArr) > -1){
					order = Math.floor(Math.random()*len);
				}
			}
			this.imgRandArr.push(order);
		}
		return;
	},

	/**
	 * [cellOrder ���������ͼƬ����ĺ���]
	 * @param  arr [������������飬���������������]
	 * @return     [��]
	 */
	cellOrder:function(arr){
		for(var i=0,len=arr.length;i<len;i++){
			this.imgCells.eq(i).animate({
				'left': arr[i]%this.levelArr[this.levelNow][1]*this.cellWidth + 'px',
				'top': Math.floor(arr[i]/this.levelArr[this.levelNow][0])*this.cellHeight + 'px'
			},this.moveTime);
		}
	},

	/**
	 * [cellChangeIndex ͨ�����꣬���㱻��������Ƭ�±�]
	 * @param  x    [���x����]
	 * @param  y    [���y����]
	 * @param  orig [���϶�����Ƭ�±꣬��ֹ��������Ƭ��������ʱ��ԭ��Ƭ����]
	 * @return      [�������ڵ��ڽڵ��б��е��±�]
	 */
	cellChangeIndex:function(x,y,orig){
		//����϶���Ƭ������ͼƬ��
		if(x<0 || x>this.imgWidth || y<0 || y>this.imgHeight){
			return orig;
		}
		//����϶���Ƭ�ڴ�ͼ��Χ���ƶ�
		var row = Math.floor(y/this.cellHeight),col = Math.floor(x/this.cellWidth),location=row*this.levelArr[this.levelNow][1]+col;
		var i=0,len=this.imgRandArr.length;
		while((i<len) && (this.imgRandArr[i] != location)){
			i++;
		}
		return i;
	},

	/**
	 * [cellExchange ����ͼƬ��Ƭ���н���]
	 * @param  from [���϶�����Ƭ]
	 * @param  to   [����������Ƭ]
	 * @return      [����������ɹ�Ϊtrue,ʧ��Ϊfalse]
	 */
	cellExchange:function(from,to){
		var self = this;
		//���϶�ͼƬ��������ͼƬ�����С���
		var rowFrom = Math.floor(this.imgRandArr[from]/this.levelArr[this.levelNow][1]);
		var colFrom = this.imgRandArr[from]%this.levelArr[this.levelNow][1];
		var rowTo = Math.floor(this.imgRandArr[to]/this.levelArr[this.levelNow][1]);
		var colTo = this.imgRandArr[to]%this.levelArr[this.levelNow][1];

		var temp = this.imgRandArr[from];//���϶�ͼƬ�±꣬��ʱ�洢

		//���϶�ͼƬ�任λ��
		this.imgCells.eq(from).animate({
			'top':rowTo*this.cellHeight + 'px',
			'left':colTo*this.cellWidth + 'px'
		},this.moveTime,function(){
			$(this).css('z-index','10');
		});
		//����ͼƬ�任λ��
		this.imgCells.eq(to).css('z-index','30').animate({
			'top':rowFrom*this.cellHeight + 'px',
			'left':colFrom*this.cellWidth + 'px'
		},this.moveTime,function(){
			$(this).css('z-index','10');

			//����ͼƬ�����洢����
			self.imgRandArr[from] = self.imgRandArr[to];
			self.imgRandArr[to] = temp;

			//�ж��Ƿ����ȫ���ƶ������Խ�����Ϸ
			if(self.checkPass(self.imgOrigArr,self.imgRandArr)){
				self.success();
			}
		});
	},

	/**
	 * [cellReturn ���϶�ͼƬ����ԭλ�õĺ���]
	 * @param  index [���϶�ͼƬ���±�]
	 * @return       [��]
	 */
	cellReturn:function(index){
		var row = Math.floor(this.imgRandArr[index]/this.levelArr[this.levelNow][1]);
		var col = this.imgRandArr[index]%this.levelArr[this.levelNow][1];

		this.imgCells.eq(index).animate({
			'top':row*this.cellHeight + 'px',
			'left':col*this.cellWidth + 'px'
		},this.moveTime,function(){
			$(this).css('z-index','10');
		});
	},

	/**
	 * [checkPass �ж���Ϸ�Ƿ�ɹ��ĺ���]
	 * @param  rightArr  [��ȷ���������]
	 * @param  puzzleArr [ƴͼ�ƶ�������]
	 * @return           [�Ƿ������Ϸ�ı�ǣ��Ƿ���true���񷵻�false]
	 */
	checkPass:function(rightArr,puzzleArr){
		if(rightArr.toString() == puzzleArr.toString()){
			return true;
		}
		return false;
	},

	/**
	 * [success �ɹ������Ϸ��Ĵ�����]
	 * @return [description]
	 */
	success:function(){
		//ȡ����ʽ���¼���
		for(var i=0,len=this.imgOrigArr.length;i<len;i++){
			if(this.imgCells.eq(i).has('mouseOn')){
				this.imgCells.eq(i).removeClass('mouseOn');
			}
		}
		this.imgCells.unbind('mousedown').unbind('mouseover').unbind('mouseout');
		this.btnStart.text('��ʼ');
		this.hasStart = 0;
		//alert('��ϲ�����ɹ���ɱ�����Ϸ��');
		src_i=$("#src_hide").val();//��ȡ��ʼֵ
		var ajaxform_pintu=$.post("/givepitu.php",{src_i:src_i},function(result){	
			alert(result);
		})
	}
}

/* ����ͼƬ�����д��� */
function pintu(){
	$("#imgArea").hide();//����Ч��
	src=$("#src_hide").val();//��ȡ��ʼֵ
	
	if (src>6){//һ���ж�����ͼ
		src=1;//��ʼͼp_1.jpg
	}
	src_str='/images/pintu/p_'+src+'.jpg';
	var pg = new puzzleGame({'img':src_str});
	src++;
	$("#src_hide").val(src);
	$("#imgArea").fadeIn(500)
};

