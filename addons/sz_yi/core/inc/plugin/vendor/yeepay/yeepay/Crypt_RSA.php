<?php
// 唐上美联佳网络科技有限公司(技术支持)
class Crypt_RSA
{
	public $zero;
	public $one;
	public $privateKeyFormat = CRYPT_RSA_PRIVATE_FORMAT_PKCS1;
	public $publicKeyFormat = CRYPT_RSA_PUBLIC_FORMAT_PKCS1;
	public $modulus;
	public $k;
	public $exponent;
	public $primes;
	public $exponents;
	public $coefficients;
	public $hashName;
	public $hash;
	public $hLen;
	public $sLen;
	public $mgfHash;
	public $mgfHLen;
	public $encryptionMode = CRYPT_RSA_ENCRYPTION_OAEP;
	public $signatureMode = CRYPT_RSA_SIGNATURE_PSS;
	public $publicExponent = false;
	public $password = false;
	public $components = array();
	public $current;
	public $configFile;
	public $comment = 'phpseclib-generated-key';

	public function Crypt_RSA()
	{
		$this->configFile = CRYPT_RSA_OPENSSL_CONFIG;

		if (!defined('CRYPT_RSA_MODE')) {
			switch (true) {
			case extension_loaded('openssl') && version_compare(PHP_VERSION, '4.2.0', '>=') && file_exists($this->configFile):
				define('CRYPT_RSA_MODE', CRYPT_RSA_MODE_OPENSSL);
				break;

			default:
				define('CRYPT_RSA_MODE', CRYPT_RSA_MODE_INTERNAL);
			}
		}

		$this->zero = new Math_BigInteger();
		$this->one = new Math_BigInteger(1);
		$this->hash = new Crypt_Hash('sha1');
		$this->hLen = $this->hash->getLength();
		$this->hashName = 'sha1';
		$this->mgfHash = new Crypt_Hash('sha1');
		$this->mgfHLen = $this->mgfHash->getLength();
	}

	public function createKey($bits = 1024, $timeout = false, $partial = array())
	{
		if (!defined('CRYPT_RSA_EXPONENT')) {
			define('CRYPT_RSA_EXPONENT', '65537');
		}

		if (!defined('CRYPT_RSA_SMALLEST_PRIME')) {
			define('CRYPT_RSA_SMALLEST_PRIME', 4096);
		}

		if ((CRYPT_RSA_MODE == CRYPT_RSA_MODE_OPENSSL) && (384 <= $bits) && (CRYPT_RSA_EXPONENT == 65537)) {
			$config = array();

			if (isset($this->configFile)) {
				$config['config'] = $this->configFile;
			}

			$rsa = openssl_pkey_new(array('private_key_bits' => $bits) + $config);
			openssl_pkey_export($rsa, $privatekey, NULL, $config);
			$publickey = openssl_pkey_get_details($rsa);
			$publickey = $publickey['key'];
			$privatekey = call_user_func_array(array($this, '_convertPrivateKey'), array_values($this->_parseKey($privatekey, CRYPT_RSA_PRIVATE_FORMAT_PKCS1)));
			$publickey = call_user_func_array(array($this, '_convertPublicKey'), array_values($this->_parseKey($publickey, CRYPT_RSA_PUBLIC_FORMAT_PKCS1)));

			while (openssl_error_string() !== false) {
			}

			return array('privatekey' => $privatekey, 'publickey' => $publickey, 'partialkey' => false);
		}

		static $e;

		if (!isset($e)) {
			$e = new Math_BigInteger(CRYPT_RSA_EXPONENT);
		}

		$_MinMax = $this->_generateMinMax($bits);
		$absoluteMin = $_MinMax['min'];
		$temp = $bits >> 1;

		if (CRYPT_RSA_SMALLEST_PRIME < $temp) {
			$num_primes = floor($bits / CRYPT_RSA_SMALLEST_PRIME);
			$temp = CRYPT_RSA_SMALLEST_PRIME;
		}
		else {
			$num_primes = 2;
		}

		$_MinMax = $this->_generateMinMax($temp + ($bits % $temp));
		$finalMax = $_MinMax['max'];
		$_MinMax = $this->_generateMinMax($temp + ($bits % $temp));
		$min = $_MinMax['min'];
		$max = $_MinMax['max'];
		$generator = new Math_BigInteger();
		$n = $this->one->copy();

		if (!empty($partial)) {
			extract(unserialize($partial));
		}
		else {
			$exponents = $coefficients = $primes = array();
			$lcm = array('top' => $this->one->copy(), 'bottom' => false);
		}

		$start = time();
		$i0 = count($primes) + 1;

		do {
			$i = $i0;

			while ($i <= $num_primes) {
				if ($timeout !== false) {
					$timeout -= time() - $start;
					$start = time();

					if ($timeout <= 0) {
						return array('privatekey' => '', 'publickey' => '', 'partialkey' => serialize(array('primes' => $primes, 'coefficients' => $coefficients, 'lcm' => $lcm, 'exponents' => $exponents)));
					}
				}

				if ($i == $num_primes) {
					list($min, $temp) = $absoluteMin->divide($n);

					if (!$temp->equals($this->zero)) {
						$min = $min->add($this->one);
					}

					$primes[$i] = $generator->randomPrime($min, $finalMax, $timeout);
				}
				else {
					$primes[$i] = $generator->randomPrime($min, $max, $timeout);
				}

				if ($primes[$i] === false) {
					if (1 < count($primes)) {
						$partialkey = '';
					}
					else {
						array_pop($primes);
						$partialkey = serialize(array('primes' => $primes, 'coefficients' => $coefficients, 'lcm' => $lcm, 'exponents' => $exponents));
					}

					return array('privatekey' => '', 'publickey' => '', 'partialkey' => $partialkey);
				}

				if (2 < $i) {
					$coefficients[$i] = $n->modInverse($primes[$i]);
				}

				$n = $n->multiply($primes[$i]);
				$temp = $primes[$i]->subtract($this->one);
				$lcm['top'] = $lcm['top']->multiply($temp);
				$lcm['bottom'] = $lcm['bottom'] === false ? $temp : $lcm['bottom']->gcd($temp);
				$exponents[$i] = $e->modInverse($temp);
				++$i;
			}

			list($lcm) = $lcm['top']->divide($lcm['bottom']);
			$gcd = $lcm->gcd($e);
			$i0 = 1;
		} while (!$gcd->equals($this->one));

		$d = $e->modInverse($lcm);
		$coefficients[2] = $primes[2]->modInverse($primes[1]);
		return array('privatekey' => $this->_convertPrivateKey($n, $e, $d, $primes, $exponents, $coefficients), 'publickey' => $this->_convertPublicKey($n, $e), 'partialkey' => false);
	}

