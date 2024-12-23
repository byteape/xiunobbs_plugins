<?php


function mygoldsrecord_find($cond = array(), $orderby = array(), $page = 1, $pagesize = 20)
{
	$mygoldsrecordlist = db_find('golds_record', $cond, $orderby, $page, $pagesize);
	return $mygoldsrecordlist;
}


function mygoldsrecord_find_by_uid($uid, $page = 1, $pagesize = 20)
{
	$mygoldsrecordlist = mygoldsrecord_find(array('uid' => $uid), array('record_id' => -1), $page, $pagesize);
	if (empty($mygoldsrecordlist)) return array();
	foreach ($mygoldsrecordlist as $k => $v) {
		$thread = [];
		if ($v['tran_id'] > 0) {
			$thread = thread_read($v['tid']);
		}
		$mygoldsrecordlist[$k]['thread'] = $thread;
	}
	return $mygoldsrecordlist;
}

function mygoldsrecord_count($cond = array())
{
	$n = db_count('golds_record', $cond);
	return $n;
}
