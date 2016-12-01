function minus(item){
    var orig = Number(item.val());
    if(orig > 1){
        item.val(orig - 1);
        item.keyup();
    }
}
function increase(item){
    var orig = Number(item.val());
    item.val(orig + 1);
    item.keyup();
}

function set_num(item)
{
	var num = Number(item.val());
	if(num < 1 || num != item.val())
	{
		item.val(0);
		item.keyup();
	}
}

function set_float(item)
{
	var r = /^\d+(\.\d+)?$/;
	var str = item.val();
	if(! r.test(str))
	{
		item.val(0);
		item.keyup();
	}
}