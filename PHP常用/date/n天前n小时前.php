<?php


 function time_tran($the_time)
    {
        static $now_time;
        if(empty($now_time)) {
            $now_time = time();
        }

        $show_time = $the_time;
        $dur = $now_time - $show_time;
        if ($dur < 0) {
            return $the_time;
        } else {
            if ($dur < 60) {
                return $dur . '��ǰ';
            } else {
                if ($dur < 3600) {
                    return floor($dur / 60) . '����ǰ';
                } else {
                    if ($dur < 86400) {
                        return floor($dur / 3600) . 'Сʱǰ';
                    } else {
                        if ($dur < 259200) { // 3����
                            return floor($dur / 86400) . '��ǰ';
                        } else {
                            return $the_time;
                        }
                    }
                }
            }
        }
    }