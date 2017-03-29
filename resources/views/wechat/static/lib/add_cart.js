/**
 * Created by Administrator on 2017/3/29.
 */
/*
 思路：
 第一步：获取所要操作的节点对象
 第二步：当页面加载完后，需要计算本地cookie存了多少【个】商品，把个数赋值给ccount
 第三步：为每一个商品对应的添加购物车按钮绑定一个点击事件onclick
 更改本地的cookie
 获取当前商品的pid
 循环遍历本地的cookie转换后的数组，取出每一个对象的pid进行对比，若相等则该商品不是第一次添加
 从购物车中取出该商品，然后更pCount值追加1
 否则：创建一个新的对象，保存到购物中。同时该商品的数量为1
 */
var submit = document.getElementById('submit');
//约定好用名称为datas的cookie来存放购物车里的数据信息  datas里所存放的就是一个json字符串
var listStr = cookieObj.get("datas");
/*判断一下本地是否有一个购物车（datas），没有的话，创建一个空的购物车，有的话就直接拿来使用*/
if(!listStr) { //没有购物车     datas  json
    cookieObj.set({
        name: "datas",
        value: "[]"
    });
    listStr = cookieObj.get("datas");
}

var listObj = JSON.parse(listStr); //数组

submit.onclick = function() {

    var pid = document.getElementById('x-pd-info1').getAttribute("pid");//获取自定义属性
  alert(pid);
    if(checkObjByPid(pid)) {
        listObj = updateObjById(pid, 1)
    } else {
        var imgSrc = document.getElementById('info1-img').src;
        var pName = document.getElementById('title').innerHTML;
       // var pDesc = arrs[2].innerHTML;
        var price = document.getElementById('price').innerHTML;
        var obj = {
            pid: pid,
            pImg: imgSrc,
            pName: pName,
            pDesc: pName,
            price: price,
            pCount: 1
        };
        listObj.push(obj);
        listObj = updateData(listObj);
    }
   var url = "{{url('/resources/views/wechat/cart_step1.htm')}}";
    // var url = '/resources/views/wechat/cart_step1.htm';
    submit.setAttribute('href',url);

};