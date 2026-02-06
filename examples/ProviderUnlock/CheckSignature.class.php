<?php

/**
 * script to show how signature check can be made
 */
class CheckUrlSignature
{
	/**
	 * Just a demo function for checking the signature
	 * @param string $inUrl
	 * @param string $signature
	 * @return bool
	 */
	public function verifySignature($inUrl, $signature)
	{
		$queryParameters = [];

		$urlElements = parse_url($inUrl);
		$queryValue = $urlElements['query'];

		parse_str($queryValue, $queryParameters);

		unset($queryParameters['signature']);
		ksort($queryParameters);

		$portSegment = isset($urlElements['port']) ? ':' . $urlElements['port'] : '';

		$cleanSourceUrl = $urlElements['scheme'] . '://' . $urlElements['host'] . $portSegment . $urlElements['path'];
		$uriToCheck = $cleanSourceUrl . '?' . http_build_query($queryParameters);

		$checkSignature = hash_hmac('sha256', $uriToCheck, 'hier Anbietersecret einsetzen');

		return ($checkSignature === $signature);
	}
}