	public function _convertPrivateKey($n, $e, $d, $primes, $exponents, $coefficients)
	{
		$num_primes = count($primes);
		$raw = array('version' => $num_primes == 2 ? chr(0) : chr(1), 'modulus' => $n->toBytes(true), 'publicExponent' => $e->toBytes(true), 'privateExponent' => $d->toBytes(true), 'prime1' => $primes[1]->toBytes(true), 'prime2' => $primes[2]->toBytes(true), 'exponent1' => $exponents[1]->toBytes(true), 'exponent2' => $exponents[2]->toBytes(true), 'coefficient' => $coefficients[2]->toBytes(true));

		switch ($this->privateKeyFormat) {
		case CRYPT_RSA_PRIVATE_FORMAT_XML:
			if ($num_primes != 2) {
				return false;
			}

			return "<RSAKeyValue>\r\n" . '  <Modulus>' . base64_encode($raw['modulus']) . "</Modulus>\r\n" . '  <Exponent>' . base64_encode($raw['publicExponent']) . "</Exponent>\r\n" . '  <P>' . base64_encode($raw['prime1']) . "</P>\r\n" . '  <Q>' . base64_encode($raw['prime2']) . "</Q>\r\n" . '  <DP>' . base64_encode($raw['exponent1']) . "</DP>\r\n" . '  <DQ>' . base64_encode($raw['exponent2']) . "</DQ>\r\n" . '  <InverseQ>' . base64_encode($raw['coefficient']) . "</InverseQ>\r\n" . '  <D>' . base64_encode($raw['privateExponent']) . "</D>\r\n" . '</RSAKeyValue>';
		case CRYPT_RSA_PRIVATE_FORMAT_PUTTY:
			if ($num_primes != 2) {
				return false;
			}

			$key = "PuTTY-User-Key-File-2: ssh-rsa\r\nEncryption: ";
			$encryption = (!empty($this->password) || is_string($this->password) ? 'aes256-cbc' : 'none');
			$key .= $encryption;
			$key .= "\r\nComment: " . $this->comment . "\r\n";
			$public = pack('Na*Na*Na*', strlen('ssh-rsa'), 'ssh-rsa', strlen($raw['publicExponent']), $raw['publicExponent'], strlen($raw['modulus']), $raw['modulus']);
			$source = pack('Na*Na*Na*Na*', strlen('ssh-rsa'), 'ssh-rsa', strlen($encryption), $encryption, strlen($this->comment), $this->comment, strlen($public), $public);
			$public = base64_encode($public);
			$key .= 'Public-Lines: ' . ((strlen($public) + 32) >> 6) . "\r\n";
			$key .= chunk_split($public, 64);
			$private = pack('Na*Na*Na*Na*', strlen($raw['privateExponent']), $raw['privateExponent'], strlen($raw['prime1']), $raw['prime1'], strlen($raw['prime2']), $raw['prime2'], strlen($raw['coefficient']), $raw['coefficient']);
			if (empty($this->password) && !is_string($this->password)) {
				$source .= pack('Na*', strlen($private), $private);
				$hashkey = 'putty-private-key-file-mac-key';
			}
			else {
				$private .= self::crypt_random_string(16 - (strlen($private) & 15));
				$source .= pack('Na*', strlen($private), $private);

				if (!class_exists('Crypt_AES')) {
					require_once 'Crypt/AES.php';
				}

				$sequence = 0;
				$symkey = '';

				while (strlen($symkey) < 32) {
					$temp = pack('Na*', $sequence++, $this->password);
					$symkey .= pack('H*', sha1($temp));
				}

				$symkey = substr($symkey, 0, 32);
				$crypto = new Crypt_AES();
				$crypto->setKey($symkey);
				$crypto->disablePadding();
				$private = $crypto->encrypt($private);
				$hashkey = 'putty-private-key-file-mac-key' . $this->password;
			}

			$private = base64_encode($private);
			$key .= 'Private-Lines: ' . ((strlen($private) + 32) >> 6) . "\r\n";
			$key .= chunk_split($private, 64);

			if (!class_exists('Crypt_Hash')) {
				require_once 'Crypt/Hash.php';
			}

			$hash = new Crypt_Hash('sha1');
			$hash->setKey(pack('H*', sha1($hashkey)));
			$key .= 'Private-MAC: ' . bin2hex($hash->hash($source)) . "\r\n";
			return $key;
		default:
			$components = array();

			foreach ($raw as $name => $value) {
				$components[$name] = pack('Ca*a*', CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($value)), $value);
			}

			$RSAPrivateKey = implode('', $components);

			if (2 < $num_primes) {
				$OtherPrimeInfos = '';
				$i = 3;

				while ($i <= $num_primes) {
					$OtherPrimeInfo = pack('Ca*a*', CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($primes[$i]->toBytes(true))), $primes[$i]->toBytes(true));
					$OtherPrimeInfo .= pack('Ca*a*', CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($exponents[$i]->toBytes(true))), $exponents[$i]->toBytes(true));
					$OtherPrimeInfo .= pack('Ca*a*', CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($coefficients[$i]->toBytes(true))), $coefficients[$i]->toBytes(true));
					$OtherPrimeInfos .= pack('Ca*a*', CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($OtherPrimeInfo)), $OtherPrimeInfo);
					++$i;
				}

				$RSAPrivateKey .= pack('Ca*a*', CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($OtherPrimeInfos)), $OtherPrimeInfos);
			}

			$RSAPrivateKey = pack('Ca*a*', CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($RSAPrivateKey)), $RSAPrivateKey);
			if (!empty($this->password) || is_string($this->password)) {
				$iv = self::crypt_random_string(8);
				$symkey = pack('H*', md5($this->password . $iv));
				$symkey .= substr(pack('H*', md5($symkey . $this->password . $iv)), 0, 8);

				if (!class_exists('Crypt_TripleDES')) {
					require_once 'Crypt/TripleDES.php';
				}

				$des = new Crypt_TripleDES();
				$des->setKey($symkey);
				$des->setIV($iv);
				$iv = strtoupper(bin2hex($iv));
				$RSAPrivateKey = "-----BEGIN RSA PRIVATE KEY-----\r\n" . "Proc-Type: 4,ENCRYPTED\r\n" . 'DEK-Info: DES-EDE3-CBC,' . $iv . "\r\n" . "\r\n" . chunk_split(base64_encode($des->encrypt($RSAPrivateKey)), 64) . '-----END RSA PRIVATE KEY-----';
			}
			else {
				$RSAPrivateKey = "-----BEGIN RSA PRIVATE KEY-----\r\n" . chunk_split(base64_encode($RSAPrivateKey), 64) . '-----END RSA PRIVATE KEY-----';
			}
		}

		return $RSAPrivateKey;
	}

	public function _convertPublicKey($n, $e)
	{
		$modulus = $n->toBytes(true);
		$publicExponent = $e->toBytes(true);

		switch ($this->publicKeyFormat) {
		case CRYPT_RSA_PUBLIC_FORMAT_RAW:
			return array('e' => $e->copy(), 'n' => $n->copy());
		case CRYPT_RSA_PUBLIC_FORMAT_XML:
			return "<RSAKeyValue>\r\n" . '  <Modulus>' . base64_encode($modulus) . "</Modulus>\r\n" . '  <Exponent>' . base64_encode($publicExponent) . "</Exponent>\r\n" . '</RSAKeyValue>';
		case CRYPT_RSA_PUBLIC_FORMAT_OPENSSH:
			$RSAPublicKey = pack('Na*Na*Na*', strlen('ssh-rsa'), 'ssh-rsa', strlen($publicExponent), $publicExponent, strlen($modulus), $modulus);
			$RSAPublicKey = 'ssh-rsa ' . base64_encode($RSAPublicKey) . ' ' . $this->comment;
			return $RSAPublicKey;
		default:
			$components = array('modulus' => pack('Ca*a*', CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($modulus)), $modulus), 'publicExponent' => pack('Ca*a*', CRYPT_RSA_ASN1_INTEGER, $this->_encodeLength(strlen($publicExponent)), $publicExponent));
			$RSAPublicKey = pack('Ca*a*a*', CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($components['modulus']) + strlen($components['publicExponent'])), $components['modulus'], $components['publicExponent']);

			if ($this->publicKeyFormat == CRYPT_RSA_PUBLIC_FORMAT_PKCS1) {
				$rsaOID = pack('H*', '300d06092a864886f70d0101010500');
				$RSAPublicKey = chr(0) . $RSAPublicKey;
				$RSAPublicKey = chr(3) . $this->_encodeLength(strlen($RSAPublicKey)) . $RSAPublicKey;
				$RSAPublicKey = pack('Ca*a*', CRYPT_RSA_ASN1_SEQUENCE, $this->_encodeLength(strlen($rsaOID . $RSAPublicKey)), $rsaOID . $RSAPublicKey);
			}

			$RSAPublicKey = "-----BEGIN PUBLIC KEY-----\r\n" . chunk_split(base64_encode($RSAPublicKey), 64) . '-----END PUBLIC KEY-----';
		}

		return $RSAPublicKey;
	}

	public function _parseKey($key, $type)
	{
		if (($type != CRYPT_RSA_PUBLIC_FORMAT_RAW) && !is_string($key)) {
			return false;
		}

		switch ($type) {
		case CRYPT_RSA_PUBLIC_FORMAT_RAW:
			if (!is_array($key)) {
				return false;
			}

			$components = array();

			switch (true) {
			case isset($key['e']):
				$components['publicExponent'] = $key['e']->copy();
				break;

			case isset($key['exponent']):
				$components['publicExponent'] = $key['exponent']->copy();
				break;

			case isset($key['publicExponent']):
				$components['publicExponent'] = $key['publicExponent']->copy();
				break;

			case isset($key[0]):
				$components['publicExponent'] = $key[0]->copy();
			}

			switch (true) {
			case isset($key['n']):
				$components['modulus'] = $key['n']->copy();
				break;

			case isset($key['modulo']):
				$components['modulus'] = $key['modulo']->copy();
				break;

			case isset($key['modulus']):
				$components['modulus'] = $key['modulus']->copy();
				break;

			case isset($key[1]):
				$components['modulus'] = $key[1]->copy();
			}

			return isset($components['modulus']) && isset($components['publicExponent']) ? $components : false;
		case CRYPT_RSA_PRIVATE_FORMAT_PKCS1:
		case CRYPT_RSA_PUBLIC_FORMAT_PKCS1:
			if (preg_match('#DEK-Info: (.+),(.+)#', $key, $matches)) {
				$iv = pack('H*', trim($matches[2]));
				$symkey = pack('H*', md5($this->password . substr($iv, 0, 8)));
				$symkey .= pack('H*', md5($symkey . $this->password . substr($iv, 0, 8)));
				$ciphertext = preg_replace('#.+(\\r|\\n|\\r\\n)\\1|[\\r\\n]|-.+-| #s', '', $key);
				$ciphertext = (preg_match('#^[a-zA-Z\\d/+]*={0,2}$#', $ciphertext) ? base64_decode($ciphertext) : false);

				if ($ciphertext === false) {
					$ciphertext = $key;
				}

				switch ($matches[1]) {
				case 'AES-256-CBC':
					$crypto = new Crypt_AES();
					break;

				case 'AES-128-CBC':
					$symkey = substr($symkey, 0, 16);
					$crypto = new Crypt_AES();
					break;

				case 'DES-EDE3-CFB':
					if (!class_exists('Crypt_TripleDES')) {
						require_once 'Crypt/TripleDES.php';
					}

					$crypto = new Crypt_TripleDES(CRYPT_DES_MODE_CFB);
					break;

				case 'DES-EDE3-CBC':
					if (!class_exists('Crypt_TripleDES')) {
						require_once 'Crypt/TripleDES.php';
					}

					$symkey = substr($symkey, 0, 24);
					$crypto = new Crypt_TripleDES();
					break;

				case 'DES-CBC':
					if (!class_exists('Crypt_DES')) {
						require_once 'Crypt/DES.php';
					}

					$crypto = new Crypt_DES();
					break;

				default:
					return false;
				}

				$crypto->setKey($symkey);
				$crypto->setIV($iv);
				$decoded = $crypto->decrypt($ciphertext);
			}
			else {
				$decoded = preg_replace('#-.+-|[\\r\\n]| #', '', $key);
				$decoded = (preg_match('#^[a-zA-Z\\d/+]*={0,2}$#', $decoded) ? base64_decode($decoded) : false);
			}

			if ($decoded !== false) {
				$key = $decoded;
			}

			$components = array();

			if (ord($this->_string_shift($key)) != CRYPT_RSA_ASN1_SEQUENCE) {
				return false;
			}

			if ($this->_decodeLength($key) != strlen($key)) {
				return false;
			}

			$tag = ord($this->_string_shift($key));
			if (($tag == CRYPT_RSA_ASN1_INTEGER) && (substr($key, 0, 3) == "\x01\x000")) {
				$this->_string_shift($key, 3);
				$tag = CRYPT_RSA_ASN1_SEQUENCE;
			}

			if ($tag == CRYPT_RSA_ASN1_SEQUENCE) {
				$this->_string_shift($key, $this->_decodeLength($key));
				$tag = ord($this->_string_shift($key));
				$this->_decodeLength($key);

				if ($tag == CRYPT_RSA_ASN1_BITSTRING) {
					$this->_string_shift($key);
				}

				if (ord($this->_string_shift($key)) != CRYPT_RSA_ASN1_SEQUENCE) {
					return false;
				}

				if ($this->_decodeLength($key) != strlen($key)) {
					return false;
				}

				$tag = ord($this->_string_shift($key));
			}

			if ($tag != CRYPT_RSA_ASN1_INTEGER) {
				return false;
			}

			$length = $this->_decodeLength($key);
			$temp = $this->_string_shift($key, $length);
			if ((strlen($temp) != 1) || (2 < ord($temp))) {
				$components['modulus'] = new Math_BigInteger($temp, 256);
				$this->_string_shift($key);
				$length = $this->_decodeLength($key);
				$components[$type == CRYPT_RSA_PUBLIC_FORMAT_PKCS1 ? 'publicExponent' : 'privateExponent'] = new Math_BigInteger($this->_string_shift($key, $length), 256);
				return $components;
			}

			if (ord($this->_string_shift($key)) != CRYPT_RSA_ASN1_INTEGER) {
				return false;
			}

			$length = $this->_decodeLength($key);
			$components['modulus'] = new Math_BigInteger($this->_string_shift($key, $length), 256);
			$this->_string_shift($key);
			$length = $this->_decodeLength($key);
			$components['publicExponent'] = new Math_BigInteger($this->_string_shift($key, $length), 256);
			$this->_string_shift($key);
			$length = $this->_decodeLength($key);
			$components['privateExponent'] = new Math_BigInteger($this->_string_shift($key, $length), 256);
			$this->_string_shift($key);
			$length = $this->_decodeLength($key);
			$components['primes'] = array(1 => new Math_BigInteger($this->_string_shift($key, $length), 256));
			$this->_string_shift($key);
			$length = $this->_decodeLength($key);
			$components['primes'][] = new Math_BigInteger($this->_string_shift($key, $length), 256);
			$this->_string_shift($key);
			$length = $this->_decodeLength($key);
			$components['exponents'] = array(1 => new Math_BigInteger($this->_string_shift($key, $length), 256));
			$this->_string_shift($key);
			$length = $this->_decodeLength($key);
			$components['exponents'][] = new Math_BigInteger($this->_string_shift($key, $length), 256);
			$this->_string_shift($key);
			$length = $this->_decodeLength($key);
			$components['coefficients'] = array(2 => new Math_BigInteger($this->_string_shift($key, $length), 256));

			if (!empty($key)) {
				if (ord($this->_string_shift($key)) != CRYPT_RSA_ASN1_SEQUENCE) {
					return false;
				}

				$this->_decodeLength($key);

				while (!empty($key)) {
					if (ord($this->_string_shift($key)) != CRYPT_RSA_ASN1_SEQUENCE) {
						return false;
					}

					$this->_decodeLength($key);
					$key = substr($key, 1);
					$length = $this->_decodeLength($key);
					$components['primes'][] = new Math_BigInteger($this->_string_shift($key, $length), 256);
					$this->_string_shift($key);
					$length = $this->_decodeLength($key);
					$components['exponents'][] = new Math_BigInteger($this->_string_shift($key, $length), 256);
					$this->_string_shift($key);
					$length = $this->_decodeLength($key);
					$components['coefficients'][] = new Math_BigInteger($this->_string_shift($key, $length), 256);
				}
			}

			return $components;
		case CRYPT_RSA_PUBLIC_FORMAT_OPENSSH:
			$parts = explode(' ', $key, 3);
			$key = (isset($parts[1]) ? base64_decode($parts[1]) : false);

			if ($key === false) {
				return false;
			}

			$comment = (isset($parts[2]) ? $parts[2] : false);
			$cleanup = substr($key, 0, 11) == "\x00\x00\x00\x07ssh-rsa";

			if (strlen($key) <= 4) {
				return false;
			}

			extract(unpack('Nlength', $this->_string_shift($key, 4)));
			$publicExponent = new Math_BigInteger($this->_string_shift($key, $length), -256);

			if (strlen($key) <= 4) {
				return false;
			}

			extract(unpack('Nlength', $this->_string_shift($key, 4)));
			$modulus = new Math_BigInteger($this->_string_shift($key, $length), -256);
			if ($cleanup && strlen($key)) {
				if (strlen($key) <= 4) {
					return false;
				}

				extract(unpack('Nlength', $this->_string_shift($key, 4)));
				$realModulus = new Math_BigInteger($this->_string_shift($key, $length), -256);
				return strlen($key) ? false : array('modulus' => $realModulus, 'publicExponent' => $modulus, 'comment' => $comment);
			}

			return strlen($key) ? false : array('modulus' => $modulus, 'publicExponent' => $publicExponent, 'comment' => $comment);
		case CRYPT_RSA_PRIVATE_FORMAT_XML:
		case CRYPT_RSA_PUBLIC_FORMAT_XML:
			$this->components = array();
			$xml = xml_parser_create('UTF-8');
			xml_set_object($xml, $this);
			xml_set_element_handler($xml, '_start_element_handler', '_stop_element_handler');
			xml_set_character_data_handler($xml, '_data_handler');

			if (!xml_parse($xml, '<xml>' . $key . '</xml>')) {
				return false;
			}

			return isset($this->components['modulus']) && isset($this->components['publicExponent']) ? $this->components : false;
		case CRYPT_RSA_PRIVATE_FORMAT_PUTTY:
			$components = array();
			$key = preg_split('#\\r\\n|\\r|\\n#', $key);
			$type = trim(preg_replace('#PuTTY-User-Key-File-2: (.+)#', '$1', $key[0]));

			if ($type != 'ssh-rsa') {
				return false;
			}

			$encryption = trim(preg_replace('#Encryption: (.+)#', '$1', $key[1]));
			$comment = trim(preg_replace('#Comment: (.+)#', '$1', $key[2]));
			$publicLength = trim(preg_replace('#Public-Lines: (\\d+)#', '$1', $key[3]));
			$public = base64_decode(implode('', array_map('trim', array_slice($key, 4, $publicLength))));
			$public = substr($public, 11);
			extract(unpack('Nlength', $this->_string_shift($public, 4)));
			$components['publicExponent'] = new Math_BigInteger($this->_string_shift($public, $length), -256);
			extract(unpack('Nlength', $this->_string_shift($public, 4)));
			$components['modulus'] = new Math_BigInteger($this->_string_shift($public, $length), -256);
			$privateLength = trim(preg_replace('#Private-Lines: (\\d+)#', '$1', $key[$publicLength + 4]));
			$private = base64_decode(implode('', array_map('trim', array_slice($key, $publicLength + 5, $privateLength))));

			switch ($encryption) {
			case 'aes256-cbc':
				if (!class_exists('Crypt_AES')) {
					require_once 'Crypt/AES.php';
				}

				$symkey = '';
				$sequence = 0;

				while (strlen($symkey) < 32) {
					$temp = pack('Na*', $sequence++, $this->password);
					$symkey .= pack('H*', sha1($temp));
				}

				$symkey = substr($symkey, 0, 32);
				$crypto = new Crypt_AES();
			default:
				if ($encryption != 'none') {
					$crypto->setKey($symkey);
					$crypto->disablePadding();
					$private = $crypto->decrypt($private);

					if ($private === false) {
						return false;
					}
				}

				extract(unpack('Nlength', $this->_string_shift($private, 4)));

				if (strlen($private) < $length) {
					return false;
				}

				$components['privateExponent'] = new Math_BigInteger($this->_string_shift($private, $length), -256);
				extract(unpack('Nlength', $this->_string_shift($private, 4)));

				if (strlen($private) < $length) {
					return false;
				}

				$components['primes'] = array(1 => new Math_BigInteger($this->_string_shift($private, $length), -256));
				extract(unpack('Nlength', $this->_string_shift($private, 4)));

				if (strlen($private) < $length) {
					return false;
				}

				$components['primes'][] = new Math_BigInteger($this->_string_shift($private, $length), -256);
				$temp = $components['primes'][1]->subtract($this->one);
				$components['exponents'] = array(1 => $components['publicExponent']->modInverse($temp));
				$temp = $components['primes'][2]->subtract($this->one);
				$components['exponents'][] = $components['publicExponent']->modInverse($temp);
				extract(unpack('Nlength', $this->_string_shift($private, 4)));

				if (strlen($private) < $length) {
					return false;
				}

				$components['coefficients'] = array(2 => new Math_BigInteger($this->_string_shift($private, $length), -256));
				return $components;
			}
		}
	}

	public function getSize()
	{
		return !isset($this->modulus) ? 0 : strlen($this->modulus->toBits());
	}

	public function _start_element_handler($parser, $name, $attribs)
	{
		switch ($name) {
		case 'MODULUS':
			$this->current = &$this->components['modulus'];
			break;

		case 'EXPONENT':
			$this->current = &$this->components['publicExponent'];
			break;

		case 'P':
			$this->current = &$this->components['primes'][1];
			break;

		case 'Q':
			$this->current = &$this->components['primes'][2];
			break;

		case 'DP':
			$this->current = &$this->components['exponents'][1];
			break;

		case 'DQ':
			$this->current = &$this->components['exponents'][2];
			break;

		case 'INVERSEQ':
			$this->current = &$this->components['coefficients'][2];
			break;

		case 'D':
			$this->current = &$this->components['privateExponent'];
			break;

		default:
			unset($this->current);
		}

		$this->current = '';
	}

	public function _stop_element_handler($parser, $name)
	{
		if ($name == 'RSAKEYVALUE') {
			return NULL;
		}

		$this->current = new Math_BigInteger(base64_decode($this->current), 256);
	}

	public function _data_handler($parser, $data)
	{
		if (!isset($this->current) || is_object($this->current)) {
			return NULL;
		}

		$this->current .= trim($data);
	}

	public function loadKey($key, $type = false)
	{
		if ($type === false) {
			$types = array(CRYPT_RSA_PUBLIC_FORMAT_RAW, CRYPT_RSA_PRIVATE_FORMAT_PKCS1, CRYPT_RSA_PRIVATE_FORMAT_XML, CRYPT_RSA_PRIVATE_FORMAT_PUTTY, CRYPT_RSA_PUBLIC_FORMAT_OPENSSH);

			foreach ($types as $type) {
				$components = $this->_parseKey($key, $type);

				if ($components !== false) {
					break;
				}
			}
		}
		else {
			$components = $this->_parseKey($key, $type);
		}

		if ($components === false) {
			return false;
		}

		if (isset($components['comment']) && ($components['comment'] !== false)) {
			$this->comment = $components['comment'];
		}

		$this->modulus = $components['modulus'];
		$this->k = strlen($this->modulus->toBytes());
		$this->exponent = isset($components['privateExponent']) ? $components['privateExponent'] : $components['publicExponent'];

		if (isset($components['primes'])) {
			$this->primes = $components['primes'];
			$this->exponents = $components['exponents'];
			$this->coefficients = $components['coefficients'];
			$this->publicExponent = $components['publicExponent'];
		}
		else {
			$this->primes = array();
			$this->exponents = array();
			$this->coefficients = array();
			$this->publicExponent = false;
		}

		return true;
	}

	public function setPassword($password = false)
	{
		$this->password = $password;
	}

	public function setPublicKey($key = false, $type = false)
	{
		if (($key === false) && !empty($this->modulus)) {
			$this->publicExponent = $this->exponent;
			return true;
		}

		if ($type === false) {
			$types = array(CRYPT_RSA_PUBLIC_FORMAT_RAW, CRYPT_RSA_PUBLIC_FORMAT_PKCS1, CRYPT_RSA_PUBLIC_FORMAT_XML, CRYPT_RSA_PUBLIC_FORMAT_OPENSSH);

			foreach ($types as $type) {
				$components = $this->_parseKey($key, $type);

				if ($components !== false) {
					break;
				}
			}
		}
		else {
			$components = $this->_parseKey($key, $type);
		}

		if ($components === false) {
			return false;
		}

		if (empty($this->modulus) || !$this->modulus->equals($components['modulus'])) {
			$this->modulus = $components['modulus'];
			$this->exponent = $this->publicExponent = $components['publicExponent'];
			return true;
		}

		$this->publicExponent = $components['publicExponent'];
		return true;
	}

	public function getPublicKey($type = CRYPT_RSA_PUBLIC_FORMAT_PKCS1)
	{
		if (empty($this->modulus) || empty($this->publicExponent)) {
			return false;
		}

		$oldFormat = $this->publicKeyFormat;
		$this->publicKeyFormat = $type;
		$temp = $this->_convertPublicKey($this->modulus, $this->publicExponent);
		$this->publicKeyFormat = $oldFormat;
		return $temp;
	}

	public function getPrivateKey($type = CRYPT_RSA_PUBLIC_FORMAT_PKCS1)
	{
		if (empty($this->primes)) {
			return false;
		}

		$oldFormat = $this->privateKeyFormat;
		$this->privateKeyFormat = $type;
		$temp = $this->_convertPrivateKey($this->modulus, $this->publicExponent, $this->exponent, $this->primes, $this->exponents, $this->coefficients);
		$this->privateKeyFormat = $oldFormat;
		return $temp;
	}

	public function _getPrivatePublicKey($mode = CRYPT_RSA_PUBLIC_FORMAT_PKCS1)
	{
		if (empty($this->modulus) || empty($this->exponent)) {
			return false;
		}

		$oldFormat = $this->publicKeyFormat;
		$this->publicKeyFormat = $mode;
		$temp = $this->_convertPublicKey($this->modulus, $this->exponent);
		$this->publicKeyFormat = $oldFormat;
		return $temp;
	}

	public function __toString()
	{
		$key = $this->getPrivateKey($this->privateKeyFormat);

		if ($key !== false) {
			return $key;
		}

		$key = $this->_getPrivatePublicKey($this->publicKeyFormat);
		return $key !== false ? $key : '';
	}

	public function _generateMinMax($bits)
	{
		$bytes = $bits >> 3;
		$min = str_repeat(chr(0), $bytes);
		$max = str_repeat(chr(255), $bytes);
		$msb = $bits & 7;

		if ($msb) {
			$min = chr(1 << ($msb - 1)) . $min;
			$max = chr((1 << $msb) - 1) . $max;
		}
		else {
			$min[0] = chr(128);
		}

		return array('min' => new Math_BigInteger($min, 256), 'max' => new Math_BigInteger($max, 256));
	}

	public function _decodeLength(&$string)
	{
		$length = ord($this->_string_shift($string));

		if ($length & 128) {
			$length &= 127;
			$temp = $this->_string_shift($string, $length);
			list(, $length) = unpack('N', substr(str_pad($temp, 4, chr(0), STR_PAD_LEFT), -4));
		}

		return $length;
	}

	public function _encodeLength($length)
	{
		if ($length <= 127) {
			return chr($length);
		}

		$temp = ltrim(pack('N', $length), chr(0));
		return pack('Ca*', 128 | strlen($temp), $temp);
	}

	public function _string_shift(&$string, $index = 1)
	{
		$substr = substr($string, 0, $index);
		$string = substr($string, $index);
		return $substr;
	}

	public function setPrivateKeyFormat($format)
	{
		$this->privateKeyFormat = $format;
	}

	public function setPublicKeyFormat($format)
	{
		$this->publicKeyFormat = $format;
	}

	public function setHash($hash)
	{
		switch ($hash) {
		case 'md2':
		case 'md5':
		case 'sha1':
		case 'sha256':
		case 'sha384':
		case 'sha512':
			$this->hash = new Crypt_Hash($hash);
			$this->hashName = $hash;
			break;

		default:
			$this->hash = new Crypt_Hash('sha1');
			$this->hashName = 'sha1';
		}

		$this->hLen = $this->hash->getLength();
	}

	public function setMGFHash($hash)
	{
		switch ($hash) {
		case 'md2':
		case 'md5':
		case 'sha1':
		case 'sha256':
		case 'sha384':
		case 'sha512':
			$this->mgfHash = new Crypt_Hash($hash);
			break;

		default:
			$this->mgfHash = new Crypt_Hash('sha1');
		}

		$this->mgfHLen = $this->mgfHash->getLength();
	}

	public function setSaltLength($sLen)
	{
		$this->sLen = $sLen;
	}

	public function _i2osp($x, $xLen)
	{
		$x = $x->toBytes();

		if ($xLen < strlen($x)) {
			user_error('Integer too large');
			return false;
		}

		return str_pad($x, $xLen, chr(0), STR_PAD_LEFT);
	}

	public function _os2ip($x)
	{
		return new Math_BigInteger($x, 256);
	}

	public function _exponentiate($x)
	{
		if (empty($this->primes) || empty($this->coefficients) || empty($this->exponents)) {
			return $x->modPow($this->exponent, $this->modulus);
		}

		$num_primes = count($this->primes);

		if (defined('CRYPT_RSA_DISABLE_BLINDING')) {
			$m_i = array(1 => $x->modPow($this->exponents[1], $this->primes[1]), 2 => $x->modPow($this->exponents[2], $this->primes[2]));
			$h = $m_i[1]->subtract($m_i[2]);
			$h = $h->multiply($this->coefficients[2]);
			list(, $h) = $h->divide($this->primes[1]);
			$m = $m_i[2]->add($h->multiply($this->primes[2]));
			$r = $this->primes[1];
			$i = 3;

			while ($i <= $num_primes) {
				$m_i = $x->modPow($this->exponents[$i], $this->primes[$i]);
				$r = $r->multiply($this->primes[$i - 1]);
				$h = $m_i->subtract($m);
				$h = $h->multiply($this->coefficients[$i]);
				list(, $h) = $h->divide($this->primes[$i]);
				$m = $m->add($r->multiply($h));
				++$i;
			}
		}
		else {
			$smallest = $this->primes[1];
			$i = 2;

			while ($i <= $num_primes) {
				if (0 < $smallest->compare($this->primes[$i])) {
					$smallest = $this->primes[$i];
				}

				++$i;
			}

			$one = new Math_BigInteger(1);
			$r = $one->random($one, $smallest->subtract($one));
			$m_i = array(1 => $this->_blind($x, $r, 1), 2 => $this->_blind($x, $r, 2));
			$h = $m_i[1]->subtract($m_i[2]);
			$h = $h->multiply($this->coefficients[2]);
			list(, $h) = $h->divide($this->primes[1]);
			$m = $m_i[2]->add($h->multiply($this->primes[2]));
			$r = $this->primes[1];
			$i = 3;

			while ($i <= $num_primes) {
				$m_i = $this->_blind($x, $r, $i);
				$r = $r->multiply($this->primes[$i - 1]);
				$h = $m_i->subtract($m);
				$h = $h->multiply($this->coefficients[$i]);
				list(, $h) = $h->divide($this->primes[$i]);
				$m = $m->add($r->multiply($h));
				++$i;
			}
		}

		return $m;
	}

	public function _blind($x, $r, $i)
	{
		$x = $x->multiply($r->modPow($this->publicExponent, $this->primes[$i]));
		$x = $x->modPow($this->exponents[$i], $this->primes[$i]);
		$r = $r->modInverse($this->primes[$i]);
		$x = $x->multiply($r);
		list(, $x) = $x->divide($this->primes[$i]);
		return $x;
	}

	public function _equals($x, $y)
	{
		if (strlen($x) != strlen($y)) {
			return false;
		}

		$result = 0;
		$i = 0;

		while ($i < strlen($x)) {
			$result |= ord($x[$i]) ^ ord($y[$i]);
			++$i;
		}

		return $result == 0;
	}

	public function _rsaep($m)
	{
		if (($m->compare($this->zero) < 0) || (0 < $m->compare($this->modulus))) {
			user_error('Message representative out of range');
			return false;
		}

		return $this->_exponentiate($m);
	}

	public function _rsadp($c)
	{
		if (($c->compare($this->zero) < 0) || (0 < $c->compare($this->modulus))) {
			user_error('Ciphertext representative out of range');
			return false;
		}

		return $this->_exponentiate($c);
	}

	public function _rsasp1($m)
	{
		if (($m->compare($this->zero) < 0) || (0 < $m->compare($this->modulus))) {
			user_error('Message representative out of range');
			return false;
		}

		return $this->_exponentiate($m);
	}

	public function _rsavp1($s)
	{
		if (($s->compare($this->zero) < 0) || (0 < $s->compare($this->modulus))) {
			user_error('Signature representative out of range');
			return false;
		}

		return $this->_exponentiate($s);
	}

	public function _mgf1($mgfSeed, $maskLen)
	{
		$t = '';
		$count = ceil($maskLen / $this->mgfHLen);
		$i = 0;

		while ($i < $count) {
			$c = pack('N', $i);
			$t .= $this->mgfHash->hash($mgfSeed . $c);
			++$i;
		}

		return substr($t, 0, $maskLen);
	}

	public function _rsaes_oaep_encrypt($m, $l = '')
	{
		$mLen = strlen($m);

		if (($this->k - (2 * $this->hLen) - 2) < $mLen) {
			user_error('Message too long');
			return false;
		}

		$lHash = $this->hash->hash($l);
		$ps = str_repeat(chr(0), $this->k - $mLen - (2 * $this->hLen) - 2);
		$db = $lHash . $ps . chr(1) . $m;
		$seed = self::crypt_random_string($this->hLen);
		$dbMask = $this->_mgf1($seed, $this->k - $this->hLen - 1);
		$maskedDB = $db ^ $dbMask;
		$seedMask = $this->_mgf1($maskedDB, $this->hLen);
		$maskedSeed = $seed ^ $seedMask;
		$em = chr(0) . $maskedSeed . $maskedDB;
		$m = $this->_os2ip($em);
		$c = $this->_rsaep($m);
		$c = $this->_i2osp($c, $this->k);
		return $c;
	}

	public function _rsaes_oaep_decrypt($c, $l = '')
	{
		if ((strlen($c) != $this->k) || ($this->k < ((2 * $this->hLen) + 2))) {
			user_error('Decryption error');
			return false;
		}

		$c = $this->_os2ip($c);
		$m = $this->_rsadp($c);

		if ($m === false) {
			user_error('Decryption error');
			return false;
		}

		$em = $this->_i2osp($m, $this->k);
		$lHash = $this->hash->hash($l);
		$y = ord($em[0]);
		$maskedSeed = substr($em, 1, $this->hLen);
		$maskedDB = substr($em, $this->hLen + 1);
		$seedMask = $this->_mgf1($maskedDB, $this->hLen);
		$seed = $maskedSeed ^ $seedMask;
		$dbMask = $this->_mgf1($seed, $this->k - $this->hLen - 1);
		$db = $maskedDB ^ $dbMask;
		$lHash2 = substr($db, 0, $this->hLen);
		$m = substr($db, $this->hLen);

		if ($lHash != $lHash2) {
			user_error('Decryption error');
			return false;
		}

		$m = ltrim($m, chr(0));

		if (ord($m[0]) != 1) {
			user_error('Decryption error');
			return false;
		}

		return substr($m, 1);
	}

	public function _rsaes_pkcs1_v1_5_encrypt($m)
	{
		$mLen = strlen($m);

		if (($this->k - 11) < $mLen) {
			user_error('Message too long');
			return false;
		}

		$psLen = $this->k - $mLen - 3;
		$ps = '';

		while (strlen($ps) != $psLen) {
			$temp = self::crypt_random_string($psLen - strlen($ps));
			$temp = str_replace("\x00", '', $temp);
			$ps .= $temp;
		}

		$type = 2;
		if (defined('CRYPT_RSA_PKCS15_COMPAT') && (!isset($this->publicExponent) || ($this->exponent !== $this->publicExponent))) {
			$type = 1;
			$ps = str_repeat("\xff", $psLen);
		}

		$em = chr(0) . chr($type) . $ps . chr(0) . $m;
		$m = $this->_os2ip($em);
		$c = $this->_rsaep($m);
		$c = $this->_i2osp($c, $this->k);
		return $c;
	}

	public function _rsaes_pkcs1_v1_5_decrypt($c)
	{
		if (strlen($c) != $this->k) {
			user_error('Decryption error');
			return false;
		}

		$c = $this->_os2ip($c);
		$m = $this->_rsadp($c);

		if ($m === false) {
			user_error('Decryption error');
			return false;
		}

		$em = $this->_i2osp($m, $this->k);
		if ((ord($em[0]) != 0) || (2 < ord($em[1]))) {
			user_error('Decryption error');
			return false;
		}

		$ps = substr($em, 2, strpos($em, chr(0), 2) - 2);
		$m = substr($em, strlen($ps) + 3);

		if (strlen($ps) < 8) {
			user_error('Decryption error');
			return false;
		}

		return $m;
	}

	public function _emsa_pss_encode($m, $emBits)
	{
		$emLen = ($emBits + 1) >> 3;
		$sLen = ($this->sLen == false ? $this->hLen : $this->sLen);
		$mHash = $this->hash->hash($m);

		if ($emLen < ($this->hLen + $sLen + 2)) {
			user_error('Encoding error');
			return false;
		}

		$salt = self::crypt_random_string($sLen);
		$m2 = "\x00\x00\x00\x00\x00\x00\x00\x00" . $mHash . $salt;
		$h = $this->hash->hash($m2);
		$ps = str_repeat(chr(0), $emLen - $sLen - $this->hLen - 2);
		$db = $ps . chr(1) . $salt;
		$dbMask = $this->_mgf1($h, $emLen - $this->hLen - 1);
		$maskedDB = $db ^ $dbMask;
		$maskedDB[0] = ~chr(255 << ($emBits & 7)) & $maskedDB[0];
		$em = $maskedDB . $h . chr(188);
		return $em;
	}

	public function _emsa_pss_verify($m, $em, $emBits)
	{
		$emLen = ($emBits + 1) >> 3;
		$sLen = ($this->sLen == false ? $this->hLen : $this->sLen);
		$mHash = $this->hash->hash($m);

		if ($emLen < ($this->hLen + $sLen + 2)) {
			return false;
		}

		if ($em[strlen($em) - 1] != chr(188)) {
			return false;
		}

		$maskedDB = substr($em, 0, 0 - $this->hLen - 1);
		$h = substr($em, 0 - $this->hLen - 1, $this->hLen);
		$temp = chr(255 << ($emBits & 7));

		if ((~$maskedDB[0] & $temp) != $temp) {
			return false;
		}

		$dbMask = $this->_mgf1($h, $emLen - $this->hLen - 1);
		$db = $maskedDB ^ $dbMask;
		$db[0] = ~chr(255 << ($emBits & 7)) & $db[0];
		$temp = $emLen - $this->hLen - $sLen - 2;
		if ((substr($db, 0, $temp) != str_repeat(chr(0), $temp)) || (ord($db[$temp]) != 1)) {
			return false;
		}

		$salt = substr($db, $temp + 1);
		$m2 = "\x00\x00\x00\x00\x00\x00\x00\x00" . $mHash . $salt;
		$h2 = $this->hash->hash($m2);
		return $this->_equals($h, $h2);
	}

	public function _rsassa_pss_sign($m)
	{
		$em = $this->_emsa_pss_encode($m, (8 * $this->k) - 1);
		$m = $this->_os2ip($em);
		$s = $this->_rsasp1($m);
		$s = $this->_i2osp($s, $this->k);
		return $s;
	}

	public function _rsassa_pss_verify($m, $s)
	{
		if (strlen($s) != $this->k) {
			user_error('Invalid signature');
			return false;
		}

		$modBits = 8 * $this->k;
		$s2 = $this->_os2ip($s);
		$m2 = $this->_rsavp1($s2);

		if ($m2 === false) {
			user_error('Invalid signature');
			return false;
		}

		$em = $this->_i2osp($m2, $modBits >> 3);

		if ($em === false) {
			user_error('Invalid signature');
			return false;
		}

		return $this->_emsa_pss_verify($m, $em, $modBits - 1);
	}

	public function _emsa_pkcs1_v1_5_encode($m, $emLen)
	{
		$h = $this->hash->hash($m);

		if ($h === false) {
			return false;
		}

		switch ($this->hashName) {
		case 'md2':
			$t = pack('H*', '3020300c06082a864886f70d020205000410');
			break;

		case 'md5':
			$t = pack('H*', '3020300c06082a864886f70d020505000410');
			break;

		case 'sha1':
			$t = pack('H*', '3021300906052b0e03021a05000414');
			break;

		case 'sha256':
			$t = pack('H*', '3031300d060960864801650304020105000420');
			break;

		case 'sha384':
			$t = pack('H*', '3041300d060960864801650304020205000430');
			break;

		case 'sha512':
			$t = pack('H*', '3051300d060960864801650304020305000440');
		}

		$t .= $h;
		$tLen = strlen($t);

		if ($emLen < ($tLen + 11)) {
			user_error('Intended encoded message length too short');
			return false;
		}

		$ps = str_repeat(chr(255), $emLen - $tLen - 3);
		$em = "\x00\x01" . $ps . "\x00" . $t;
		return $em;
	}

	public function _rsassa_pkcs1_v1_5_sign($m)
	{
		$em = $this->_emsa_pkcs1_v1_5_encode($m, $this->k);

		if ($em === false) {
			user_error('RSA modulus too short');
			return false;
		}

		$m = $this->_os2ip($em);
		$s = $this->_rsasp1($m);
		$s = $this->_i2osp($s, $this->k);
		return $s;
	}

	public function _rsassa_pkcs1_v1_5_verify($m, $s)
	{
		if (strlen($s) != $this->k) {
			user_error('Invalid signature');
			return false;
		}

		$s = $this->_os2ip($s);
		$m2 = $this->_rsavp1($s);

		if ($m2 === false) {
			user_error('Invalid signature');
			return false;
		}

		$em = $this->_i2osp($m2, $this->k);

		if ($em === false) {
			user_error('Invalid signature');
			return false;
		}

		$em2 = $this->_emsa_pkcs1_v1_5_encode($m, $this->k);

		if ($em2 === false) {
			user_error('RSA modulus too short');
			return false;
		}

		return $this->_equals($em, $em2);
	}

	public function setEncryptionMode($mode)
	{
		$this->encryptionMode = $mode;
	}

	public function setSignatureMode($mode)
	{
		$this->signatureMode = $mode;
	}

	public function setComment($comment)
	{
		$this->comment = $comment;
	}

	public function getComment()
	{
		return $this->comment;
	}

	public function encrypt($plaintext)
	{
		switch ($this->encryptionMode) {
		case CRYPT_RSA_ENCRYPTION_PKCS1:
			$length = $this->k - 11;

			if ($length <= 0) {
				return false;
			}

			$plaintext = str_split($plaintext, $length);
			$ciphertext = '';

			foreach ($plaintext as $m) {
				$ciphertext .= $this->_rsaes_pkcs1_v1_5_encrypt($m);
			}

			return $ciphertext;
		default:
			$length = $this->k - (2 * $this->hLen) - 2;

			if ($length <= 0) {
				return false;
			}

			$plaintext = str_split($plaintext, $length);
			$ciphertext = '';

			foreach ($plaintext as $m) {
				$ciphertext .= $this->_rsaes_oaep_encrypt($m);
			}
		}

		return $ciphertext;
	}

	public function decrypt($ciphertext)
	{
		if ($this->k <= 0) {
			return false;
		}

		$ciphertext = str_split($ciphertext, $this->k);
		$ciphertext[count($ciphertext) - 1] = str_pad($ciphertext[count($ciphertext) - 1], $this->k, chr(0), STR_PAD_LEFT);
		$plaintext = '';

		switch ($this->encryptionMode) {
		case CRYPT_RSA_ENCRYPTION_PKCS1:
			$decrypt = '_rsaes_pkcs1_v1_5_decrypt';
			break;

		default:
			$decrypt = '_rsaes_oaep_decrypt';
		}

		foreach ($ciphertext as $c) {
			$temp = $this->$decrypt($c);

			if ($temp === false) {
				return false;
			}

			$plaintext .= $temp;
		}

		return $plaintext;
	}

	public function sign($message)
	{
		if (empty($this->modulus) || empty($this->exponent)) {
			return false;
		}

		switch ($this->signatureMode) {
		case CRYPT_RSA_SIGNATURE_PKCS1:
			return $this->_rsassa_pkcs1_v1_5_sign($message);
		default:
		}

		return $this->_rsassa_pss_sign($message);
	}

	public function verify($message, $signature)
	{
		if (empty($this->modulus) || empty($this->exponent)) {
			return false;
		}

		switch ($this->signatureMode) {
		case CRYPT_RSA_SIGNATURE_PKCS1:
			return $this->_rsassa_pkcs1_v1_5_verify($message, $signature);
		default:
		}

		return $this->_rsassa_pss_verify($message, $signature);
	}

	static public function crypt_random_string($length)
	{
		if (CRYPT_RANDOM_IS_WINDOWS) {
			if (function_exists('mcrypt_create_iv') && function_exists('class_alias')) {
				return mcrypt_create_iv($length);
			}

			if (function_exists('openssl_random_pseudo_bytes') && version_compare(PHP_VERSION, '5.3.4', '>=')) {
				return openssl_random_pseudo_bytes($length);
			}
		}
		else {
			if (function_exists('openssl_random_pseudo_bytes')) {
				return openssl_random_pseudo_bytes($length);
			}

			static $fp = true;

			if ($fp === true) {
				$fp = @fopen('/dev/urandom', 'rb');
			}

			if (($fp !== true) && ($fp !== false)) {
				return fread($fp, $length);
			}

			if (function_exists('mcrypt_create_iv')) {
				return mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
			}
		}

		static $crypto = false;
		static $v;

		if ($crypto === false) {
			$old_session_id = session_id();
			$old_use_cookies = ini_get('session.use_cookies');
			$old_session_cache_limiter = session_cache_limiter();

			if (isset($_SESSION)) {
				$_OLD_SESSION = $_SESSION;
			}

			if ($old_session_id != '') {
				session_write_close();
			}

			session_id(1);
			ini_set('session.use_cookies', 0);
			session_cache_limiter('');
			session_start();
			$v = $seed = $_SESSION['seed'] = pack('H*', sha1(serialize($_SERVER) . serialize($_POST) . serialize($_GET) . serialize($_COOKIE) . serialize($GLOBALS) . serialize($_SESSION) . serialize($_OLD_SESSION)));

			if (!isset($_SESSION['count'])) {
				$_SESSION['count'] = 0;
			}

			++$_SESSION['count'];
			session_write_close();

			if ($old_session_id != '') {
				session_id($old_session_id);
				session_start();
				ini_set('session.use_cookies', $old_use_cookies);
				session_cache_limiter($old_session_cache_limiter);
			}
			else if (isset($_OLD_SESSION)) {
				$_SESSION = $_OLD_SESSION;
				unset($_OLD_SESSION);
			}
			else {
				unset($_SESSION);
			}

			$key = pack('H*', sha1($seed . 'A'));
			$iv = pack('H*', sha1($seed . 'C'));

			switch (true) {
			case class_exists('Crypt_AES'):
				$crypto = new Crypt_AES(CRYPT_AES_MODE_CTR);
				break;

			case class_exists('Crypt_TripleDES'):
				$crypto = new Crypt_TripleDES(CRYPT_DES_MODE_CTR);
				break;

			case class_exists('Crypt_DES'):
				$crypto = new Crypt_DES(CRYPT_DES_MODE_CTR);
				break;

			default:
				$crypto = $seed;
				return self::crypt_random_string($length);
			}

			$crypto->setKey($key);
			$crypto->setIV($iv);
			$crypto->enableContinuousBuffer();
		}

		if (is_string($crypto)) {
			$result = '';

			while (strlen($result) < $length) {
				$i = pack('H*', sha1(microtime()));
				$r = pack('H*', sha1($i ^ $v));
				$v = pack('H*', sha1($r ^ $i));
				$result .= $r;
			}

			return substr($result, 0, $length);
		}

		$result = '';

		while (strlen($result) < $length) {
			$i = $crypto->encrypt(microtime());
			$r = $crypto->encrypt($i ^ $v);
			$v = $crypto->encrypt($r ^ $i);
			$result .= $r;
		}

		return substr($result, 0, $length);
	}
}

