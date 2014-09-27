<!DOCTYPE html>
<html>
<head>
  <title>TEST</title>
  <style type="text/css">
ul, li {
  margin: 0;
  padding: 0;
  list-style: none;
}
.abgne_tab {
  clear: left;
  width: 100%;
  height: 100%;
  margin: 10px 0;
}
ul.tabs {
  width: 100%;
  height: 32px;
  border-bottom: 1px solid #999;
  border-left: 1px solid #999;
}
ul.tabs li {
  float: left;
  height: 31px;
  line-height: 31px;
  overflow: hidden;
  position: relative;
  margin-bottom: -1px;  /* 讓 li 往下移來遮住 ul 的部份 border-bottom */
  border: 1px solid #999;
  border-left: none;
  background: #e1e1e1;
}
ul.tabs li a {
  display: block;
  padding: 0 20px;
  color: #000;
  border: 1px solid #fff;
  text-decoration: none;
}
ul.tabs li a:hover {
  background: #ccc;
}
ul.tabs li.active  {
  background: #fff;
  border-bottom: 1px solid#fff;
}
ul.tabs li.active a:hover {
  background: #fff;
}
div.tab_container {
  clear: left;
  width: 100%;
  height: 100%;
  border: 1px solid #999;
  border-top: none;
  background: #fff;
}
div.tab_container .tab_content {
  padding: 20px;
  height: 100%;
}
div.tab_container .tab_content h2 {
  margin: 0 0 20px; 
}
  </style>
</head>
<body>
  <div class="abgne_tab">
    <ul class="tabs">
      <li><a href="#tab5">規則設定</a></li>
      <li><a href="#tab1">人</a></li>
      <li><a href="#tab2">物品</a></li>
      <li><a href="#tab3">歷史紀錄(尚未歸還)</a></li>
      <li><a href="#tab4">歷史紀錄(已歸還)</a></li>
      <li><a href="#tab6">數據分析</a></li>
      <li><a href="#tab7">迷你記錄表</a></li>
    </ul>
 
    <div class="tab_container">
      <div id="tab1" class="tab_content">
        <form action="human_search.php" target="human_iframe" method="POST" style="width:400px;"><input id="total_srh1" class="srch_cls" name="human_name_search" type="text"><input type="submit" value="search"></form><form action="human.php" target="human_iframe" style="width:200px;"><input type="submit" value="全部資料瀏覽" onclick="clearandclean('total_srh1');"></form>
        <iframe src="human.php" name="human_iframe" width="100%" height="80%"></iframe>
      </div>
      <div id="tab2" class="tab_content">
        <form action="stuff_search.php" target="stuff_iframe" method="POST" style="width:400px;"><input id="total_srh2" class="srch_cls" name="stuff_name_search" type="text"><input type="submit" value="search"></form><form action="stuff.php" target="stuff_iframe" style="width:200px;"><input type="submit" value="全部資料瀏覽" onclick="clearandclean('total_srh2);"></form>
        <iframe src="stuff.php" name="stuff_iframe" width="100%" height="80%"></iframe>
      </div>
      <div id="tab3" class="tab_content">
        <form action="record_search.php" target="record_frame" method="POST" style="width:400px;"><input id="total_srh3" class="srch_cls" name="record_name_search" type="text"><input type="submit" value="search"><label><br>日期格式:xxxx-xx-xx</label></form><form action="record.php" target="record_frame" style="width:200px;"><input type="submit" value="全部資料瀏覽" onclick="clearandclean('total_srh3');"></form>
        <iframe src="record.php" name="record_frame" width="100%" height="80%"></iframe>
      </div>
      <div id="tab4" class="tab_content">
        <form action="record_search2.php" target="record_frame2" method="POST" style="width:400px;"><input id="total_srh4" class="srch_cls" name="record_name_search2" type="text"><input type="submit" value="search"><label><br>日期格式:xxxx-xx-xx</label></form><form action="record2.php" target="record_frame2" style="width:200px;"><input type="submit" value="全部資料瀏覽" onclick="clearandclean('total_srh4');"></form>
        <iframe src="record2.php" name="record_frame2" width="100%" height="80%"></iframe>
      </div>
      <div id="tab5" class="tab_content">
        <iframe src="rule.php" name="rule_frame" width="100%" height="80%"></iframe>
      </div>
      <div id="tab6" class="tab_content">
        <iframe src="analyze.php" name="analyze_frame" width="100%" height="80%"></iframe>
      </div>
      <div id="tab7" class="tab_content">
        <iframe src="black_board.php" name="black_board_frame" width="100%" height="80%"></iframe>
      </div>
    </div>
  </div>
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
  function clearandclean(id){
    document.getElementById(id).value = '';
    document.getElementById(id).focus();
  }

  $(function(){
  // 預設顯示第一個 Tab
  var _showTab = 0;
  $('.abgne_tab').each(function(){
    // 目前的頁籤區塊
    var $tab = $(this);
 
    var $defaultLi = $('ul.tabs li', $tab).eq(_showTab).addClass('active');
    $($defaultLi.find('a').attr('href')).siblings().hide();
 
    // 當 li 頁籤被點擊時...
    // 若要改成滑鼠移到 li 頁籤就切換時, 把 click 改成 mouseover
    $('ul.tabs li', $tab).click(function() {
      // 找出 li 中的超連結 href(#id)
      var $this = $(this),
        _clickTab = $this.find('a').attr('href');
      // 把目前點擊到的 li 頁籤加上 .active
      // 並把兄弟元素中有 .active 的都移除 class
      $this.addClass('active').siblings('.active').removeClass('active');
      // 淡入相對應的內容並隱藏兄弟元素
      $(_clickTab).stop(false, true).fadeIn().siblings().hide();
      return false;
    }).find('a').focus(function(){
      this.blur();
    });
  });
});
</script>
</html>