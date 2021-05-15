<?php

function main()
{
  $userMySqlExtDAO = new UserMySqlExtDAO();
  $admin = $userMySqlExtDAO->load($_SESSION['adminId']);
?>
  <link href="css/css.css" rel="stylesheet" type="text/css" />
  <script language="JavaScript" src="wysiwyg.js"></script>
  <script language="javascript" src="javascript/validate_admin.js"></script>
  <form action="update_cms_admin.php" name="admin_form" id="admin_form" method="post" onsubmit="return validate_admin(this)">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" class="TdTitle" height="25">Edit Administrator </td>
      </tr>
      <tr>
        <td height="25" class="FormControlDesc">Admin Name * </td>
        <td width="555" class="TdFormBorder"><input name="admin_name" type="text" class="InputText" id="admin_name" value="<?php echo $admin->firstName; ?>" size="100" readonly /></td>
      </tr>
      <tr>
        <td height="25" class="FormControlDesc">User Name * </td>
        <td width="555" height="25" class="TdFormBorder"><input name="user_name" type="text" class="InputText" id="user_name" value="<?php echo $admin->email; ?>" size="100" readonly /></td>
      </tr>
      <tr>
        <td height="25" class="FormControlDesc">Password * </td>
        <td width="555" height="25" class="TdFormBorder"><input name="password" type="password" class="InputText" id="password" value="" size="100" /></td>
      </tr>
      <tr>
        <td height="25" class="FormControlDesc">&nbsp;</td>
        <td width="555" height="25" class="TdFormBorder"><input name="Submit" type="submit" class="InputButtonBig" value="Update Admin" /></td>
      </tr>
    </table>
  </form>
<?php
}
include "template.php"; ?>