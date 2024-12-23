
$hasBuy1 = $uid == $first['uid'];
$hasBuy2 = db_find_one('thread_tran_record', array('tid' => $thread['tid'], 'b_uid' => $uid));
$hasBuy3 = db_find_one('thread_tran_record', array('tid' => $thread['tid'], 's_uid' => $uid));

$hasBuy = $hasBuy1 || $hasBuy2 || $hasBuy3;

if (!$hasBuy) {

    $uinfo = db_find_one('user', array('uid' => $uid), [], ['golds']);

    $first['message'] = preg_replace('/\[buy(?:.*?)price=(\d+?)\]([\s\S]+?)\[\/buy\]/i', '<div class="content_sell">
    <h6>此段为出售的内容，购买后显示，此帖售价<b> $1 </b>金币 <a title="购买" class="fn J_post_buy J_qlogin_trigger" data-tid="' . $thread['tid'] . '" data-credit="' . $uinfo['golds'] . '" data-price="$1" data-util="金币" data-role="post">[购买]</a></h6>
</div>', $first['message']);
} else {
    $first['message'] = preg_replace(['/\[buy(.*?)\]/i', '/\[\/buy\]/i'], ['<div class="content_sell">
    <h6>此段为出售的内容,您已购买过了,以下是隐藏的内容</h6>
    <div>', '</div>
</div>'], $first['message']);
}
$first['message_fmt'] = $first['message'];
