$('#company-search').bind('input propertychange', function() {
    var val=$("#company-search").val();
    if(val!=""){           
        $.ajax({
            type: "POST", //请求的方式，也有get请求
            url: "/index/search-company", //请求地址，后台提供的,这里我在本地自己建立了个json的文件做例子
//                     contentType: "application/json; charset=utf-8",
            data: {val:val},//data是传给后台的字段，后台需要哪些就传入哪些
            dataType: "json", //json格式，后台返回的数据为json格式的。
            success: function(result){
                if(result.data.length>0){
                    $('.pop-area').removeClass('hide');
                    var dataObj = result, //返回的result为json格式的数据
                    con = "";
                    $.each(dataObj.data, function(index, item){
                        con += "<li onclick='choose(this)'>"+item.name+"</li>";
                    });  
                    $(".pop-area").html(con); //把内容入到这个div中即完成
                }else{
                    $('.pop-area').addClass('hide');
                }


            }    
        })
    }
    
    
});
function choose(jump){
        var text =$(jump).text();
    $("#company-search").val(text); 
    $('.pop-area').addClass('hide');
}