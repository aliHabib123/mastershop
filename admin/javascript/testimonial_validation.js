function testimonial_validation(form)
{


if(form.testimonial_name.value == "")
{
alert("Please fill the Testimonial name field.");
form.testimonial_name.focus();
return (false);
}

if(form.company_id.value == 0)
{
alert("Please Select the Company field.");
form.company_id.focus();
return (false);
}

}