<?php

/**
 * Sample for the marketplace services page to test buying of products
 */

main();

function main()
{

	echo '<!DOCTYPE html>'.
		'<html lang="de">'.
		generateHeader().
		generateBody().'<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>'.'<script src="js/providerOrder.js"></script>'.
		'</html>';

}

/**
 * @return string
 */
function generateHeader()
{
	return '<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>onOffice Marketplace</title>
		<link rel="stylesheet" href="https://res.onoffice.de/netcore/latest/styles/bootstrap/4.0.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://res.onoffice.de/netcore/latest/styles/font-awesome/v5.0.13/css/all.css">
		<link rel="stylesheet" href="main.css">
	</head>';
}

/**
 * @return string
 */
function generateBody()
{
	$pDateTime = new DateTime();
	$pDateTime->add(new DateInterval('P1M'));
	$aboStartDate = ($pDateTime->format('Y-m').'-01');

	return '<body>
		<header class="banner">
			<div class="container">
				<div class="row">
					<div class="col-md-12 title">
						<h1>Testpartner</h1>
					</div>
				</div>
			</div>
		</header>

		<section class="container content">
			<div class="row">
				<div class="col-md-12">
					<p>Die hier angebotenen Leistungen werden direkt von unserem Kooperationspartner
						<strong>Testpartner</strong> angeboten.
						Anfallende Kosten werden von onOffice automatisch im nächsten Monatsabo abgerechnet.
						Sollten Sie mit der Leistung nicht zufrieden sein, bitten wir Sie zunächst,
						den Anbieter direkt zu kontaktieren.</p>
					<p>
						<strong>Kontakt zum Anbieter:</strong>
						<br> Testpartner, teststraße NR., PLZ Ort
						<br>
						<strong><a href="tel:+49 241 58 95 47">+49 241 58 95 47</a></strong> |
						<strong><a href="mailto:test@mail.de">test@mail.de</a></strong>
					</p>
				</div>
			</div>
		</section>

		<section class="bg-grey">
			<div class="container">

				<div class="row">
					<div class="col-md-12 headline">
						<h2>Produkte</h2>
					</div>
				</div>

				<div class="row">
					'.generateSingleProducts().'
				</div>

				<div class="row">
					<div class="col-lg-4 col-md-6 col-xs-12 teaser product-item">
						<div class="teaserimage" id="grundriss2d"></div>
						<h3 class="product-name">Kauf für Nutzerkreis</h3>
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
						Aenean commodo ligula eget dolor. Aenean massa.
						Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
						<a href="#" class="product-price" data-value="38.70"
							onclick="processOrderToonOffice(this, \'customer\');return false;">
							<i class="fas fa-shopping-cart"></i> Jetzt kaufen (38,70 €)</a>
						<a href="#" class="product-price smaller" data-value="38.70"
							onclick="processOrderToonOffice(this, \'group\');return false;">
							<i class="fas fa-user-friends"></i> Nur für meine Gruppe (3 Benutzer: 38,70 €)</a>
						<a href="#" class="product-price smaller" data-value="38.70"
							onclick="processOrderToonOffice(this, \'user\');return false;">
							<i class="fas fa-user"></i> Nur für mich (1 Benutzer:  38,70 €)</a>
					</div>

					<div class="col-lg-4 col-md-6 col-xs-12 teaser abo-item">
						<input id="abo_durationInMonth" type="hidden" value="6" />
						<input id="abo_noticePeriod" type="hidden" value="bis 3 Monate vor Vertragsende" />
						<input id="abo_automaticRenewal" type="hidden" value="6 Monate" />
						<div class="teaserimage" id="grundriss3d"></div>
						<h3 class="product-name">Abo-Modell</h3>
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
						Aenean massa.<br>Cum sociis natoque penatibus et magnis dis parturient montes, <br>
						nascetur ridiculus mus.</p>
						<a href="#" class="product-price" data-value="25.30"
							onclick="processAboOrderToonOffice(this, null);return false;">
							<i class="fas fa-redo"></i> Abo starten (25,30 € pro Monat)</a>
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-4 col-md-6 col-xs-12 teaser product-item">
						<a href="#" class="product-price"
							onclick="processTypeToonOffice(\'onOffice.service.refreshParent\');return false;">
							<i class="fas fa-redo"></i> Refresh parent</a>
					</div>

					<div class="col-lg-4 col-md-6 col-xs-12 teaser product-item">
						<a href="#" class="product-price"
							onclick="processTypeToonOffice(\'onOffice.service.refreshParentAndClose\');return false;">
							<i class="fas fa-redo"></i> Refresh parent and close</a>
					</div>

					<div class="col-lg-4 col-md-6 col-xs-12 teaser product-item">
						<a href="#" class="product-price"
							onclick="processTypeToonOffice(\'onOffice.service.closeProviderWindow\');return false;">
							<i class="fas fa-redo"></i> Close provider window</a>
					</div>
				</div>
			</div>
		</section>
	</body>';
}

/**
 * @return string
 */
function generateSingleProducts()
{
	$products = '';
	$testDescription = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. '.
		'Aenean commodo ligula eget dolor.'.
		'Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.';

	$shopProducts =
		[
			[
				'productLogo' => 'grundriss2d',
				'productName' => '2D-Grundriss',
				'productDescription' => $testDescription,
				'productPrice' => 5.50,
			],
			[
				'productLogo' => 'grundriss3d',
				'productName' => '3D-Grundriss',
				'productDescription' => $testDescription,
				'productPrice' => 14.80,
			],
			[
				'productLogo' => 'rundgang',
				'productName' => '360°-Rundgang',
				'productDescription' => $testDescription,
				'productPrice' => 25.10,
			],
		];

	foreach ($shopProducts as $productInfos)
	{
		$productPrice = $productInfos['productPrice'];

		$products .= '<div class="col-lg-4 col-md-6 col-xs-12 teaser product-item">
			<div class="teaserimage" id="'.$productInfos['productLogo'].'"></div>
			<h3 class="product-name">'.$productInfos['productName'].'</h3>
			<p>'.$productInfos['productDescription'].'</p>
			<a href="#" class="product-price" data-value="'.number_format($productPrice, 2, '.', '').'" '.
				'onclick="processOrderToonOffice(this, null);return false;"><i class="fas fa-shopping-cart"></i>'.
				' Jetzt kaufen ('.number_format($productPrice, 2, ',', '.').' €)</a>
		</div>';
	}

	return $products;
}
