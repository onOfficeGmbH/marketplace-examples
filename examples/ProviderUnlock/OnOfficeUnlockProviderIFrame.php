<?php

	class OnOfficeUnlockProviderIFrame
	{
		const GET_PARAMETER_TOKEN = 'apiToken';

		const GET_PARAMETER_CACHE_ID = 'parameterCacheId';

		const GET_PARAMETER_SIGNATURE = 'signature';

		const GET_PARAMETER_API_CLAIM = 'apiClaim';

		/** @var string */
		private $_getParameterToken;

		/** @var string */
		private $_getParameterCacheId;

		/** @var string */
		private $_getParameterApiClaim;

		public function __construct()
		{
			$this->_getParameterToken = $_REQUEST[self::GET_PARAMETER_TOKEN];
			$this->_getParameterCacheId = $_REQUEST[self::GET_PARAMETER_CACHE_ID];
			$this->_getParameterApiClaim = $_REQUEST[self::GET_PARAMETER_API_CLAIM];
		}

		public function createHtmlCode()
		{
			if ($this->checkSignature())
			{
				$this->printHtml();
				return;
			}      
      
      $this->printErrorMessage();
		}

		/**
		 * Just a demo function for checking the signature - contains pseudo code
		 * @return bool
		 */
		private function checkSignature()
		{
			$pCheckUrlSignature = new checkUrlSignature();

			$inUrl = "http";

			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
			{
				$inUrl = "https";
			}

			$inUrl .= "://";
			$inUrl .= $_SERVER['HTTP_HOST'];
			$inUrl .= $_SERVER['REQUEST_URI'];

			return $pCheckUrlSignature->verifySignature($inUrl, $_GET[self::GET_PARAMETER_SIGNATURE]);
		}

		private function printErrorMessage()
		{
			$html = '
	<html>
		<head></head>
		<body' . $this->attr('style', 'margin: 0;') . '>
			<label>Signatur nicht korrekt</label>
		</body>
	</html>';
			echo $html;
		}

		private function printHtml()
		{
			$cssUriOpenSans = $this->getUriPath('/gui/smart/resources/font/Open_SansFamily.css');
			$cssUri = $this->getUriPath('/gui/smart/resources/css/layout/smart/themes/marketplace/marketplaceUnlockIFrame.css');
			$jsUri = 'unlockProvider.js';
			$unlockProviderData = $this->createUnlockProviderData();
			$unlockLabelText = $this->getUnlockLabelText();
			$html = '
	<html>
		<head>
			<link' . $this->attr('rel', 'stylesheet') . $this->attr('type', 'text/css') . $this->attr('href', $cssUriOpenSans) . '>
			<link' . $this->attr('rel', 'stylesheet') . $this->attr('type', 'text/css') . $this->attr('href', $cssUri) . '>
		</head>
		<body' . $this->attr('style', 'margin: 0;') . '>
			<label' . $this->attr('class', 'api-key-label') . '>API-Key</label>
		   <div' . $this->attr('class', 'api-key-input-outer') . $this->attr('id', 'secretDiv') . '>
			   <input' . $this->attr('class', 'api-key-input') . $this->attr('name', 'secret') . $this->attr('type', 'text') . $this->attr('placeholder', 'API-key hier reinkopieren') . $this->attr('id', 'secret') . '></div><input' . $this->attr('class', 'unlock-now-button') . $this->attr('id', 'unlockButton') . $this->attr('type', 'button') . $this->attr('value', $unlockLabelText) . $this->attr('title', 'Bitte zuerst der Datenschutzerklärung zustimmen') . $this->attr('alt', 'Bitte zuerst der Datenschutzerklärung zustimmen') . $this->attr('onclick', 'unlockProvider(' . $this->json($unlockProviderData) . ')') . '
				disabled>
			<label' . $this->attr('id', 'successMessage') . $this->attr('class', 'active-label') . '>Aktiv</label>
			<div' . $this->attr('id', 'spinner') . $this->attr('class', 'unlock-load-spinner') . '></div>
		</body>
		<script ' . $this->attr('src', $jsUri) . '></script>
	</html>';
			echo $html;
		}

		/**
		 * @return array
		 */
		private function createUnlockProviderData()
		{
			$unlockProviderData = ['getParameterToken' => $this->_getParameterToken, 'getParameterCacheId' => $this->_getParameterCacheId, 'getParameterApiClaim' => $this->_getParameterApiClaim];
			return $unlockProviderData;
		}

		/**
		 * @param string $name
		 * @param string $value
		 * @return string
		 */
		private function attr($name, $value)
		{
			$attr = ($value !== null ? ' ' . $name . '="' . htmlspecialchars($value, ENT_QUOTES) . '"' : '');
			return $attr;
		}

		/**
		 * @param string $path
		 * @return string
		 */
		private function getUriPath($path)
		{
			return 'https://beta.smart.onoffice.de/smart' . $path;
		}

		/**
		 * @param mixed $variable
		 * @return string
		 */
		private function json($variable)
		{
			return json_encode($variable, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_LINE_TERMINATORS);
		}

		/**
		 * @return string
		 */
		private function getUnlockLabelText()
		{
			return 'Jetzt Freischalten';
		}
	}