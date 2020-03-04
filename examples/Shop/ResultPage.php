<?php

/**
 *
 * It's a sample file for the DemoShop, that handle the Results and is given as callbackurl
 *
 */

main();

/**
 *
 */

function main()
{
	printHtmlResult();
}


/**
 *
 * @param Request $pRequest
 *
 */

function printHtmlResult()
{
	$parameterTransactionid = getVariable('transactionid');
	$parameterAboid = getVariable('aboid');
	$parameterStatus = getVariable('status');
	$parameterMessage = getVariable('message');

	$title = 'Kein Status empfangen';

	switch ($parameterStatus)
	{

		case 'success':
			$title = 'Vielen Dank f&uuml;r Ihren Kauf';
			break;

		case 'error':
			$title = 'Ihre Bezahlung konnte nicht durchgef&uuml;hrt werden';
			break;

	}

	$statusCssClass = 'order-result-status_'.$parameterStatus;

	$additionalInfoHtml = '';

	if (isNotEmpty($parameterTransactionid))
	{
		$additionalInfoHtml .= '<div'.attr('class', 'order-result-transaction').'><span>TransactionId:</span>'.$parameterTransactionid.'</div>';
	}

	if (isNotEmpty($parameterAboid))
	{
		$additionalInfoHtml .= '<div'.attr('class', 'order-result-transaction').'><span>AboId:</span>'.$parameterAboid.'</div>';
	}

	if (isNotEmpty($parameterMessage))
	{
		$additionalInfoHtml .= '<div'.attr('class', 'order-result-message').'><span>Nachricht:</span>'.$parameterMessage.'</div>';
	}

	$html = '
		<html>
			<head>
				<link rel="stylesheet" href="https://res.onoffice.de/netcore/latest/styles/bootstrap/4.0.0/css/bootstrap.min.css" />
				<link rel="stylesheet" href="https://res.onoffice.de/netcore/latest/styles/font-awesome/v5.0.13/css/all.css" />
				<link rel="stylesheet" href="main.css" />
			</head>
			<body>
				<header class="banner">
					<div class="container">
						<div class="row">
							<div class="col-md-12 title"><h1>Testpartner</h1></div>
						</div>
					</div>
				</header>
				<section class="container content">
					<div class="row">
						<div class="col-md-12">
							<h2 class="'.$statusCssClass.'">'.$title.'</h2>'.
							$additionalInfoHtml.'
						</div>
					</div>
				</section>
			</body>
		</html>
		';

	echo $html;

}


/**
 *
 * @param string $value
 * @retunr bool
 *
 */

function isNotEmpty($value)
{
	return (null !== $value && '' !== trim($value));
}

/**
 *
 * @param string $name
 * @param string $value
 * @return string
 *
 */

function attr($name, $value)
{
	$attr = '';

	if ($value !== null)
	{
		$attr = ' '.$name.'="'.htmlspecialchars($value, ENT_QUOTES).'"';
	}

	return $attr;
}


/**
 *
 * @param string $name
 * @return string
 *
 */

function getVariable($name)
{
	$value = '';

	if (array_key_exists($name, $_GET))
	{
		$value = $_GET[$name];
	}
	return $value;
}