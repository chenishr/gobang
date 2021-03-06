<?php 
/*************************************************************************
 * File Name:		test.php
 * Author:			chenishr
 * Mail: 			chenishr@gmail.com 
 * Created Time:	Mon Jul 17 13:44:37 2017
 ************************************************************************/
use Chenishr\Gobang;

require dirname(__FILE__)."/../src/Gobang.class.php";
//require dirname(__FILE__)."/../vendor/autoload.php";

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

$initData	= '000000000000000000000000000000000000000000000000000000000000000010000000000000000000000000000000002020000000000111200000000000002000000000000010000000000000000000000000000000000000000000000000000000000000000000000000000000000';
$gb	= new Gobang($initData);

$gb->echo_chess();

$step	= 10;
$turn	= 1;
while($step > 0){
	fwrite(STDOUT,"请 ".$turn." 输入坐标：\n");

	$data	= trim(fgets(STDIN));
	$data	= explode(',',$data);

	$ok	= $gb->one_step($turn,$data[0],$data[1]);

	if(100 != $ok){
		echo $gb->get_err($ok)."\n";
		continue;
	}

	$gb->echo_chess();
	echo $gb->to_string();

	$win	= $gb->is_win($data[0],$data[1]);
	if(0 != $win){
		echo $win . " 已经获胜！";
		exit;
	}

	if(1 == $turn)
		$turn	= 2;
	else
		$turn	= 1;

	$step	--;
}
