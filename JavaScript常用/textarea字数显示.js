   /**
     * textarea 字数显示
     * @param  string elem id
     * @param  integer init  初始值 默认使用当前文本长度
     * @param  integer limit  最大长度  默认使用 maxlength属性
     */
     function showTextareaLength(elem, init = 0, limit = 140) {
        let e = $('#' + elem);
        limit = e.attr('maxlength') || limit;
        init = e.val().length || init;
        $('<p style="text-align:right;color:#999;"><span>' + init + '</span>/<span>' + limit + '</span></p>').insertAfter(e);
        e.on('input', function () {

            let v = e.val();
            // debugger
            let count = v.length;
            if (v.length > limit) {
                e.val(v.substring(0, limit));
                count = limit;
            }
            let n = $(e.next().children().get(0));
            n.text(count)
        })
    }