
//只能输入两个小数
function clearNoNum(obj){
    obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符
    obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
    obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数
    if(obj.value.indexOf(".")< 0 && obj.value !=""){//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额
        obj.value= parseFloat(obj.value);
    }
}

//只能输入两个小数并且可以是负数
function clearNoNegative(obj){
    obj.value = obj.value.replace(/[^\d.-]/g,"");  //清除“数字”和“.”以外的字符
    obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的
    obj.value = obj.value.replace(/\-{2,}/g,"-"); //只保留第一个. 清除多余的
    obj.value = obj.value.replace(/\-\./g,"-"); //只保留第一个. 清除多余的
    obj.value = obj.value.replace(/^\./g, "");//第一位不能为.
    obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
    obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数
    if(obj.value != '-' && obj.value.indexOf(".")< 0 && obj.value !=""){//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额
        obj.value= parseFloat(obj.value);
    }
}

//只能整数
function isNumber(obj){
    obj.value = obj.value.replace(/[^\d]/g,"");  //清除“数字”和“.”以外的字符
}


//还原千分位
function rmoney(s) {
    return parseFloat(s.replace(/[^\d\.-]/g, ""));
}

//格式化金额千分位
function fmoney(s, n) {

    n = n > 0 && n <= 20 ? n : 2;
    s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
    var l = s.split(".")[0].split("").reverse(),
      r = s.split(".")[1];
    t = "";
    for(i = 0; i < l.length; i ++ )
    {
        t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
    }
    return t.split("").reverse().join("") + "." + r;
}

//只能数字、大小写字母、下划线、中线和点
function isCharacter(obj){
    obj.value = obj.value.replace(/[^a-z|A-Z|0-9|\-|_|\.]/g,"");
}

//判断是否为数字
function isDigital(val){
    var regPos = /^\d+(\.\d+)?$/; //非负浮点数
    var regNeg = /^(-(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*)))$/; //负浮点数
    if(regPos.test(val) || regNeg.test(val)){
        return true;
    }else{
        return false;
    }
}

$(function(){
    var locked = true;
    var config = initialAjAx;

    /**
    *  表单ajax提交
    */
    $('.form-submit').click(function() {

        try {
            if (typeof(eval('formValidate')) == "function") {
                error = formValidate();
                if (error != '') {
                    error.forEach(function(e) {
                        $('.'+ e.class).after("<div class='text-danger col-sm-3' style='line-height: 20px;'>" + e.error + "</div>");
                    });
                    return false;
                }
            }
        } catch(e) {}

        if (! locked) {
            return false;
        }

        locked = false;
        var _this = $(this);
        var data  = $(this).parents(".form-horizontal").serialize();

        _this.attr('disabled',true);
        $('div.text-danger').text('');
        $.ajax({
            url: config.url,
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            success:function(res) {
                if(res.code == 1010001) {
                    var error = res.data;
                    for ( var i in error ) {
                        $('.'+i).after("<div class='text-danger col-sm-3'>" + error[i][0] + "</div>");
                    }
                    _this.attr('disabled',false);
                    locked = true;
                } else if(res.code != 0){
                    swal(res.data, '', 'error');
                    _this.attr('disabled',false);
                    locked = true;
                } else {
                    swal(res.data, '', 'success');
                    window.location.href = config.backUrl;
                }
            },
            error:function () {
                _this.attr('disabled',false);
                locked = true;
            }

        });
        return false;
    });

    /**
     *  数据删除
     */
    $('.item-delete').click(function() {

        var _this = $(this);
        swal({
                title: "确认删除?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定",
                closeOnConfirm: false,
                cancelButtonText: "取消"
            },
            function(){

                if (! locked) {
                    return false;
                }

                locked = false;
                $.ajax({
                    url: _this.attr('data-url'),
                    type: 'POST',
                    data: {
                        "_method":"DELETE",
                        "_token":$('meta[name="csrf-token"]').attr('content')
                    },
                    cache: false,
                    dataType: 'json',
                    success:function(res) {

                        if(res.code != 0) {
                            swal(res.data, '', 'error');
                            locked = true;
                        } else {
                            swal(res.data, '', 'success');
                            window.location.href = document.location;
                        }
                    },
                    error:function () {
                        locked = true;
                    }

                });

            }
        );
    });

    /**
     *  开关状态更新
     */
    $("input[name=switch_submit]").change(function(){
        if (! locked) {
            return false;
        }

        locked = false;

        $.ajax({
            url: $(this).parent('.switch_submit').attr('data-href'),
            type: 'POST',
            data: {
                "_method": "PUT",
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "status": $(this).val()
            },
            cache: false,
            dataType: 'json',
            success:function(res) {
                if(res.code != 0) {
                    swal(res.data, '', 'error');
                    locked = true;
                } else {
                    swal(res.data, '', 'success');
                    locked = true;
                }
            },
            error:function () {
                locked = true;
            }

        });
    })
});
