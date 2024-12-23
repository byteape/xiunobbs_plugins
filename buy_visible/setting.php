<?php

!defined('DEBUG') and exit('Access Denied.');

$action = param(3);
$type = param('type');

if (empty($action)) {

	if ($method == 'GET') {

		include _include(APP_PATH . 'plugin/buy_visible/setting.htm');
	} else {
		$uid = param('uid');
		$number = param('number');
		$remark = param('remark');

		$uinfo = db_find_one('user', array('uid' => $uid), [], ['golds']);
		if (!$uinfo) {
			message(1, '用户不存在');
		}

		if (is_numeric($uid) && is_numeric($number)) {
			if ($type > 0) {
				$arr = ['direction' => 1, 'uid' => $uid, 'number' => $number, 'type' => 1, 'create_time' => time(), 'remark' => $remark];
				$rid = db_create('golds_record', $arr);
				if ($rid > 0) {
					// 增加会员金币
					$upr = db_update('user', array('uid' => $uid), array('golds' => $uinfo['golds'] + $number));
					if ($upr > 0) {
						message(0, '充值成功');
					} else {
						db_delete('golds_record', ['record_id' => $rid]);
						message(1, '充值失败');
					}
				} else {
					message(1, '充值失败');
				}
			} else {
				if ($uinfo['golds'] - $number < 0) {
					message(1, '提现失败，该会员最多只有' . $uinfo['golds'] . '个金币');
				} else {
					$arr = ['direction' => 0, 'uid' => $uid, 'number' => $number, 'type' => 2, 'create_time' => time(), 'remark' => $remark];
					$rid = db_create('golds_record', $arr);
					if ($rid > 0) {
						// 减少会员金币
						$upr = db_update('user', array('uid' => $uid), array('golds' => $uinfo['golds'] - $number));
						if ($upr > 0) {
							message(0, '提现成功');
						} else {
							db_delete('golds_record', ['record_id' => $rid]);
							message(1, '提现失败');
						}
					} else {
						message(1, '提现失败');
					}
				}
			}
		} else {
			message(1, '请填写正确的参数');
		}
	}
}
