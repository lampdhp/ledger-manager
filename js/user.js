$(document).ready(function(){
//    nav-li hover e
    //var num;
    $('.user').on("click",function(){   //.hover(function(){
       /*图标向上旋转*/
        //$(this).children().removeClass().addClass('hover-up');
        /*下拉框出现*/
        var Obj = $(this).attr('id');
        //num = Obj.substring(3, Obj.length);
        $('#box-1').slideDown(300);
    },function(){
        /*图标向下旋转*/
        //$(this).children().removeClass().addClass('hover-down');
        /*下拉框消失*/
        $('#box-1').hide();
    });
//    hidden-box hover e
    $('.hidden-box').hover(function(){  //hover
        /*保持图标向上*/
        //$('#li-'+num).children().removeClass().addClass('hover-up');
        $(this).show();
    },function(){
        $(this).slideUp(200);
        //$('#li-'+num).children().removeClass().addClass('hover-down');
    });
});
