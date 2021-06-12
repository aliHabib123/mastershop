<?php

namespace Application\Controller;

class MailController
{

  public static function sendMail($to, $subject, $emailBody, $fromEmail = "info@thirteencube.com", $fromName = "Matershop")
  {
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // More headers
    $headers .= 'From: ' . $fromName . '<' . $fromEmail . '>' . "\r\n";
    //$headers .= 'Cc: myboss@example.com' . "\r\n";
    $send = mail($to, $subject, $emailBody, $headers);
    return $send;
  }

  public static function getEmailHtmlTemplate($title, $textArray = [], $action = false)
  {
    $html = "<!doctype html>
        <html>
          <head>
            <meta name=\"viewport\" content=\"width=device-width\">
            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
            <title>$title</title>";

    $html .= self::getEmailStyles();

    $html .= "</head>
          <body class=\"\" style=\"background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
            <span class=\"preheader\" style=\"color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;\">$title</span>
            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;\">
              <tr>
                <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">&nbsp;</td>
                <td class=\"container\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 800px; padding: 10px; width: 800px;\">
                  <div class=\"content\" style=\"box-sizing: border-box; display: block; Margin: 0 auto; max-width: 800px;\">
                  <div class=\"content-header\" style=\"font-size: 20px;font-family: sans-serif;color:#fff;text-transform:uppercase;\">$title</div>
                    <!-- START CENTERED WHITE CONTAINER -->
                    <table class=\"main\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;\">
                      <!-- START MAIN CONTENT AREA -->
                      <tr>
                        <td class=\"wrapper\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;\">
                          <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;\">
                            <tr>
                              <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">";
    if ($textArray) {
      foreach ($textArray as $row) {
        $html .= self::getEmailLine($row);
      }
    }
    if ($action) {
      $html .= $action;
    }
    $html .= "</td>";
    $html .= "</tr>";
    $html .= MailController::getEmailFooter();
    $html .= "</table>
                        </td>
                      </tr>
        
                    <!-- END MAIN CONTENT AREA -->
                    </table>";


   
    $html .= "<!-- END CENTERED WHITE CONTAINER -->
                  </div>
                </td>
                <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">&nbsp;</td>
              </tr>
            </table>
          </body>
        </html>";
    return $html;
  }

  public static function getEmailFooter()
  {
    $logoLink = SITE_LINK. "public/img/logo.png";
    return "<tr>
          <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">
          <p style=\"font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-top: 15px;\">Regards,</p>
          <p style=\"font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;\">Mastershop</p>
          <p><img style=\"max-height: 50px;\" src=\"$logoLink\"/></p>
          </td>
          </tr>";
  }
  public static function getCallToAction($link, $text)
  {
    return "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"btn btn-primary\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;\">
              <tbody>
                <tr>
                  <td align=\"left\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;\">
                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;\">
                      <tbody>
                        <tr>
                          <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;\">
                            <a href=\"$link\" target=\"_blank\" style=\"display: inline-block; color: #ffffff; background-color: #2576ba; border: 1px solid #2576ba; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize;\">$text</a> 
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>";
  }

