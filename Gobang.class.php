<?php 
/*************************************************************************
 * File Name:		Gobang.class.php
 * Author:			chenishr
 * Mail: 			chenishr@gmail.com 
 * Created Time:	Fri Jul 14 12:57:58 2017
 ************************************************************************/
namespace chenishr;

class Gobang{
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
				return false;
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
			return false;
		}

		if(!$this->is_valid_position($x,$y)){
			return false;
		}

		// 坐标位置是否为空
		if(0 != $this->chessBoard[$x][$y]){
			return false;
		}

		// 落子
		$this->chessBoard[$x][$y]	= $type;

		return true;
	}

	// 坐标是有
	protected function is_valid_position($x,$y){
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
		if(!$this->is_valid_position($x,$y)){
			return false;
		}

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

	public function get_chessboard(){
		return $this->chessBoard;
	}

	public function get_chess(){
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

	protected function two_num($n){
		if(10 > $n){
			return ' '.$n;
		}else{
			return $n;
		}
	}
}
