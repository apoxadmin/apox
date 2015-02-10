jQuery(document).ready(function(){	setInterval(function(){
	run_countdown("1")}, 1000);
});

function run_countdown(num) {
		
		var str = document.getElementById(num).innerHTML; 
		if(str === '0'){
			str = 59;
			document.getElementById(num).innerHTML=str;
			num = parseInt(num);
			num = num + 1;
			run_countdown(num);
			num = parseInt(num);
			num = num - 1;
			return;
		} 
		var minus = str - 1;
		var res = str.replace(str,minus);
		document.getElementById(num).innerHTML=res;
		return;
	};