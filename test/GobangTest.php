<?php 
/*************************************************************************
 * File Name:		GobangTest.php
 * Author:			chenishr
 * Mail: 			chenishr@gmail.com 
 * Created Time:	Fri Jul 14 13:45:07 2017
 ************************************************************************/
use Chenishr\Gobang;
use PHPUnit\Framework\TestCase;

require dirname(__FILE__)."/../src/Gobang.class.php";

class GobangTest extends TestCase{
	public function testInit(){
		$initData	= [
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,2,0,2,0,0,0,0],
			[0,0,0,0,0,0,1,1,1,2,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,2,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,1,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
		];

		$gb	= new Gobang($initData);

		//echo "\n";
		//$gb->echo_chess();
		$chessBoard	= $gb->get_chessboard();

		$this->assertEquals(15, count($chessBoard));
	}

	public function testStep(){
		$gb	= new Gobang();

		$turn	= 1;
		$x		= 7;
		$y		= 7;
		$gb->one_step($turn,$x,$y);
		//echo "\n";
		//$gb->echo_chess();
		$chessBoard	= $gb->get_chessboard();
		$this->assertEquals($turn,$chessBoard[$x][$y]);

		$turn	= 2;
		$x		= 8;
		$y		= 8;
		$gb->one_step($turn,$x,$y);
		//echo "\n";
		//$gb->echo_chess();
		$chessBoard	= $gb->get_chessboard();
		$this->assertEquals($turn,$chessBoard[$x][$y]);
	}

	public function testIsWin(){
		$initData	= [
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,1,1,1,1,0,0,0,0,0,0,0],
			[0,0,0,0,1,1,1,1,0,0,0,0,0,0,0],
			[0,0,0,0,1,1,1,1,0,0,0,0,0,0,0],
			[0,0,0,0,1,1,1,1,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,2,2,2,2,0,0,0],
			[0,0,0,0,0,0,0,0,2,2,2,2,0,0,0],
			[0,0,0,0,0,0,0,0,2,2,2,2,0,0,0],
			[0,0,0,0,0,0,0,0,2,2,2,2,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0],
			[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
		];


		// 水平成五子
		$gb	= new Gobang($initData);
		$turn	= 1;
		$x		= 4;
		$y		= 3;
		$gb->one_step($turn,$x,$y);
		//echo "\n";
		//$gb->echo_chess();
		$win	= $gb->is_win($x,$y);
		$this->assertEquals($turn,$win);
		unset($gb);

		// 垂直成五子
		$gb	= new Gobang($initData);
		$turn	= 2;
		$x		= 8;
		$y		= 9;
		$gb->one_step($turn,$x,$y);
		//echo "\n";
		//$gb->echo_chess();
		$win	= $gb->is_win($x,$y);
		$this->assertEquals($turn,$win);
		unset($gb);

		// 斜线成五子
		$gb	= new Gobang($initData);
		$turn	= 1;
		$x		= 2;
		$y		= 3;
		$gb->one_step($turn,$x,$y);
		//echo "\n";
		//$gb->echo_chess();
		$win	= $gb->is_win($x,$y);
		$this->assertEquals($turn,$win);
		unset($gb);

		// 垂直成五子
		$gb	= new Gobang($initData);
		$turn	= 2;
		$x		= 8;
		$y		= 12;
		$gb->one_step($turn,$x,$y);
		//echo "\n";
		//$gb->echo_chess();
		$win	= $gb->is_win($x,$y);
		$this->assertEquals($turn,$win);
		unset($gb);
	}
}
