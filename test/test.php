<?php 
/*************************************************************************
 * File Name:		test.php
 * Author:			chenishr
 * Mail: 			chenishr@gmail.com 
 * Created Time:	Mon Jul 17 13:44:37 2017
 ************************************************************************/
use chenishr\Gobang;

require "../Gobang.class.php";

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

$gb->get_chess();

$step	= 10;
$turn	= 1;
while($step > 0){
	fwrite(STDOUT,"请 ".$turn." 输入坐标：\n");

	$data	= trim(fgets(STDIN));
	$data	= explode(',',$data);

	$gb->one_step($turn,$data[0],$data[1]);
	$gb->get_chess();

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
