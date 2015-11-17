<body onload="countDown()">
<div>
  <div style="background:#FFF; padding: 20px 50px; margin: 2px;">
    <table align="center" width="400">
      <tr>
        <td width="50" valign="top">
          <?php if($data['error']=="0"){
            echo $data['type']."成功";?>
			还有<span id="time">5</span>秒跳回列表
          <?php }elseif($data['error']=="1"){ 
            echo $data['type']."失败"; ?>
            还有<span id="time">5</span>秒跳回列表
		  <?php }?>
        </td>
      </tr>
    </table>
  </div>
</div>
    
</body>
<script type="text/javascript">
var t = 5;
function countDown(){
var time = document.getElementById("time");
t--;
time.innerHTML=t; 
if (t<=0) {
location.href="index.php?r=denglu";
clearInterval(inter);
};
}
var inter = setInterval("countDown()",1000);
//window.onload=countDown;
</script> 