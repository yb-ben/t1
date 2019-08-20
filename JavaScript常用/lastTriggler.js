let S= (function(){
        let times = 0;
        return function () {
            times++;
            this.last = 0;
            this.timer = null;
            console.log(times);
        }
    })();

     S.prototype = {

        func1:function (func,timeout) {
            let now = new Date().getTime();
            if( Boolean(this.last) === false  ||  ( now - this.last) <= timeout ) {
                this.timer && clearTimeout(this.timer);
                this.timer = setTimeout(() => {func();}, 0);
            }else{
                func();
            }
        }
    };