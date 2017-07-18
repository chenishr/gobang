<?php 
/*************************************************************************
 * File Name:		Gobang.class.php
 * Author:			chenishr
 * Mail: 			chenishr@gmail.com 
 * Created Time:	Fri Jul 14 12:57:58 2017
 ************************************************************************/
namespace chenishr;

class Gobang{
	const err	= [
		100	=> '成功',
		101	=> '坐标错误或越界',
		102	=> '坐标已赋值',
		103	=> '初始化数据出错',
		104	=> '类别错误',
	];
	/*
	 * 五子棋棋盘
	 */
	protected	$chessBoard	= [];

	/*
	 * 棋盘的行数
	 */
	protected	$row	= 15;

	/*
	 * 棋盘的列数
	 */
	protected	$col	= 15;

	public function __construct($init = ''){
		if(is_array($init)){
			// 检查棋盘的尺寸是否正确
			if($this->row != count($init) || $this->col != count($init[0])){
				return 103;
			}
			$this->chessBoard	= $init;
		}else{
			// 根据字符串来初始化棋盘
			$index	= 0;
			for($i = 0; $i < $this->row; $i ++){
				for($j = 0; $j < $this->col; $j ++){
					$this->chessBoard[$i][$j]	= '' !== $init[$index] ? $init[$index] : '0';
					$index ++;
				}
			}
		}
	}

	/*
	 * 落子
	 */
	public function one_step($type,$x,$y){
		// 类型是否正确
		if(1 != $type && 2 != $type){
			return 104;
		}

		if(!$this->is_valid_position($x,$y)){
			return 101;
		}

		// 坐标位置是否为空
		if(0 != $this->chessBoard[$x][$y]){
			return 102;
		}

		// 落子
		$this->chessBoard[$x][$y]	= $type;

		return 100;
	}

	// 坐标是有效
	protected function is_valid_position($x,$y){
		if(!isset($x) || !isset($y)){
			return false;
		}

		if($x >= $this->row  ||  $y >= $this->col || 0 > $x  ||  0 > $y){
			return false;
		}else{
			return true;
		}
	}

	/*
	 * 判断是否胜出
	 */
	public function is_win($x,$y){
		// 最小可赢坐标
		$min_x	= $x - 4 >= 0 ? $x - 4 : 0;
		$min_y	= $y - 4 >= 0 ? $y - 4 : 0;

		// 最大可赢坐标
		$max_x	= $x + 4 < $this->row ? $x + 4 : $this->row - 1;
		$max_y	= $y + 4 < $this->col ? $y + 4 : $this->col - 1;

		/*
		 * 水平是否成五子
		 */
		for($i = $min_x; $i <= $max_x - 4; $i ++){
			// 
			if($this->chessBoard[$i][$y] != 0
				&& $this->chessBoard[$i][$y] == $this->chessBoard[$i + 1][$y]
				&& $this->chessBoard[$i + 1][$y] == $this->chessBoard[$i + 2][$y]
				&& $this->chessBoard[$i + 2][$y] == $this->chessBoard[$i + 3][$y]
				&& $this->chessBoard[$i + 3][$y] == $this->chessBoard[$i + 4][$y]){

				return $this->chessBoard[$i][$y];
			}
		}

		/*
		 * 垂直是否成五子
		 */
		for($i = $min_y; $i <= $max_y - 4; $i ++){
			// 
			if($this->chessBoard[$x][$i] != 0
				&& $this->chessBoard[$x][$i] == $this->chessBoard[$x][$i + 1]
				&& $this->chessBoard[$x][$i + 1] == $this->chessBoard[$x][$i + 2]
				&& $this->chessBoard[$x][$i + 2] == $this->chessBoard[$x][$i + 3]
				&& $this->chessBoard[$x][$i + 3] == $this->chessBoard[$x][$i + 4]){

				return $this->chessBoard[$x][$i];
			}
		}

		/*
		 * 斜线是否成五子
		 */
		for($i = 0; $i < 5; $i ++){
			$tmp_x	= $x - $i;
			$tmp_y	= $y - $i;

			// 
			if($this->chessBoard[$tmp_x][$tmp_y] != 0
				&& $this->chessBoard[$tmp_x][$tmp_y] == $this->chessBoard[$tmp_x + 1][$tmp_y + 1]
				&& $this->chessBoard[$tmp_x + 1][$tmp_y + 1] == $this->chessBoard[$tmp_x + 2][$tmp_y + 2]
				&& $this->chessBoard[$tmp_x + 2][$tmp_y + 2] == $this->chessBoard[$tmp_x + 3][$tmp_y + 3]
				&& $this->chessBoard[$tmp_x + 3][$tmp_y + 3] == $this->chessBoard[$tmp_x + 4][$tmp_y + 4]){

				return $this->chessBoard[$tmp_x][$tmp_y];
			}
		}

		/*
		 * 反斜线是否成五子
		 */
		for($i = 0; $i < 5; $i ++){
			$tmp_x	= $x + $i;
			$tmp_y	= $y - $i;

			// 
			if($this->chessBoard[$tmp_x][$tmp_y] != 0
				&& $this->chessBoard[$tmp_x][$tmp_y] == $this->chessBoard[$tmp_x - 1][$tmp_y + 1]
				&& $this->chessBoard[$tmp_x - 1][$tmp_y + 1] == $this->chessBoard[$tmp_x - 2][$tmp_y + 2]
				&& $this->chessBoard[$tmp_x - 2][$tmp_y + 2] == $this->chessBoard[$tmp_x - 3][$tmp_y + 3]
				&& $this->chessBoard[$tmp_x - 3][$tmp_y + 3] == $this->chessBoard[$tmp_x - 4][$tmp_y + 4]){

				return $this->chessBoard[$tmp_x][$tmp_y];
			}
		}

		return 0;
	}


	/*
	 * 将棋盘转换成字符串
	 */
	public function to_string(){
		$tmpStr	= '';
		for($i = 0; $i < $this->row; $i ++){
			for($j = 0; $j < $this->col; $j ++){
				$tmpStr	.= $this->chessBoard[$i][$j];
			}
		}

		return $tmpStr;
	}

	/*
	 * 获取棋盘对象
	 */
	public function get_chessboard(){
		return $this->chessBoard;
	}

	/*
	 * 输出棋盘到终端
	 */
	public function echo_chess(){
		// 棋盘横坐标
		echo '  ';
		for($i = 0; $i < $this->row; $i ++){
			echo "\033[0;33m".$this->two_num($i).' ';
		}
		echo "\n";

		for($i = 0; $i < $this->row; $i ++){
			echo "\033[0;33m".$this->two_num($i).' ';
			for($j = 0; $j < $this->col; $j ++){
				if(1 == $this->chessBoard[$i][$j]){
					echo "\033[0;34m".$this->chessBoard[$i][$j] .'  ';
				}elseif(2 == $this->chessBoard[$i][$j]){
					echo "\033[0;31m".$this->chessBoard[$i][$j] .'  ';
				}else{
					echo  "\033[0m".$this->chessBoard[$i][$j] .'  ';
				}
			}
			echo "\n";
		}
	}

	public function get_err($err){
		return self::err[$err];
	}

	// 转换成两个数字
	protected function two_num($n){
		if(10 > $n){
			return ' '.$n;
		}else{
			return $n;
		}
	}
}
