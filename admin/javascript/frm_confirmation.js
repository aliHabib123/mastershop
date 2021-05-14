// JavaScript Document

function frm_confirmation()
{
	var where_to= confirm("This will delete the record(s) and all related information \n\nAre you sure you want to delete");
	if (where_to== true)
	{
		myform.submit();
	}
	else
	{
		UnCheckAll(document.myform.check_list);
	}

}


