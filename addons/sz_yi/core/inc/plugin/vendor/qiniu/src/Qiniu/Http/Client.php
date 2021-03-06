<?php
// 唐上美联佳网络科技有限公司(技术支持)
namespace Qiniu\Http;

final class Client
{
	static public function get($url, array $headers = array())
	{
		$request = new Request('GET', $url, $headers);
		return self::sendRequest($request);
	}

	static public function post($url, $body, array $headers = array())
	{
		$request = new Request('POST', $url, $headers, $body);
		return self::sendRequest($request);
	}

	static public function multipartPost($url, $fields, $name, $fileName, $fileBody, $mimeType = NULL, array $headers = array())
	{
		$data = array();
		$mimeBoundary = md5(microtime());

		foreach ($fields as $key => $val) {
			array_push($data, '--' . $mimeBoundary);
			array_push($data, 'Content-Disposition: form-data; name="' . $key . '"');
			array_push($data, '');
			array_push($data, $val);
		}

		array_push($data, '--' . $mimeBoundary);
		$mimeType = (empty($mimeType) ? 'application/octet-stream' : $mimeType);
		$fileName = self::escapeQuotes($fileName);
		array_push($data, 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $fileName . '"');
		array_push($data, 'Content-Type: ' . $mimeType);
		array_push($data, '');
		array_push($data, $fileBody);
		array_push($data, '--' . $mimeBoundary . '--');
		array_push($data, '');
		$body = implode("\r\n", $data);
		$contentType = 'multipart/form-data; boundary=' . $mimeBoundary;
		$headers['Content-Type'] = $contentType;
		$request = new Request('POST', $url, $headers, $body);
		return self::sendRequest($request);
	}

	static private function userAgent()
	{
		$sdkInfo = 'QiniuPHP/' . \Qiniu\Config::SDK_VER;
		$systemInfo = php_uname('s');
		$machineInfo = php_uname('m');
		$envInfo = '(' . $systemInfo . '/' . $machineInfo . ')';
		$phpVer = phpversion();
		$ua = $sdkInfo . ' ' . $envInfo . ' PHP/' . $phpVer;
		return $ua;
	}

	static private function sendRequest($request)
	{
		$t1 = microtime(true);
		$ch = curl_init();
		$options = array(CURLOPT_USERAGENT => self::userAgent(), CURLOPT_RETURNTRANSFER => true, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_HEADER => true, CURLOPT_NOBODY => false, CURLOPT_CUSTOMREQUEST => $request->method, CURLOPT_URL => $request->url);
		if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
			$options[CURLOPT_FOLLOWLOCATION] = true;
		}

		if (!empty($request->headers)) {
			$headers = array();

			foreach ($request->headers as $key => $val) {
				array_push($headers, $key . ': ' . $val);
			}

			$options[CURLOPT_HTTPHEADER] = $headers;
		}

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

		if (!empty($request->body)) {
			$options[CURLOPT_POSTFIELDS] = $request->body;
		}

		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		$t2 = microtime(true);
		$duration = round($t2 - $t1, 3);
		$ret = curl_errno($ch);

		if ($ret !== 0) {
			$r = new Response(-1, $duration, array(), null, curl_error($ch));
			curl_close($ch);
			return $r;
		}

		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = self::parseHeaders(substr($result, 0, $header_size));
		$body = substr($result, $header_size);
		curl_close($ch);
		return new Response($code, $duration, $headers, $body, null);
	}

	static private function parseHeaders($raw)
	{
		$headers = array();
		$headerLines = explode("\r\n", $raw);

		foreach ($headerLines as $line) {
			$headerLine = trim($line);
			$kv = explode(':', $headerLine);

			if (1 < count($kv)) {
				$headers[$kv[0]] = trim($kv[1]);
			}
		}

		return $headers;
	}

	static private function escapeQuotes($str)
	{
		$find = array('\\', '"');
		$replace = array('\\\\', '\\"');
		return str_replace($find, $replace, $str);
	}
}


?>