define('CRYPT_RSA_ENCRYPTION_OAEP', 1);
define('CRYPT_RSA_ENCRYPTION_PKCS1', 2);
define('CRYPT_RSA_SIGNATURE_PSS', 1);
define('CRYPT_RSA_SIGNATURE_PKCS1', 2);
define('CRYPT_RSA_ASN1_INTEGER', 2);
define('CRYPT_RSA_ASN1_BITSTRING', 3);
define('CRYPT_RSA_ASN1_SEQUENCE', 48);
define('CRYPT_RSA_MODE_INTERNAL', 1);
define('CRYPT_RSA_MODE_OPENSSL', 2);
define('CRYPT_RSA_OPENSSL_CONFIG', dirname(__FILE__) . '/../openssl.cnf');
define('CRYPT_RSA_PRIVATE_FORMAT_PKCS1', 0);
define('CRYPT_RSA_PRIVATE_FORMAT_PUTTY', 1);
define('CRYPT_RSA_PRIVATE_FORMAT_XML', 2);
define('CRYPT_RSA_PUBLIC_FORMAT_RAW', 3);
define('CRYPT_RSA_PUBLIC_FORMAT_PKCS1_RAW', 4);
define('CRYPT_RSA_PUBLIC_FORMAT_XML', 5);
define('CRYPT_RSA_PUBLIC_FORMAT_OPENSSH', 6);
define('CRYPT_RSA_PUBLIC_FORMAT_PKCS1', 7);
define('CRYPT_RANDOM_IS_WINDOWS', strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');

?>
