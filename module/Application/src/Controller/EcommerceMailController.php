<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;

class EcommerceMailController extends AbstractActionController
{
  public static function getFooter()
  {
    $html = "<!-- START FOOTER -->
    <div class=\"footer\" style=\"clear: both; Margin-top: 10px; text-align: center; width: 100%;\">
      <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;\">
        <tr>
          <td class=\"content-block\" style=\"font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;\">
            <span class=\"apple-link\" style=\"color: #999999; font-size: 12px; text-align: center;\">Company Inc, 3 Abbey Road, San Francisco CA 94102</span>
            <br> Don't like these emails? <a href=\"http://i.imgur.com/CScmqnj.gif\" style=\"text-decoration: underline; color: #999999; font-size: 12px; text-align: center;\">Unsubscribe</a>.
          </td>
        </tr>
        <tr>
          <td class=\"content-block powered-by\" style=\"font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; font-size: 12px; color: #999999; text-align: center;\">
            Powered by <a href=\"http://htmlemail.io\" style=\"color: #999999; font-size: 12px; text-align: center; text-decoration: none;\">HTMLemail</a>.
          </td>
        </tr>
      </table>
    </div>
    <!-- END FOOTER -->";
    return $html;
  }

  public static function getEmailStyles()
  {
    return " <style>
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
      .btn-primary table td:hover {
        background-color: #34495e !important;
      }
      .btn-primary a:hover {
        background-color: #34495e !important;
        border-color: #34495e !important;
      }
    }
    </style>";
  }

  public static function getCallToAction()
  {
    return "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"btn btn-primary\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box;\">
    <tbody>
      <tr>
        <td align=\"left\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;\">
          <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;\">
            <tbody>
              <tr>
                <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #3498db; border-radius: 5px; text-align: center;\"> <a href=\"http://htmlemail.io\" target=\"_blank\" style=\"display: inline-block; color: #ffffff; background-color: #3498db; border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;\">Call To Action</a> </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>";
  }

  public static function getEmailLine($text)
  {
    return "<p style=\"font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 5px;\">$text</p>";
  }

  public static function createLines($arr)
  {
    $html = "";
    foreach ($arr as $row) {
      $html .= self::getEmailLine($row);
    }
    return $html;
  }

  public static function getOrderTable($items, $order)
  {
    $html =  "<table style=\"width:100%;\">
    <thead>
    <tr style=\"text-align:center;background-color: #2576ba;color: #fff;\">
        <td colspan=\"2\" style=\"padding:15px;font-size:20px;\">Order Invoice</td>
    </tr>
    </thead>
    <tbody border='1' border-collapse=\"collapse\">
    <tr>
            <td colspan=\"2\">&nbsp;</td>
        </tr>";
    foreach ($items as $item) {
      $html .= "
        <tr>
            <td><b>" . $item->qty . " X </b> " . $item->name . "</td>
            <td align=\"right\">" . number_format(floatval($item->qty) * floatval($item->price)) . " LBP</td>
        </tr>";
    }
    $html .= "<tr>
            <td colspan=\"2\">&nbsp;</td>
        </tr>
        <tr>
            <td style=\"font-weight:bold;\">Shipping</td>
            <td align=\"right\">" . number_format(floatval($order->shippingTotal)) . " LBP</td>
        </tr>
        <tr>
            <td style=\"font-weight:bold;\">Total</td>
            <td align=\"right\">" . number_format(floatval($order->netTotal)) . " LBP</td>
        </tr>
        <tr>
            <td colspan=\"2\">&nbsp;</td>
        </tr>
    </tbody>

    <tfoot>
        <tr>
            <td colspan=\"2\" style=\"font-weight:bold;\">Shipping Address</td>
            </tr>
            <tr>
            <td colspan=\"2\">Beirut, Lebanon, Haymade.</td>
            </tr>
            <tr>
            <td colspan=\"2\">&nbsp;</td>
        </tr>
        <tr>
            <td colspan=\"2\">&nbsp;</td>
        </tr>
    </tfoot>
</table>";
    return $html;
  }

  public static function getSupplierOrderTable($items)
  {
    $total = 0;
    $commission = 0;
    $html =  "<table style=\"width:100%;\">
                <thead>
                <tr style=\"text-align:center;background-color: #2576ba;color: #fff;\">
                    <td colspan=\"2\" style=\"padding:15px;font-size:20px;\">Order Invoice</td>
                </tr>
                </thead>
                <tbody border='1' border-collapse=\"collapse\">
                <tr>
                        <td colspan=\"2\">&nbsp;</td>
                    </tr>";
    foreach ($items as $item) {
      $total += floatval($item->qty) * floatval($item->price);
      $commission += floatval($item->commission);
      $html .= "<tr>
                  <td><b>" . $item->qty . " X </b> " . $item->name . "</td>
                  <td align=\"right\">" . number_format(floatval($item->qty) * floatval($item->price)) . " LBP</td>
              </tr>";
    }
    $html .= "<tr>
                  <td colspan=\"2\">&nbsp;</td>
              </tr>
              <tr>
                  <td style=\"font-weight:bold;\">Total</td>
                  <td align=\"right\">" . number_format($total) . " LBP</td>
              </tr>
              <tr>
                  <td style=\"font-weight:bold;\">Mastershop Commission</td>
                  <td align=\"right\">" . number_format($commission) . " LBP</td>
              </tr>
              <tr>
                  <td colspan=\"2\">&nbsp;</td>
              </tr>
          </tbody>

          <tfoot>
              <tr>
                  <td colspan=\"2\" style=\"font-weight:bold;\">Shipping Address</td>
              </tr>
              <tr>
                  <td colspan=\"2\">Beirut, Lebanon, Haymade.</td>
              </tr>
              <tr>
                  <td colspan=\"2\">&nbsp;</td>
              </tr>
              <tr>
                  <td colspan=\"2\">&nbsp;</td>
              </tr>
          </tfoot>
      </table>";
    return $html;
  }

  public static function getClientEmailBody($lines1, $lines2, $items, $order)
  {
    $styles = self::getEmailStyles();
    $lines1 = self::createLines($lines1);
    $lines2 = self::createLines($lines2);
    $itemsTable = self::getOrderTable($items, $order);
    $html = "<!doctype html>
            <html>
              <head>
                <meta name=\"viewport\" content=\"width=device-width\">
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
                <title>Order Invoice</title>
              $styles
              </head>
              <body class=\"\" style=\"font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                <span class=\"preheader\" style=\"color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;\">$preheader</span>
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;\">
                  <tr>
                    <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">&nbsp;</td>
                    <td class=\"container\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;\">
                      <div class=\"content\" style=\"box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;\">

                        <!-- START CENTERED WHITE CONTAINER -->
                        <table class=\"main\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;\">

                          <!-- START MAIN CONTENT AREA -->
                          <tr>
                            <td class=\"wrapper\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;\">
                              <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;\">
                                <tr>
                                  <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">
                                    $lines1
                                    $itemsTable
                                    $lines2
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>

                        <!-- END MAIN CONTENT AREA -->
                        </table>
                      <!-- END CENTERED WHITE CONTAINER -->
                      </div>
                    </td>
                    <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">&nbsp;</td>
                  </tr>
                </table>
              </body>
            </html>";
    return $html;
  }

  public static function getSupplierEmailBody($items, $order)
  {
    $linesArr1 = [
      'Hi there,',
      'A new order has been done. Order details are shown below for your reference.',
      '&nbsp;',
      '<b>Order Id: </b> #' . $order->id,
      '<b>Payment Type: </b> ' . ucfirst(str_replace('-', " ", $order->paymentType)),
    ];

    $styles = self::getEmailStyles();
    $lines1 = self::createLines($linesArr1);
    $itemsTable = self::getSupplierOrderTable($items);
    $html = "<!doctype html>
            <html>
              <head>
                <meta name=\"viewport\" content=\"width=device-width\">
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
                <title>Order Invoice</title>
              $styles
              </head>
              <body class=\"\" style=\"font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                <span class=\"preheader\" style=\"color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;\">$preheader</span>
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;\">
                  <tr>
                    <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">&nbsp;</td>
                    <td class=\"container\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;\">
                      <div class=\"content\" style=\"box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;\">

                        <!-- START CENTERED WHITE CONTAINER -->
                        <table class=\"main\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;\">

                          <!-- START MAIN CONTENT AREA -->
                          <tr>
                            <td class=\"wrapper\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;\">
                              <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;\">
                                <tr>
                                  <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">
                                    $lines1
                                    $itemsTable
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>

                        <!-- END MAIN CONTENT AREA -->
                        </table>
                      <!-- END CENTERED WHITE CONTAINER -->
                      </div>
                    </td>
                    <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">&nbsp;</td>
                  </tr>
                </table>
              </body>
            </html>";
    return $html;
  }

  public static function getAdminEmailBody($items, $order)
  {
    $linesArr1 = [
      'Hi there,',
      'A new order has been done. Order details are shown below for your reference.',
      '&nbsp;',
      '<b>Order Id: </b> #' . $order->id,
      '<b>Payment Type: </b> ' . ucfirst(str_replace('-', " ", $order->paymentType)),
    ];

    $styles = self::getEmailStyles();
    $lines1 = self::createLines($linesArr1);
    $itemsTable = self::getOrderTable($items, $order);
    $html = "<!doctype html>
            <html>
              <head>
                <meta name=\"viewport\" content=\"width=device-width\">
                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
                <title>Order Invoice</title>
              $styles
              </head>
              <body class=\"\" style=\"font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\">
                <span class=\"preheader\" style=\"color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;\">$preheader</span>
                <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;\">
                  <tr>
                    <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">&nbsp;</td>
                    <td class=\"container\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;\">
                      <div class=\"content\" style=\"box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;\">

                        <!-- START CENTERED WHITE CONTAINER -->
                        <table class=\"main\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 3px;\">

                          <!-- START MAIN CONTENT AREA -->
                          <tr>
                            <td class=\"wrapper\" style=\"font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;\">
                              <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;\">
                                <tr>
                                  <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">
                                    $lines1
                                    $itemsTable
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>

                        <!-- END MAIN CONTENT AREA -->
                        </table>
                      <!-- END CENTERED WHITE CONTAINER -->
                      </div>
                    </td>
                    <td style=\"font-family: sans-serif; font-size: 14px; vertical-align: top;\">&nbsp;</td>
                  </tr>
                </table>
              </body>
            </html>";
    return $html;
  }
}
