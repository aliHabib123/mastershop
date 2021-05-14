function banner_validation(form)
{


if(form.banner_caption.value == "")
{
alert("Please fill the Banner caption field.");
form.banner_caption.focus();
return (false);
}

if(form.page_id.value == 0)
{
alert("Please Select the Page id field.");
form.page_id.focus();
return (false);
}

}