$hasReply = db_find_one('post', array('tid' => $thread['tid'], 'uid' => $uid));

if (!$hasReply) {
$first['message'] = preg_replace('/\[reply\]([\s\S]+?)\[\/reply\]/i', '<div class="content_hidden">本部分内容设定了隐藏,需要回复后才能看到</div>', $first['message']);
} else {
$first['message'] = str_replace(['[reply]', '[/reply]'], ['<div class="content_hidden">
    <h6>本部分设定了隐藏,您已回复过了,以下是隐藏的内容</h6>
    <div>', '</div>
</div>'], $first['message']);
}
$first['message_fmt'] = $first['message'];