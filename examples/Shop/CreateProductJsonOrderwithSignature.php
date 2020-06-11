<?php

/**
 *
 * Used to create the JSON order based on the submitted data from AppMarketplaceDemoShop
 *
 */

main();


function main()
{
	$parameterCacheId = postVariable('parametercacheid');
	$productsTotalPrice = postVariable('productstotalprice');

	printJsonOrder($parameterCacheId, $productsTotalPrice);
}

/**
 *
 * @param string $parameterCacheId
 * @param string $productsTotalPrice
 *
 * @throws Exception
 */
function printJsonOrder($parameterCacheId, $productsTotalPrice)
{
	$products = postVariable('products');
	$abo = postVariable('abo');

	$pJsonOrder = new stdClass();

	$pJsonOrder->parametercacheid = $parameterCacheId;
	$pJsonOrder->callbackurl = 'https://www.providershop.de/MarketplaceDemoShop/ResultPage.php';

	if (!stringIsEmpty($productsTotalPrice, true))
	{
		$pJsonOrder->totalprice = number_format($productsTotalPrice, 2, '.', '');
	}

	if ($products != "")
	{
		$pJsonOrder->products = $products;
	}
	else
	{
		$pJsonOrder->abo = $abo;
	}

	$jsonOrder = jsonEncode($pJsonOrder);

	echo sign($jsonOrder, '<ProviderSecret>');
}


/**
 *
 * @param stdClass $pData
 * @return string
 *
 */
function jsonEncode($pData)
{
	return json_encode($pData, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_LINE_TERMINATORS);
}

/**
 * @param string $jsonData
 * @param string $secret
 * @return string
 *
 * @throws Exception
 */
function sign($jsonData, $secret)
{
	$jsonDecodedContent = json_decode($jsonData, true);

	$jsonDecodedContent['timestamp'] = time();

	$contentSorted = sortParameters($jsonDecodedContent);
	$jsonSignature = signJsonString($contentSorted, $secret);

	$contentSorted['signature'] = $jsonSignature;

	return jsonEncode($contentSorted);
}


/**
 * @param array $jsonContent
 * @return array
 *
 */
function sortParameters(array $jsonContent)
{
	foreach ($jsonContent as $jsonKey => $jsonValue)
	{
		if (is_array($jsonValue))
		{
			$sortedParameter = sortParameters($jsonValue);
			$jsonContent[$jsonKey] = $sortedParameter;
		}
	}

	ksort($jsonContent);

	return $jsonContent;
}

/**
 * @param array $jsonContent
 * @param string $secret
 * @return string
 *
 * @throws Exception
 */
function signJsonString(array $jsonContent, $secret)
{
	if (stringIsEmpty($secret, true))
	{
		throw new Exception('No secret is provided');
	}

	unset($jsonContent['signature']);

	$jsonQueryContent = http_build_query($jsonContent, '', '&', PHP_QUERY_RFC3986);

	$jsonSignature = hash_hmac('sha256', $jsonQueryContent, $secret);

	return $jsonSignature;
}

/**
 * @param string $value
 * @return bool
 */
function stringIsEmpty($value, $trim)
{
	return null === $value || '' === ($trim ? trim($value) : $value);
}


/**
 * @param string $name
 * @return string
 */
function postVariable($name)
{
	$value = '';

	if (array_key_exists($name, $_POST))
	{
		$value = $_POST[$name];
	}
	return $value;
}