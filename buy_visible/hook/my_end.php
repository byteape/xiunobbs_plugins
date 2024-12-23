function get_type_title($value)
{
    $arr = ['', '充值', '提现', '购买', '出售'];
    return $arr[$value];
}

if ($action == 'goldsrecord') {

    $page = param(2, 1);
    $pagesize = 20;
    $totalnum = mygoldsrecord_count(['uid' => $uid]);

    $pagination = pagination(url('my-goldsrecord-{page}'), $totalnum, $page, $pagesize);
    $goldsRecordlist = mygoldsrecord_find_by_uid($uid, $page, $pagesize);


    include _include(APP_PATH . 'view/htm/my_goldsrecord.htm');
}