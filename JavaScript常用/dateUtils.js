//获取N天前/后的零时时间戳
const getNdayTimestamp = function(days = 0) {
       let date = new Date();
       const oneDay = 86400;
       date.setMilliseconds(0);
       date.setSeconds(0);
       date.setMinutes(0);
       date.setHours(0);
       return date.getTime()/1000 - (days * oneDay);
}

//不显示今年本月的日期中的年月
const timeShowFormat = (date) =>{
    const now = new Date();
    const year = date.getFullYear();
    const month = date.getMonth();
    const day = date.getDate();
    const hour = date.getHours();
    const minutes = date.getMinutes();
    const seconds = date.getSeconds();
    let s = [hour,minutes].map(formatNumber).join(':');
    let thisYear = now.getFullYear();
    if(year !== thisYear){
      return  year+'-'+ ([month,day].map(formatNumber).join('-')) +' ' +s;
    }
    if( month !== now.getMonth() || day !== now){
          return  [month,day].map(formatNumber).join('-')+' '+s;
    }
    return s;
}

// php date format: " Y/m/d H:i:s "
const formatTime = date => {
  const year = date.getFullYear()
  const month = date.getMonth() + 1
  const day = date.getDate()
  const hour = date.getHours()
  const minute = date.getMinutes()
  const second = date.getSeconds()


  
  return [year, month, day].map(formatNumber).join('/') + ' ' + [hour, minute, second].map(formatNumber).join(':')
}

  const formatNumber = n => {
	n = n.toString()
	return n[1] ? n : '0' + n
}

module.exports ={
	getNdayTimestamp:getNdayTimestamp,
	timeShowFormat:timeShowFormat,
	 formatTime: formatTime,
}