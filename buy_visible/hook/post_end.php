
if ($action == 'buy') {
    $tid = param(2);
    // 查询该帖子需要多少金币
    $thread = thread_read($tid);
    $post = post__read($thread['firstpid']);
    preg_match('/\[buy(?:.*?)price=(\d+?)\]([\s\S]+?)\[\/buy\]/i', $post['message'], $matchResult);
    $price = 0;
    if (isset($matchResult[1])) {
        $price = $matchResult[1];
    }

    // 判断当前用户金币是否够
    $buyer = user_read($uid);
    $golds = $buyer['golds'];

    $saler = user_read($thread['uid']);

    if ($price > 0 && $golds >= $price) {
        $old_buyer_golds = $buyer['golds'];
        $old_saler_golds = $saler['golds'];
        // 减少买者金币
        $b_u_re = db_update('user', ['uid' => $uid], ['golds' => $buyer['golds'] - $price]);
        // 增加卖者金币
        $s_u_re = db_update('user', ['uid' => $saler['uid']], ['golds' => $buyer['golds'] + $price]);

        if ($b_u_re && $s_u_re) {
            // 增加帖子交易记录
            $tran_id = db_create('thread_tran_record', ['tid' => $tid, 'b_uid' => $uid, 's_uid' => $saler['uid'], 'price' => $price, 'create_time' => time()]);
            if ($tran_id) {
                // 增加金币变更记录
                $b_re_id = db_create('golds_record', ['uid' => $uid, 'direction' => 0, 'number' => $price, 'type' => 3, 'tran_id' => $tran_id, 'tid' => $tid, 'create_time' => time()]);
                $s_re_id = db_create('golds_record', ['uid' => $thread['uid'], 'direction' => 1, 'number' => $price, 'type' => 4, 'tran_id' => $tran_id, 'tid' => $tid, 'create_time' => time()]);

                if ($b_re_id && $s_re_id) {
                    message(0, '购买成功');
                } else {
                    message(-1, '变更记录失败');
                }
            } else {
                message(-1, '交易记录失败');
            }
        } else {
            db_update('user', ['uid' => $uid], ['golds' => $old_buyer_golds]);
            db_update('user', ['uid' => $saler['uid']], ['golds' => $old_saler_golds]);

            message(-1, '数量变更失败');
        }
    } else {
        message(-1, '金币不够');
    }
}
