<?php



 //获取本月起始日、最后一日、今日
date('Y-m-01');
date('Y-m-t');
date('Y-m-d');

//获取上个月的开始日
echo date('Y-m-01',strtotime('-1 month')),PHP_EOL;

date('t');//本月天数
date('n');//第几月
date('w');//本周周几  0-6
date('N');//本周第几日 1-7

$season = ceil(date('n') / 3);// 获取本季度
// 获取第一季度开始和结束日
echo DateTime::createFromFormat('m', '01')->format('Y-m-01'),PHP_EOL;
echo DateTime::createFromFormat('m', '03')->format('Y-m-t'),PHP_EOL;

// 获取第本季度开始和结束日
echo DateTime::createFromFormat('m', ($season-1)*3)->format('Y-m-01'),PHP_EOL;
echo DateTime::createFromFormat('m', $season*3)->format('Y-m-t'),PHP_EOL;

// 获取上一年开始和结束
echo date('Y-01-01', strtotime('-1 year')),PHP_EOL;
echo date('Y-12-31', strtotime('-1 year')),PHP_EOL;
echo (new DateTime)->modify('last year')->format('Y-01-01'),PHP_EOL;
echo (new DateTime)->modify('last year')->format('Y-12-31'),PHP_EOL;


//两个日期相差天数
echo (new DateTime('2019-06-01'))->diff((new DateTime('2019-06-21')))->days,PHP_EOL;


//获取两个日期之间的工作日
function workDays_v1(string $start, string $end):int
{
    $date_start = new DateTime($start);
    $date_end = new DateTIme($end);
    $diff = $date_start->diff($date_end);
	if($diff->invert === 1 )
		throw new \Exception("开始日期小于结束日期");
	$diff_days = $diff->days; //开始和结束的相差天数
    $workDays = 0; //工作日
    $w = $date_start->format('w') ;//开始日是星期几
    for ($i = 0;$i<$diff;$i++){
        if ( $w <  6 && $w) {
            $workDays++;
        }
        $w = (++$w) % 7;
    }
    return $workDays;
}

//前补后减法，效率更高
function workDays_v2(string $start, string $end):int
{
    $date_start = new DateTime($start);
    $date_end = new DateTIme($end);
    $diff = $date_start->diff($date_end);
    if($diff->invert === 1 )
        throw new \Exception("开始日期小于结束日期");
    $diff_days = $diff->days; //开始和结束的相差天数
    $w_start = $date_start->format('w') ;//开始日是星期几
    $w_end = $date_end->format('w' );//结束日是星期几
    $pad_days = $w_start%7 -1;
    $slice_days =  $w_end -1;
    return ($diff_days+$pad_days-$slice_days)/7 * 5 -$pad_days + $slice_days;
}


//获取一年中每个星期的起始和结束
function weekDays(string $year):Array 
{
    $ret = [];$count = 1;
    $current_day = DateTime::createFromFormat('Ymd',"{$year}0101");
    $last_day = DateTime::createFromFormat('Ymd', "{$year}1231");
    $ret[$count][0] = $current_day->modify('this Monday')->format('Y-m-d');//注意，第一日不是周一，this Monday 从下周一开始算
    $ret[$count][1] = $current_day->modify('this Sunday')->format('Y-m-d');
    while($current_day->getTimestamp() < $last_day->getTimestamp()){
        $count++;
        $ret[$count][0] = $current_day->modify('next Monday')->format('Y-m-d');
        $ret[$count][1] = $current_day->modify('this Sunday')->format('Y-m-d');
    }
    return $ret;
}
