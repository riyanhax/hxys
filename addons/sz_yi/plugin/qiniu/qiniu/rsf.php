<?php
// 唐上美联佳网络科技有限公司(技术支持)
function Qiniu_RSF_ListPrefix($self, $bucket, $prefix = '', $marker = '', $limit = 0)
{
	global $QINIU_RSF_HOST;
	$query = array('bucket' => $bucket);

	if (!empty($prefix)) {
		$query['prefix'] = $prefix;
	}

	if (!empty($marker)) {
		$query['marker'] = $marker;
	}

	if (!empty($limit)) {
		$query['limit'] = $limit;
	}

	$url = $QINIU_RSF_HOST . '/list?' . http_build_query($query);
	list($ret, $err) = Qiniu_Client_Call($self, $url);

	if ($err !== NULL) {
		return array(NULL, '', $err);
	}

	$items = $ret['items'];

	if (empty($ret['marker'])) {
		$markerOut = '';
		$err = Qiniu_RSF_EOF;
	}
	else {
		$markerOut = $ret['marker'];
	}

	return array($items, $markerOut, $err);
}

require_once 'http.php';
define('Qiniu_RSF_EOF', 'EOF');

?>
