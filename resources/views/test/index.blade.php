<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>ページタイトル</title>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#test1").click(function(){
		$.ajaxSetup({
			  headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			});
		$.ajax({
			url:"/api/Account",
			type:"GET",
			dataType:"json",
		})
		.done(function(data){
			$("#response1").text(data[0].id);
			console.log(data[0].id);
		});
		;
	});
});
</script>
</head>
<body>
 <button id="test1">テスト１</button><br />
 <div id="response1"></div>
 
</body>
</html>