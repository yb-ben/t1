//设置单个url参数
const setURLArg = function setURLArg(wl, p, v) {
    let regExp= new RegExp(  p + '=[^&]*','gi');
        if (wl.match(regExp)) {
            wl = wl.replace(regExp, p + '=' + v)
        } else {
            if (wl.indexOf('?') < 0) {
                wl += '?';
            }
            wl = wl + '&' + p + '=' + v;
        }
        return wl;
    }
	
module.exports = {
	setURLArg:setURLArg
}