function validate_setting()
{ 
	if (document.setting_form.site_title.value == "")
	{
		alert("Please enter Site Title.");
		document.setting_form.site_title.focus();
		return (false);
	}
	if (document.setting_form.record_page.value == "")
	{
		alert("Please enter Record / Page.");
		document.setting_form.record_page.focus();
		return (false);
	}
	if ( document.setting_form.email.value.indexOf ('@', 0) == -1 || document.setting_form.email.value.indexOf ('.', 0) == -1 ) 
	{
		alert("Please enter Site Email.");
		document.setting_form.email.focus();
		return (false);
	}
	
	return (true);
}