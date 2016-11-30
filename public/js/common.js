/**
 * Created by voson on 2016/11/25.
 */

//Cookie相关自定义函数
//两个参数，一个是cookie的名子，一个是值
function SetCookie(key,value)
{
    var Days = 2; //此 cookie 将被保存 2 天
    var exp  = new Date();    //new Date("December 31, 9998");
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    //encodeURI对value进行编码，其中的某些字符将被十六进制的转义序列进行替换
    //toUTCString根据世界时 (UTC) 把 Date 对象转换为字符串
    document.cookie = key + "="+ encodeURI (value) + ";expires=" + exp.toUTCString();
}

//取cookies函数
function getCookie(key)
{
    var arr = document.cookie.match(new RegExp("(^| )"+key+"=([^;]*)(;|$)"));
    if(arr != null) return (arr[2]); return null;
}

//删除cookie
function delCookie(key)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(key);
    if(cval!=null) document.cookie= key + "="+cval+";expires="+exp.toUTCString();
}



//判断对象是否是数组
function isArray(obj) {
    return Object.prototype.toString.call(obj) === '[object Array]';
}

function readStorage(key) {
    var value;
    if(typeof(Storage)!=="undefined")
    {
        // 支持 localStorage  sessionStorage 对象,则写入localStorage
        value=localStorage.getItem(key);
    } else {
        // 不支持，读取cookie
        value=getCookie(key);
    }
    return value;
}


//弃用，目前仅使用cookie
//创建localstorage或者cookie
function createStorage(key,value) {
    if(typeof(Storage)!=="undefined")
    {
        // 支持 localStorage  sessionStorage 对象,则写入localStorage
        localStorage.setItem(key,value);
    } else {
        // 不支持，写入cookie
        SetCookie(key,value);
    }
}
