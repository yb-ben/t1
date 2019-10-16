//点击按钮下载
let foo = function(url){
 let a = document.createElement('a');
 //window.open(u);
 a.href = url
 a.target = '_black';
 a.click();
}