  public static function getEmailLine($text = "")
  {
    if ($text == "") {
      return '<br>';
    }
    return "<p style=\"font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;\">$text</p>";
  }
  public static function getEmailStyles()
  {
    return "<style>
        /* -------------------------------------
            INLINED WITH htmlemail.io/inline
        ------------------------------------- */
        /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
        ------------------------------------- */
        @media only screen and (max-width: 620px) {
          table[class=body] h1 {
            font-size: 28px !important;
            margin-bottom: 10px !important;
          }
          table[class=body] p,
                table[class=body] ul,
                table[class=body] ol,
                table[class=body] td,
                table[class=body] span,
                table[class=body] a {
            font-size: 16px !important;
          }
          table[class=body] .wrapper,
                table[class=body] .article {
            padding: 10px !important;
          }
          table[class=body] .content {
            padding: 0 !important;
          }
          table[class=body] .container {
            padding: 0 !important;
            width: 100% !important;
          }
          table[class=body] .main {
            border-left-width: 0 !important;
            border-radius: 0 !important;
            border-right-width: 0 !important;
          }
          table[class=body] .btn table {
            width: 100% !important;
          }
          table[class=body] .btn a {
            width: 100% !important;
          }
          table[class=body] .img-responsive {
            height: auto !important;
            max-width: 100% !important;
            width: auto !important;
          }
        }
    
        /* -------------------------------------
            PRESERVE THESE STYLES IN THE HEAD
        ------------------------------------- */
        @media all {
          .ExternalClass {
            width: 100%;
          }
          .ExternalClass,
                .ExternalClass p,
                .ExternalClass span,
                .ExternalClass font,
                .ExternalClass td,
                .ExternalClass div {
            line-height: 100%;
          }
          .apple-link a {
            color: inherit !important;
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            text-decoration: none !important;
          }
          #MessageViewBody a {
            color: inherit;
            text-decoration: none;
            font-size: inherit;
            font-family: inherit;
            font-weight: inherit;
            line-height: inherit;
          }
          .content-header{
            background-color: #2576ba;
            padding: 30px 15px;
            text-align: center;
          }
        }
        </style>";
  }

  public static function getOrderCompleteEmail($showAds = false)
  {
    $html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" style=\"width:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0\">
<head>
<meta charset=\"UTF-8\">
<meta content=\"width=device-width, initial-scale=1\" name=\"viewport\">
<meta name=\"x-apple-disable-message-reformatting\">
<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
<meta content=\"telephone=no\" name=\"format-detection\">
<title>New email template 2021-06-07</title>
<!--[if (mso 16)]>
<style type=\"text/css\">
a {text-decoration: none;}
</style>
<![endif]-->
<!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
<!--[if gte mso 9]>
<xml>
<o:OfficeDocumentSettings>
<o:AllowPNG></o:AllowPNG>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
<![endif]-->
<!--[if !mso]><!-- -->
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i\" rel=\"stylesheet\">
<!--<![endif]-->
<style type=\"text/css\">
#outlook a {
padding:0;
}
.ExternalClass {
width:100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
line-height:100%;
}
.es-button {
mso-style-priority:100!important;
text-decoration:none!important;
}
a[x-apple-data-detectors] {
color:inherit!important;
text-decoration:none!important;
font-size:inherit!important;
font-family:inherit!important;
font-weight:inherit!important;
line-height:inherit!important;
}
.es-desk-hidden {
display:none;
float:left;
overflow:hidden;
width:0;
max-height:0;
line-height:0;
mso-hide:all;
}
[data-ogsb] .es-button {
border-width:0!important;
padding:15px 30px 15px 30px!important;
}
@media only screen and (max-width:600px) {p, ul li, ol li, a { line-height:150%!important } h1 { font-size:32px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } .es-header-body h1 a, .es-content-body h1 a, .es-footer-body h1 a { font-size:32px!important } .es-header-body h2 a, .es-content-body h2 a, .es-footer-body h2 a { font-size:26px!important } .es-header-body h3 a, .es-content-body h3 a, .es-footer-body h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-content-body p, .es-content-body ul li, .es-content-body ol li, .es-content-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class=\"gmail-fix\"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } a.es-button, button.es-button { font-size:16px!important; display:inline-block!important; border-width:15px 30px 15px 30px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
</style>
</head>
<body style=\"width:100%;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0\">
<div class=\"es-wrapper-color\" style=\"background-color:#EEEEEE\">
<!--[if gte mso 9]>
<v:background xmlns:v=\"urn:schemas-microsoft-com:vml\" fill=\"t\">
<v:fill type=\"tile\" color=\"#eeeeee\"></v:fill>
</v:background>
<![endif]-->
<table class=\"es-wrapper\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top\">
<tr style=\"border-collapse:collapse\">
<td valign=\"top\" style=\"padding:0;Margin:0\">
<table cellpadding=\"0\" cellspacing=\"0\" class=\"es-content\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%\">
<tr style=\"border-collapse:collapse\">
<td align=\"center\" style=\"padding:0;Margin:0\">
<table class=\"es-content-body\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px\">
<!--[if mso]><table style=\"width:580px\" cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"width:282px\" valign=\"top\"><![endif]-->
<table class=\"es-left\" cellspacing=\"0\" cellpadding=\"0\" align=\"left\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0;width:282px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td class=\"es-infoblock es-m-txt-c\" align=\"left\" style=\"padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:14px;color:#CCCCCC;font-size:12px\">Put your preheader text here</p></td>
</tr>
</table></td>
</tr>
</table>
<!--[if mso]></td><td style=\"width:20px\"></td><td style=\"width:278px\" valign=\"top\"><![endif]-->
<table class=\"es-right\" cellspacing=\"0\" cellpadding=\"0\" align=\"right\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0;width:278px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td align=\"right\" class=\"es-infoblock es-m-txt-c\" style=\"padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:14px;color:#CCCCCC;font-size:12px\"><a href=\"https://viewstripo.email\" class=\"view\" target=\"_blank\" style=\"-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;color:#CCCCCC;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif\">View in browser</a></p></td>
</tr>
</table></td>
</tr>
</table>
<!--[if mso]></td></tr></table><![endif]--></td>
</tr>
</table></td>
</tr>
</table>
<table class=\"es-content\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%\">
<tr style=\"border-collapse:collapse\"></tr>
<tr style=\"border-collapse:collapse\">
<td align=\"center\" style=\"padding:0;Margin:0\">
<table class=\"es-header-body\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#044767;width:600px\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#044767\" align=\"center\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"Margin:0;padding-top:35px;padding-bottom:35px;padding-left:35px;padding-right:35px\">
<!--[if mso]><table style=\"width:530px\" cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"width:340px\" valign=\"top\"><![endif]-->
<table class=\"es-left\" cellspacing=\"0\" cellpadding=\"0\" align=\"left\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left\">
<tr style=\"border-collapse:collapse\">
<td class=\"es-m-p0r es-m-p20b\" valign=\"top\" align=\"center\" style=\"padding:0;Margin:0;width:340px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td class=\"es-m-txt-c\" align=\"left\" style=\"padding:0;Margin:0\"><h1 style=\"Margin:0;line-height:36px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:36px;font-style:normal;font-weight:bold;color:#FFFFFF\">Mastershop</h1></td>
</tr>
</table></td>
</tr>
</table>
<!--[if mso]></td><td style=\"width:20px\"></td><td style=\"width:170px\" valign=\"top\"><![endif]-->
<table cellspacing=\"0\" cellpadding=\"0\" align=\"right\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr class=\"es-hidden\" style=\"border-collapse:collapse\">
<td class=\"es-m-p20b\" align=\"left\" style=\"padding:0;Margin:0;width:170px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td align=\"center\" style=\"padding:0;Margin:0;padding-bottom:5px;font-size:0\">
<table width=\"100%\" height=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td style=\"padding:0;Margin:0;border-bottom:1px solid #044767;background:#FFFFFF none repeat scroll 0% 0%;height:1px;width:100%;margin:0px\"></td>
</tr>
</table></td>
</tr>
<tr style=\"border-collapse:collapse\">
<td style=\"padding:0;Margin:0\">
<table cellspacing=\"0\" cellpadding=\"0\" align=\"right\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td align=\"right\" style=\"padding:0;Margin:0\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#FFFFFF;font-size:14px\"><a target=\"_blank\" style=\"-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;color:#FFFFFF;font-size:18px;line-height:22px\" href=\"https://viewstripo.email\">Shop</a></p></td>
</tr>
</table></td>
<td valign=\"top\" align=\"left\" style=\"padding:0;Margin:0;padding-left:10px;font-size:0\"><a href=\"https://viewstripo.email\" target=\"_blank\" style=\"-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;color:#FFFFFF;font-size:14px\"><img src=\"https://hffwp.stripocdn.email/content/guids/CABINET_75694a6fc3c4633b3ee8e3c750851c02/images/77981522050090360.png\" alt style=\"display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic\" width=\"27\"></a></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
<!--[if mso]></td></tr></table><![endif]--></td>
</tr>
</table></td>
</tr>
</table>
<table class=\"es-content\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%\">
<tr style=\"border-collapse:collapse\">
<td align=\"center\" style=\"padding:0;Margin:0\">
<table class=\"es-content-body\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#ffffff\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0;padding-left:35px;padding-right:35px;padding-top:40px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td valign=\"top\" align=\"center\" style=\"padding:0;Margin:0;width:530px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td align=\"center\" style=\"Margin:0;padding-top:25px;padding-bottom:25px;padding-left:35px;padding-right:35px;font-size:0\"><a target=\"_blank\" href=\"https://viewstripo.email/\" style=\"-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:none;color:#ED8E20;font-size:16px\"><img src=\"https://hffwp.stripocdn.email/content/guids/CABINET_75694a6fc3c4633b3ee8e3c750851c02/images/67611522142640957.png\" alt style=\"display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic\" width=\"120\"></a></td>
</tr>
<tr style=\"border-collapse:collapse\">
<td align=\"center\" style=\"padding:0;Margin:0;padding-bottom:10px\"><h2 style=\"Margin:0;line-height:36px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:30px;font-style:normal;font-weight:bold;color:#333333\">Thank You For Your Order!</h2></td>
</tr>
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0;padding-top:15px;padding-bottom:20px\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#777777;font-size:16px\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium iste ipsa numquam odio dolores, nam.</p></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
<table class=\"es-content\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%\">
<tr style=\"border-collapse:collapse\">
<td align=\"center\" style=\"padding:0;Margin:0\">
<table class=\"es-content-body\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#ffffff\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0;padding-top:20px;padding-left:35px;padding-right:35px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td valign=\"top\" align=\"center\" style=\"padding:0;Margin:0;width:530px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td bgcolor=\"#eeeeee\" align=\"left\" style=\"Margin:0;padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px\">
<table style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px\" class=\"cke_show_border\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\" align=\"left\" role=\"presentation\">
<tr style=\"border-collapse:collapse\">
<td width=\"80%\" style=\"padding:0;Margin:0\"><h4 style=\"Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif\">Order Confirmation #</h4></td>
<td width=\"20%\" style=\"padding:0;Margin:0\"><h4 style=\"Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif\">2345678</h4></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0;padding-left:35px;padding-right:35px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td valign=\"top\" align=\"center\" style=\"padding:0;Margin:0;width:530px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"Margin:0;padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px\">
<table style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px\" class=\"cke_show_border\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\" align=\"left\" role=\"presentation\">
<tr style=\"border-collapse:collapse\">
<td style=\"padding:5px 10px 5px 0;Margin:0\" width=\"80%\" align=\"left\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#333333;font-size:16px\">Purchased Item (1)</p></td>
<td style=\"padding:5px 0;Margin:0\" width=\"20%\" align=\"left\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#333333;font-size:16px\">$100.00</p></td>
</tr>
<tr style=\"border-collapse:collapse\">
<td style=\"padding:5px 10px 5px 0;Margin:0\" width=\"80%\" align=\"left\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#333333;font-size:16px\">Shipping + Handling</p></td>
<td style=\"padding:5px 0;Margin:0\" width=\"20%\" align=\"left\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#333333;font-size:16px\">$10.00</p></td>
</tr>
<tr style=\"border-collapse:collapse\">
<td style=\"padding:5px 10px 5px 0;Margin:0\" width=\"80%\" align=\"left\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#333333;font-size:16px\">Sales Tax</p></td>
<td style=\"padding:5px 0;Margin:0\" width=\"20%\" align=\"left\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#333333;font-size:16px\">$5.00</p></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0;padding-top:10px;padding-left:35px;padding-right:35px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td valign=\"top\" align=\"center\" style=\"padding:0;Margin:0;width:530px\">
<table style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-top:3px solid #EEEEEE;border-bottom:3px solid #EEEEEE\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px\">
<table style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px\" class=\"cke_show_border\" cellspacing=\"1\" cellpadding=\"1\" border=\"0\" align=\"left\" role=\"presentation\">
<tr style=\"border-collapse:collapse\">
<td width=\"80%\" style=\"padding:0;Margin:0\"><h4 style=\"Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif\">TOTAL</h4></td>
<td width=\"20%\" style=\"padding:0;Margin:0\"><h4 style=\"Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif\">$115.00</h4></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"Margin:0;padding-left:35px;padding-right:35px;padding-top:40px;padding-bottom:40px\">
<!--[if mso]><table style=\"width:530px\" cellpadding=\"0\" cellspacing=\"0\"><tr><td style=\"width:255px\" valign=\"top\"><![endif]-->
<table class=\"es-left\" cellspacing=\"0\" cellpadding=\"0\" align=\"left\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left\">
<tr style=\"border-collapse:collapse\">
<td class=\"es-m-p20b\" align=\"left\" style=\"padding:0;Margin:0;width:255px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0;padding-bottom:15px\"><h4 style=\"Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif\">Delivery Address</h4></td>
</tr>
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0;padding-bottom:10px\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#333333;font-size:16px\">675 Massachusetts Avenue</p><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#333333;font-size:16px\">11th Floor</p><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#333333;font-size:16px\">Cambridge, MA 02139</p></td>
</tr>
</table></td>
</tr>
</table>
<!--[if mso]></td><td style=\"width:20px\"></td><td style=\"width:255px\" valign=\"top\"><![endif]-->
<table class=\"es-right\" cellspacing=\"0\" cellpadding=\"0\" align=\"right\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0;width:255px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0;padding-bottom:15px\"><h4 style=\"Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif\">Estimated Delivery Date<br></h4></td>
</tr>
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"padding:0;Margin:0\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:24px;color:#333333;font-size:16px\">January 1st, 2016</p></td>
</tr>
</table></td>
</tr>
</table>
<!--[if mso]></td></tr></table><![endif]--></td>
</tr>
</table></td>
</tr>
</table>";
    if ($showAds) {
      $html .= "<table class=\"es-content\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%\">
  <tr style=\"border-collapse:collapse\">
  <td align=\"center\" style=\"padding:0;Margin:0\">
  <table class=\"es-content-body\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#1B9BA3;width:600px\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#1b9ba3\" align=\"center\">
  <tr style=\"border-collapse:collapse\">
  <td align=\"left\" style=\"Margin:0;padding-top:35px;padding-bottom:35px;padding-left:35px;padding-right:35px\">
  <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
  <tr style=\"border-collapse:collapse\">
  <td valign=\"top\" align=\"center\" style=\"padding:0;Margin:0;width:530px\">
  <table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
  <tr style=\"border-collapse:collapse\">
  <td align=\"center\" style=\"padding:0;Margin:0;padding-top:25px\"><h2 style=\"Margin:0;line-height:29px;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-size:24px;font-style:normal;font-weight:bold;color:#FFFFFF\">Get 25% off your next order.</h2></td>
  </tr>
  <tr style=\"border-collapse:collapse\">
  <td align=\"center\" style=\"Margin:0;padding-left:10px;padding-right:10px;padding-bottom:15px;padding-top:30px\"><span class=\"es-button-border\" style=\"border-style:solid;border-color:transparent;background:#66B3B7;border-width:0px;display:inline-block;border-radius:5px;width:auto\"><a href=\"https://viewstripo.email/\" class=\"es-button\" target=\"_blank\" style=\"mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:18px;border-style:solid;border-color:#66B3B7;border-width:15px 30px 15px 30px;display:inline-block;background:#66B3B7;border-radius:5px;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;font-weight:normal;font-style:normal;line-height:22px;width:auto;text-align:center\">Awesome</a></span></td>
  </tr>
  </table></td>
  </tr>
  </table></td>
  </tr>
  </table></td>
  </tr>
  </table>";
    }
    $html .= "<table cellpadding=\"0\" cellspacing=\"0\" class=\"es-footer\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top\">
<tr style=\"border-collapse:collapse\">
<td align=\"center\" style=\"padding:0;Margin:0\">
<table class=\"es-footer-body\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px\">
<tr style=\"border-collapse:collapse\">
<td align=\"left\" style=\"Margin:0;padding-top:35px;padding-left:35px;padding-right:35px;padding-bottom:40px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td valign=\"top\" align=\"center\" style=\"padding:0;Margin:0;width:530px\">
<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" role=\"presentation\" style=\"mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px\">
<tr style=\"border-collapse:collapse\">
<td align=\"center\" style=\"padding:0;Margin:0;padding-bottom:15px;font-size:0\"><img src=\"https://hffwp.stripocdn.email/content/guids/CABINET_75694a6fc3c4633b3ee8e3c750851c02/images/12331522050090454.png\" alt=\"Beretun logo\" style=\"display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic\" title=\"Beretun logo\" width=\"37\"></td>
</tr>
<tr style=\"border-collapse:collapse\">
<td align=\"center\" style=\"padding:0;Margin:0;padding-bottom:35px\"><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#333333;font-size:14px\"><strong>675 Massachusetts Avenue </strong></p><p style=\"Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:'open sans', 'helvetica neue', helvetica, arial, sans-serif;line-height:21px;color:#333333;font-size:14px\"><strong>Cambridge, MA 02139</strong></p></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>

</div>
</body>
</html>";
    return $html;
  }

  public static function getPasswordResetEmailBody($name, $resetLink)
  {
    $textArray = [
      "Hi $name,",
      "Please click on the button below to set your password",
      "or copy the below link to your browser",
      "$resetLink"
    ];
    $callToAction = MailController::getCallToAction($resetLink, 'Set Password');
    $html = self::getEmailHtmlTemplate('Set Password', $textArray, $callToAction);

    return $html;
  }
}
