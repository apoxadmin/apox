// a tracking class for a reuseable tracking editor
function Tracking(name)
{
	
	// DOM elements that get referenced frequently
	this.list = null;
    this.name = name;
}

Tracking.prototype.start = function()
{
    // initialization
    this.initUsers();
}

Tracking.prototype.write = function(title, heading)
{
    document.write(
    '<table style="float: right" id="'+this.name+'list">' +
        '<tr><td class="heading" colspan="5">' +
            title +
        '</td></tr>' +
        '<tr>'+heading+'<th>Options</th></tr>' +
    '</table>');

    this.list = document.getElementById(this.name+'list');
}

Tracking.prototype.newrow = function(u, row)
{
    this.makerow(u, row);
    row.insertCell(-1);

    // add the last cell
    var a = document.createElement("a");
    a.href = "";
    a.innerHTML = '(Remove)';
    function associateObjWithEvent(o, f, u){
        return (function(){
            o[f](u);
            return false;
        });
    }
    a.onclick = associateObjWithEvent(this, "remove", u);
	row.cells[row.cells.length-1].appendChild(a);
}

Tracking.byName = function(a,b)
{
	if(a.name > b.name) return 1; 
	if(a.name < b.name) return -1; 
	return 0; 
}

Tracking.byNameReverse = function(a,b)
{ 
	if(a.name > b.name) return -1; 
	if(a.name < b.name) return 1; 
	return 0; 
}

Tracking.prototype.add = function(person)
{
    if(this.defaults != null)
        this.defaults(person);

	myusers.push(person);

    for(var r = 2; r < this.list.rows.length; r++)
    {
        if(this.list.rows[r].cells[0].lastChild.data > person.name)
            break;
    }
    
    this.list.insertRow(r);
    this.list.insertRow(2);
    var row = this.list.rows[2];
    this.newrow(myusers.length-1, row);
}

Tracking.prototype.getRow = function(person)
{
    for(var r = 2; r < this.list.rows.length; r++)
        if(this.list.rows[r].cells[0].firstChild.value == person.id)
            return r;

    return -1; // not found
}

Tracking.prototype.remove = function(i)
{
    var r = this.getRow(myusers[i]);
    if(r != -1)
    {
	    this.save(i, this.list.rows[r]);
        
        // inform interested parties
        if(this.notify != null)
            this.notify.call(this.notifyObject, myusers[i]);
        
        this.list.deleteRow(r);
        delete myusers[i];
        return;
    }

	alert('tell the webmaster! not found: ' + myusers[i].name);
}

Tracking.prototype.refresh = function()
{
	myusers.sort(Tracking.byNameReverse);
	
    var people = '';
	while(this.list.rows.length-2 > 0)
		this.list.deleteRow(2);
	
	for(var u = 0; u < myusers.length; u++)
	{
        if(myusers[u] == null)
            continue;
    
        this.list.insertRow(2);
	    this.newrow(u, this.list.rows[2]);
	}
}


Tracking.prototype.initUsers = function()
{
    for(var m in myusers)
        for(var u in users)
            if(users[u].id == myusers[m].id)
                delete users[u];
    this.refresh();
}

//---------------------------------------------------------------------


function Search(name)
{
    this.quickAdd = null;

	// DOM elements that get referenced frequently
	this.box = null;
	this.list = null;

    // used for html element ids
    this.name = name;
}

Search.prototype.write = function()
{
    function associateObjWithEvent(o, f){
        return (function(e){
            e = e || window.event;
            o[f](e.keyCode);
            return false;
        });
    }
    
    //var input = document.createElement("input");
    //input.type = "text";
    var id = this.name;
document.write('<div class="general" style="float:left;width:250px;">');
document.write('<div class="general boxtop">');
document.write('Add People</span></div><br/>');
document.write('<div class="general" style="border-width: 0px;">');
    document.write('Enter part of a person\'s name to see matches, '+
    'and click on the names to add them.<br/>');
    document.write('<input id="'+id+'box" type="text" />');
    document.write('<div id="'+id+'list"></div>');
    document.write('<div style="clear: both"></div>');
    document.write('</div>');
    document.write('</div>');
	
    // DOM elements that get referenced frequently
	this.box = document.getElementById(id+'box');
	this.list = document.getElementById(id+'list');

    // add event handler
    document.getElementById(id+'box').onkeyup = 
        associateObjWithEvent(this, "refresh");
}

Search.prototype.remove = function(i)
{
    // tell anyone interested
    if(this.notify != null)
    {
        var f = this.notify;
        var o = this.notifyObject;
        f.call(o, users[i]);
    }
    
    delete users[i];
    this.refresh();
}

Search.prototype.start = function()
{
    this.box.value = '';
    this.box.focus();
    this.refresh();
}

Search.prototype.add = function(user)
{
    users.push(user);
    this.refresh();
}

Search.prototype.refresh = function(key)
{
	users.sort(Tracking.byName);
    
    // user pressed enter, add listed person if there's only 1
	if(key == 13 && this.quickAdd != null)
	{
		this.box.value = '';
		this.remove(this.quickAdd);
		return;
	}
	
	// don't bother searching when there aren't any search terms
	if(this.box.value == '')
	{
		this.list.innerHTML = '';
		return;
	}
	
	var terms = this.box.value.split(' ');
	
	var count = 0;
	var people = '';
	
	user: for(var u = 0; u < users.length; u++)
    {
		for(var t in terms)
		{
            if(users[u] == null)
                continue user;
			if(!users[u].name.toLowerCase().match( terms[t].toLowerCase() ))
				continue user;
		}
		this.quickAdd = u;

		people += "<a href=\"javascript:s.remove('"+u+"');\">" + 
                  users[u].name + "</a><br/>";
		count++;
	}
	
	if(count != 1)
		this.quickAdd = null;

	if(count < 20)
		this.list.innerHTML = people;
	else
		this.list.innerHTML = 'too many results.';
}

