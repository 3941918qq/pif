<nav class="topmenu  navbar navbar-fixed-top navbar-inverse " >
<!--       <div class="swiper-container div_logo">
          <span class="sbrand glyphicon glyphicon-chevron-left" onclick="returnStep()"></span>
      </div> -->
      <div class="input-group search" >
          <input type="text" class="form-control" placeholder="请输入标题..." aria-describedby="basic-addon2">
          <span class="input-group-addon glyphicon glyphicon-search" id="basic-addon2" onclick="link(this)" style="top:0;padding:6px 18px;font-size:2.2rem;"></span>
      </div>      
</nav>

<!-- 内容 -->
<div class="container" style="padding-top:50px;font-size:14px;">
<div class="row" >
 
    <div class="thumbnail" >
        <h3>热门搜索</h3>
        <ul class="nav nav-pills">
        <?php if($history['hotsearch']){
            foreach($history['hotsearch'] as $k=>$v){
            ?>
            <div class="disk col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <li role="presentation" class="active text-center"><a href="/home/view?search=<?=$v?>"><?=  (mb_strlen($v) > 9) ? mb_substr($v, 0, 6).'...' :$v;?></a></li>
            </div>
        <?php } }else{ ?>
        <div class="disk col-xs-12 col-sm-12 col-md-12 col-lg-12">暂无热门搜索记录</div> 
        <?php }?>
      </ul> 
    </div>
    <div class="thumbnail">
        <h3>历史搜索</h3>
        <ul class="nav nav-pills">
        <?php if($history['historysearch']){
            foreach($history['historysearch'] as $k=>$v){
            ?>
            <div class="disk col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <li role="presentation" class="active text-center"><a href="/home/view?search=<?=$v?>"><?= (strlen($v) > 9) ? substr($v, 0, 6).'...' :$v;?></a></li>
            </div>
        <?php } }else{ ?>
        <div class="disk col-xs-12 col-sm-12 col-md-12 col-lg-12">暂无历史记录</div> 
        <?php }?>
      </ul> 
      <button type="button" class="btn btn-danger btn-block"  onclick="clearhis()">清除历史</button>      
    </div>
</div>
</div>
<script>     
    function link(jump){
        var val=$.trim($(jump).prev().val());
        if(val){
           window.location.href="/home/view?search="+val;
        }else window.location.href="/home/search";    
    }   

    function clearhis(){
         var type="clear" ;
         $.post("/home/clearhis", { type: type },
            function(data){             
               if(data.message>0){
                   alert("清理成功！");
                   window.location.reload();
               }else{
                   alert("无需清理！");
               }
            });
    }    

</script>



