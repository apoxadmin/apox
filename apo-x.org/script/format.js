var req;

function load(url, callback) 
{
	if (window.ActiveXObject)
	{
		req = new ActiveXObject("Microsoft.XMLHTTP");
		req.onreadystatechange = callback;
	}
	else if (window.XMLHttpRequest)
	{
		req = new XMLHttpRequest();
		req.onload = callback;
	}

	req.open("GET", url, true);
	req.send(null);
}

// from http://tech.irt.org/
function Set_Cookie(name,value,expires) {
    document.cookie = name + "=" +escape(value) +
        ( (expires) ? ";expires=" + expires.toGMTString() : "") +
        ";path=;domain=";
}

function valid(form)
{
	var inputs = form.elements;
	var correct;

	for(i=0; i<inputs.length; i++)
	{
		correct = true;
		switch(inputs[i].id)
		{
			case "text":
				correct = isText(inputs[i].value);
			break;
			case "text_required":
				correct = isTextRequired(inputs[i].value);
			break;			
			case "textarea":
				correct = isTextArea(inputs[i].value);
			break;
			case "date":
				correct = isDate(inputs[i].value);
			break;
			case "time":
				correct = isTime(inputs[i].value);
			break;
			case "duration":
				correct = isDuration(inputs[i].value);
			break;
			case "capacity":
				correct = isInteger(inputs[i].value);
				if(!correct)
					alert("Please enter a number for the capacity.");
				
			break;
			case "phone":
				correct = isInteger(inputs[i].value);
				if(!correct)
					alert("Please enter a valid phone number.");
			break;
		}

		if (correct==false) 
		{
			inputs[i].focus();
			inputs[i].select();
			return false;
		}
	}
	
	return true;
}

// General helper functions

function isInteger(s)
{
	var i;
	if(s.length < 1)
		return false;
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) 
			return false;
    }
    return true;
}

function stripCharsInBag(s, bag)
{
	var i;
    var returnString = "";
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) 
			returnString += c;
    }
    return returnString;
}

// isDate() related functions

function daysInFebruary (year){
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}

function DaysArray(n) 
{
	for (var i = 1; i <= n; i++) 
	{
		this[i] = 31;
		if (i==4 || i==6 || i==9 || i==11) 
			this[i] = 30;
		else if (i==2) 
			this[i] = 29;
   } 
   return this;
}

function isDate(dtStr){
	var maxYear=2050;
	var minYear=1950;
	var dtCh= "/";
	var daysInMonth = DaysArray(12);
	var pos1=dtStr.indexOf(dtCh);
	var pos2=dtStr.indexOf(dtCh,pos1+1);
	var strMonth=dtStr.substring(0,pos1);
	var strDay=dtStr.substring(pos1+1,pos2);
	var strYear=dtStr.substring(pos2+1);
	strYr = strYear;
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1);
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1);
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1);
	}
	month=parseInt(strMonth);
	day=parseInt(strDay);
	year=parseInt(strYr);
	if (pos1==-1 || pos2==-1){
		alert("The date format should be : mm/dd/yyyy");
		return false;
	}
	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month.");
		return false;
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Please enter a valid day.");
		return false;
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear);
		return false;
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Please enter a valid date");
		return false;
	}

	return true;
}

// isTime() function

function isTime(timeStr)
{
	var timeStr = timeStr.toLowerCase();
	var posColon = timeStr.indexOf(":");
	var hourStr = timeStr.substring(0,posColon);
	var minStr = timeStr.substr(posColon+1,(timeStr.length - (posColon - 1)));
	var hour = parseInt(hourStr);
	var min = parseInt(minStr);
	var posAM = timeStr.indexOf("am");
	var posPM = timeStr.indexOf("pm");
	var errorMsg = "Please enter a valid time in the format hour:minute pm/am";
	
	if (min < 0 || min > 59 || hour < 1 || hour > 12) {
		alert(errorMsg);
		return false;
	}
	if (posColon == -1) {
		alert(errorMsg);
		return false;
	}
	if (posPM + posAM < 0) {
		alert(errorMsg);
		return false;
	}
	if (hourStr == "") {
		alert(errorMsg);
		return false;
	}
	if (min < 10) {
		if (minStr.charAt(0) != "0") { 
			alert(errorMsg);
			return false;
		}
		if (min == 0) {
			if (minStr.charAt(1) != "0") {
				alert(errorMsg);
				return false;
			}
		}
	}
	if (isInteger(minStr.charAt(0)) == false) {
		alert(error);
		return false;
	}
	return true;
}

// isDuration() function

function isDuration(durStr)
{
	var posColon = durStr.indexOf(":");
	var errorMsg = "Please enter a valid duration in H:MM format";
	if (posColon == -1) 
	{
		alert(errorMsg);
		return false;
	} 
	else
	{
		if (posColon > 2 || posColon == 0) {
			alert(errorMsg);
			return false;
		}
		var hourStr = durStr.substring(0,posColon);
		var minStr = durStr.substring(posColon+1,durStr.length);
		if (isInteger(hourStr) == false) {
			alert(errorMsg);
			return false;
		}
		if (isInteger(minStr) == false) {
			alert(errorMsg);
			return false;
		}
		var hour = parseInt(hourStr);
		var min = parseInt(minStr);
		if (hour < 0 || hour > 12 || min < 0 || min > 59) {
			alert(errorMsg);
			return false;
		}
		if (min < 10) {
			if (minStr.charAt(0) != "0") { 
				alert(errorMsg);
				return false;
			}
		}
	}
	return true;
}

// text functions

function isTextArea(taStr)
{
	/*if (taStr.length > 255) {
		alert("Please enter a shorter description.");
		return false;
	}*/
	return true;
}	

function isText(taStr)
{
	return true;
}	

function isTextRequired(taStr)
{
	if (taStr.length < 1) {
		alert("Please fill in required fields.");
		return false;
	}
	return true;
}	

// public functions

function ValidateEventModifyForm(){
	var form = document.forms.event;
	if(form.name.value.length==0)
	{
		alert("Please enter a title");
		return false;
	}
	if (isDate(form.date.value)==false){
		form.date.focus();
		form.date.select();
		return false;
	}
    if (isTime(form.time.value)==false) {
		form.time.focus();
		form.time.select();
		return false;
	}
	if (isDuration(form.duration.value)==false) {
		form.duration.focus();
		form.duration.select();
		return false;
	}
	if (isTextArea(form.description.value)==false) {
		form.description.focus();
		form.description.select();
		return false;
	}
	
	return true;
}

function ValidateShiftModifyForm(){
	var form = document.forms.shift;
    if (isTime(form.start.value)==false) {
		form.start.focus();
		form.start.select();
		return false;
	}
    if (isTime(form.end.value)==false) {
		form.end.focus();
		form.end.select();
		return false;
	}
	if (isInteger(form.capacity.value)==false) {
		alert("Please enter a number for the capacity.");
		form.capacity.focus();
		form.capacity.select();
		return false;
	}
	
	return true;
}

function confirmReplace()
{
	return confirm("Please be aware that you are STILL RESPONSIBLE for this shift until further notice.  This system enables other brothers to replace you if they wish, but if you are not replaced and you don't show up for this shift, you will still receive negative hours.");
}

function confirmDialog()
{
	return confirm("Are you sure?");
}



