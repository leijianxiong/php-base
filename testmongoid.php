<?php

//mongoid 12个字节 表现出来的是24个数
function NewMongoId() {
    // 时间戳10位 占4个字节 8个16进制字符
    //机器码 占3个字节 6个十六进制字符
    //pid 占2个字节 4个16进制字符
    //时间戳微妙 3个字节

    $thex = time2hex();
    $hhex = hostname2hex();
    $phex = pid2hex();
    return "{$thex['shex']}$hhex$phex{$thex['ushex']}";
}

foreach (range(1, 20) as $i) {
    echo NewMongoId()."\n";
}

//字节对应16进制字符
$byteNum = 2;
$a = pow(2, $byteNum*8) - 1;
var_dump($a, dechex($a));

//当前秒数测试 4个字节 计数器测试 3个字节
function time2hex() {
    $ms = microtime();
    list($us, $time) = explode(" ", $ms);
    $shex = dechex($time);
    //微妙
    $us = substr($us, 2, 7);
    $ushex = dechex($us);
    return [
        'shex' => $shex,
        'ushex' => $ushex,
    ];
}

/*
//机器码测试 3个字节
 * 每个字符获取 ASCII 码, 加在一起
 * 前导补0 最大为 16777215
 * 通常一般也没有多少机器
 */
function hostname2hex($hostname = null) {
    $hostname = $hostname ?: gethostname();
    $sum = 0;
    for ($i = 0; $i < strlen($hostname); $i++) {
        $char = $hostname{$i};
        $n = ord($char);
        $sum += $n;
    }
    //echo $sum."\n";
    if (strlen($sum) < 7) {
        //echo pow(10, 7 - strlen($sum))."\n";
        $sum = $sum * pow(10, 7 - strlen($sum));
        //echo "sum: ".$sum."\n";
    }
    return dechex($sum);
}


//pid 测试 2个字节
function pid2hex() {
    $pid = getmypid();
    $max = pow(2, 2*8) - 1;

    if ($pid > $max) {
        $pid = $pid - $max;
    }

    $maxLength = strlen($max) - 1;
    if (strlen($pid) < $maxLength) {
        $pid = $pid * pow(10, $maxLength - strlen($pid));
    }

    return dechex($pid);
}

//echo pid2hex();


