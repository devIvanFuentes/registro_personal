<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
</head><body>
 

<?php

if (count($_POST) && (strpos($_POST['img'], 'data:image/png;base64') === 0)) {
	
  $img = $_POST['img'];
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $data = base64_decode($img);
  $file = 'uploads/img'.date("YmdHis").'.png';
  
  if (file_put_contents($file, $data)) {
     echo "<p>The canvas was saved as $file.</p>";
  } else {
     echo "<p>The canvas could not be saved.</p>";
  }	
  
}
					 
?>

<canvas id="canv" width="200" height="200"></canvas>

<form method="post" action="" onsubmit="prepareImg();">
  <input id="inp_img" name="img" type="hidden" value="">
  <input id="bt_upload" type="submit" value="Upload">
</form>



<script>
    
  var canvas = document.getElementById('canv');
  var context = canvas.getContext('2d');

  context.arc(100, 100, 50, 0, 2 * Math.PI);
  context.lineWidth = 5;
  context.fillStyle = '#EE1111';
  context.fill();	
  context.strokeStyle = '#CC0000';
  context.stroke();
	
	
  function prepareImg() {
     var canvas = document.getElementById('canv');
     document.getElementById('inp_img').value = canvas.toDataURL();
  }
  
</script>

</body></html>