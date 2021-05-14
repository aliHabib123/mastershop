// JavaScript Document

function delete_file_confirmation(page_link)
{
	var where_to= confirm("Are you sure you want to delete this file");
	if (where_to== true)
	{
		window.location=page_link;
	}
}