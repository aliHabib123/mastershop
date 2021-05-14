<?php function main() {?>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="javascript/cms_general_validation.js"></script>
<form action="insert_cms_general.php" method="post" enctype="multipart/form-data" name="frm" id="frm"   onsubmit="return cms_general_validation(this)" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="" class="TdTitle"  height="25">Create New Cms general</td>
		<td colspan="" class="" >
			<a href="javascript:if(confirm('Are you sure you want to leave this page?')) history.back()"><img src="images/backbtn.png" border="0" height="25"/> </a>
		</td>
	</tr>
	<tr>
		<td width="244" class="FormControlDesc">Site title</td>
		<td  class="TdFormBorder"><input  name="site_title" type="text"  class="InputTextTitle" id="site_title" value="" ></td>
	</tr>
	<tr>
		<td width="244" class="FormControlDesc">Record/page</td>
		<td  class="TdFormBorder"><input  name="record/page" type="text"  class="InputTextTitle" id="record/page" value="" ></td>
	</tr>
	<tr>
		<td width="244" class="FormControlDesc">Email</td>
		<td  class="TdFormBorder"><input  name="email" type="text"  class="InputTextTitle" id="email" value="" ></td>
	</tr>
<tr>
      <td class="FormControlDesc">&nbsp;</td>
      <td class="TdFormBorder">
          <input name="Submit2" type="submit" class="InputButtons" value="            Add Data            " />
          <input name="Reset" type="button" class="InputButtons" value="Cancel & Back" onclick="javascript:if(confirm('Are you sure you want to leave this page?')) history.back()"/>
       </td>
    </tr>
</table>
</form>
<?php }include "template.php";?>