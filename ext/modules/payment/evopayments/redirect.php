<?php
chdir('../../../../');
  require('includes/application_top.php');

  require(DIR_WS_INCLUDES . 'application_bottom.php');
  require(DIR_WS_INCLUDES . 'modules/payment/evopayments.php');
  $payment = new evopayments();
  if($payment->get_sandbox_environment()){
      $cashier_url = $payment->payment_evopayments_test_cashier_url;
  }else{
      $cashier_url = $payment->payment_evopayments_cashier_url;
  }
  $params = array();
  $params['token'] = $HTTP_GET_VARS['token'];
  $params['integrationMode'] = $payment->get_payment_mode();
  $params['merchantId'] = trim($payment->merchant_id);
  foreach ($params as $k => $v){
      $params_string .= tep_draw_hidden_field($k,$v);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<form name="redirect" action="<?php echo $cashier_url; ?>" method="post" target="_top"><?php echo $params_string; ?>
<noscript>
  <p align="center" class="main">The transaction is being finalized. Please click continue to finalize your order.</p>
  <p align="center" class="main"><input type="submit" value="Continue" /></p>
</noscript>
</form>
<script type="text/javascript">
document.redirect.submit();
</script>
</body>
</html>
