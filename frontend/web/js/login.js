var countdown=60;
function settime(btn) {
    var inpu=$(btn).parent().prev();
    if (countdown == 0) {
        $(btn).removeAttr("disabled"); 
        $(btn).css({'background-color':'#fff','color':'#333','border-color':'#ccc'}); 
        $(btn).text("获取");
     countdown = 60;
     return;
    } else {             
        $(btn).attr("disabled", true);
        $(btn).text("" + countdown + "s");
        countdown--;
  }

    setTimeout(function() { settime(btn); }, 1000);
}

function sendCode(jump){
    var tel=$("#loginform-username").val();
    var pattern = /^1[345789]\d{9}$/;   
    if(pattern.test(tel)){
        $.post("/index/send-msg", { tel: tel },
        function(data){
            if(data=='200'){
                alert('发送成功');
            }
        });
    }else{
        alert('请输入正确的手机号码！');
        return false;
    }
    settime(jump);      
}