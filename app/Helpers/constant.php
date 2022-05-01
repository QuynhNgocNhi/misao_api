<?php

if (!defined('UNDEFINED')) define('UNDEFINED', 0);
if (!defined('YES')) define('YES', 1);
if (!defined('NO')) define('NO', 2);

if (!defined('LINK_APP_IOS')) define('LINK_APP_IOS', 'https://apps.apple.com/us/app/%E3%82%A2%E3%82%A4%E3%83%8A%E3%83%93%E3%83%88%E3%83%A9%E3%83%83%E3%82%AF/id1609036973');
if (!defined('LINK_APP_ANDROID')) define('LINK_APP_ANDROID', 'https://play.google.com/store/apps/details?id=jp.ainavi');


if (!defined('CHECK')) define('CHECK', [
    YES       => '有り',
    NO        => '無し',
]);
if (!defined('CHECK_FILTER')) define('CHECK_FILTER', [
    YES => '有り',
    NO  => '無し',
]);

if (!defined('ACTIVE')) define('ACTIVE', 1);
if (!defined('INACTIVE')) define('INACTIVE', 0);

if (!defined('BUSINESS_FORM')) define('BUSINESS_FORM', [
    1  => '運送業', //Ngành giao thông vận tải
    2  => '土木建築・建設業', //Công nghiệp xây dựng và dân dụng
    3  => '小売販売・買取業', //Kinh doanh mua / bán lẻ
    4  => '輸出業', //Kinh doanh xuất khẩu
    5  => '解体業', //Phá dỡ kinh doanh
    6  => '車検・整備業', //Kinh doanh kiểm tra và bảo dưỡng phương tiện
    7  => '板金・塗装業', //Kim loại tấm / công nghiệp sơn
    8  => 'リース業', //Cho thuê kinh doanh
    9  => 'レンタル業', //Kinh doanh cho thuê
    10 => 'その他', //khác
]);

if (!defined('CHARGE_TYPE_FORM')) define('CHARGE_TYPE_FORM', [
    1 => '運送業'
]);

if (!defined('MEDIA_IMAGE')) define('MEDIA_IMAGE', 0);
if (!defined('MEDIA_VIDEO')) define('MEDIA_VIDEO', 1);

if (!defined('PER_PAGE')) define('PER_PAGE', 10);

if (!defined('ORDER_TYPE_FORM')) define('ORDER_TYPE_FORM', [
    1 => '見積り依頼',
    2 => '来店希望',
    3 => '在庫確認',
    4 => '状態確認',
    5 => '商談申込み',
    6 => 'その他',
]);

if (!defined('ORDER_STATUS')) define('ORDER_STATUS', [
    'NO_CONTRACT' => 1,
    'CONTRACTED'  => 2,
    'SHIPPING'    => 3,
    'END'         => 4
]);

if (!defined('ORDER_STATUS_FORM')) define('ORDER_STATUS_FORM', [
    0                           => '全て',
    ORDER_STATUS['NO_CONTRACT'] => '未成約',
    ORDER_STATUS['CONTRACTED']  => '成約済み',
    ORDER_STATUS['SHIPPING']    => '配送中',
    ORDER_STATUS['END']         => '終了',
]);

if (!defined('CAR_BODY_TYPE')) define('CAR_BODY_TYPE', [
    1  => '商用バン',
    2  => 'バン車',
    3  => '冷凍バン',
    4  => '冷凍ウィング',
    5  => 'ダンプ',
    6  => '平ボディー',
    7  => 'ミキサー',
    8  => 'パッカー',
    9  => 'セルフ',
    10 => 'アームロール',
    11 => 'トラクタ',
    12 => 'トレーラ',
    13 => 'ユニック',
    14 => 'ウィング車',
]);
if (!defined('CAR_SIZE')) define('CAR_SIZE', [
    1 => '大型',
    2 => '増トン',
    3 => '中型',
    4 => '小型',
]);
if (!defined('CAR_SIZE_ANALYST')) define('CAR_SIZE_ANALYST', [
    1 => '小型',
    2 => '中型',
    5 => '増トン',
    3 => '大型',
]);
if (!defined('CAR_WEIGHT')) define('CAR_WEIGHT', [
    1 => '2t 以下',
    2 => '2t',
    3 => '3t',
    4 => '4t',
    5 => '中増t',
    6 => '10t',
    7 => '10t 超',
]);
if (!defined('CAR_MAX_WEIGHT')) define('CAR_MAX_WEIGHT', [
    1 => '〜2,000kg',
    2 => '2,001kg～3,000kg',
    3 => '3,001kg～4,500kg',
    4 => '4,501kg～5,000kg',
    5 => '5,001kg～',
]);
if (!defined('CAR_MANUFACTURE')) define('CAR_MANUFACTURE', [
    1  => '日野',
    2  => 'いすゞ',
    3  => '三菱ふそう',
    4  => '日産UD',
    5  => 'トヨタ',
    6  => '日産',
    7  => 'ホンダ',
    8  => 'マツダ',
    9  => 'スバル',
    10 => 'ダイハツ',
    11 => 'スズキ',
    12 => '三菱',
    13 => 'ベンツ',
    14 => 'ボルボ',
    15 => 'その他',
]);
if (!defined('CAR_REGISTRATION')) define('CAR_REGISTRATION', [
    1 => '検切れ',
    2 => '一時抹消',
    3 => '車検付',
    4 => '予備検',
]);
if (!defined('CAR_GEAR')) define('CAR_GEAR', [
    1  => 'オートマ',
    2  => 'マニュアル',
    3  => 'セミオートマ',
]);
if (!defined('CAR_MIRROR')) define('CAR_MIRROR', [
    1 => '調整',
    2 => 'ワイパー',
    3 => 'ウォッシャー',
    4 => 'ヒーター',
]);
if (!defined('CAR_FUEL')) define('CAR_FUEL', [
    1 => '軽油',
    2 => 'ガソリン',
    3 => 'ハイブリッド',
    4 => 'CNG',
    5 => 'LNG',
    6 => 'LPG',
    7 => '電気',
]);
if (!defined('CAR_FLOOR_MATERIAL')) define('CAR_FLOOR_MATERIAL', [
    1 => '鉄',
    2 => '木',
    3 => 'アルミ',
    4 => 'ステンレス',
    5 => 'キーストン',
    6 => 'アルミ縞板',
    7 => '鉄縞板',
    8 => '亜鉛鉄板',
    9 => 'システムフロア',
]);
if (!defined('CAR_JOIST_MATERIAL')) define('CAR_JOIST_MATERIAL', [
    1 => '鉄',
    2 => '木',
    3 => 'アルミ',
]);
if (!defined('CAR_LASHING_RAIL')) define('CAR_LASHING_RAIL', [
    1 => '1',
    2 => '2',
    3 => '3',
    4 => '4',
    5 => '5',
]);
if (!defined('CAR_SIDE_DOOR_TYPE')) define('CAR_SIDE_DOOR_TYPE', [
    1 => '開閉式',
    2 => 'スライド式',
    3 => 'サイド観音',
]);
if (!defined('CAR_SIDE_DOOR_POSITION')) define('CAR_SIDE_DOOR_POSITION', [
    1 => '左',
    2 => '右',
    3 => '前',
    4 => '後',
]);
if (!defined('CAR_TAIL_LIFT')) define('CAR_TAIL_LIFT', [
    1 => '跳ね上げ',
    2 => '格納式',
    3 => '垂直',
]);
if (!defined('CAR_FREEZER_SUB_ENGINE')) define('CAR_FREEZER_SUB_ENGINE', [
    1 => 'サブエンジン',
    2 => '直結エンジン',
]);

if (!defined('CAR_SHOCK_ABSORBER')) define('CAR_SHOCK_ABSORBER', [
    1 => '板バネ',
    2 => 'エアサス'
]);

if (!defined('CAR_TAG')) define('CAR_TAG', [
    1 => '車検',
    2 => 'PG',
    3 => '低音',
    4 => '中温',
    5 => '4WD',
    6 => 'MT',
    7 => 'AT',
    8 => 'SAT',
    9 => 'エアサス',
]);

if (!defined('CAR_FREEZING_TYPE')) define('CAR_FREEZING_TYPE', [
    1 => '低温',
    2 => '中温'
]);

if (!defined('CAR_LICENSE_TYPE')) define('CAR_LICENSE_TYPE', [
    0 => '全て',
    1 => '普通免許',
    2 => '準中型免許'
]);

if (!defined('PRICE_RANGE')) define('PRICE_RANGE', [1, 500]);

if (!defined('CONTACT_TYPE')) define('CONTACT_TYPE', [
    1 => '購入に関するお問い合わせ',
    2 => '掲載に関するお問い合わせ',
    3 => 'ログインできない',
    4 => '退会について',
    5 => 'その他',
]);

if (!defined('CAR_PRIVATE')) define('CAR_PRIVATE', 0);
if (!defined('CAR_PUBLIC')) define('CAR_PUBLIC', 1);
if (!defined('CAR_DRAFT')) define('CAR_DRAFT', 2);

if (!defined('CAR_WAITING_APPROVE')) define('CAR_WAITING_APPROVE', 1);
if (!defined('CAR_APPROVE')) define('CAR_APPROVE', 2);
if (!defined('CAR_NOT_APPROVE')) define('CAR_NOT_APPROVE', 3);

if (!defined('JAPANESE_YEAR')) define('JAPANESE_YEAR', [
    '2022' => 'R4',
    '2021' => 'R3',
    '2020' => 'R2',
    '2019' => 'R1',
    '2018' => 'H30',
    '2017' => 'H29',
    '2016' => 'H28',
    '2015' => 'H27',
    '2014' => 'H26',
    '2013' => 'H25',
    '2012' => 'H24',
    '2011' => 'H23',
    '2010' => 'H22',
    '2009' => 'H21',
    '2008' => 'H20',
    '2007' => 'H19',
    '2006' => 'H18',
    '2005' => 'H17',
    '2004' => 'H16',
    '2003' => 'H15',
    '2002' => 'H14',
    '2001' => 'H13',
    '2000' => 'H12',
    '1999' => 'H11',
    '1998' => 'H10',
    '1997' => 'H9',
    '1996' => 'H8',
    '1995' => 'H7',
    '1994' => 'H6',
    '1993' => 'H5',
    '1992' => 'H4',
    '1991' => 'H3',
    '1990' => 'H2',
    '1989' => 'H1',
]);

if (!defined('TAG_STATUS')) define('TAG_STATUS', [
    'PRIVATE' => 0,
    'PUBLIC'  => 1,
    'DRAFT'   => 2,
]);
if (!defined('TAG_STATUS_FORM')) define('TAG_STATUS_FORM', [
    TAG_STATUS['PUBLIC']  => '公開',
    TAG_STATUS['PRIVATE'] => '非公開',
    TAG_STATUS['DRAFT']=> '下書き',
]);

if (!defined('BANNER_STATUS')) define('BANNER_STATUS', [
    'PRIVATE' => 0,
    'PUBLIC'  => 1,
    'DRAFT'   => 2,
]);

if (!defined('BANNER_STATUS_FORM')) define('BANNER_STATUS_FORM', [
    BANNER_STATUS['PRIVATE'] => '非公開',
    BANNER_STATUS['PUBLIC']  => '公開',
    BANNER_STATUS['DRAFT']   => '下書き',
]);
if (!defined('FILTER_TITLE')) define('FILTER_TITLE', [
    'q'                   => 'フリーワード',
    'body_type'           => '形状',
    'size'                => 'サイズ',
    'manufacture'         => 'メーカー',
    'model_year'          => '年式',
    'km_used'             => '走行距離',
    'gear'                => 'ミッション',
    'stock_location'      => '在庫場所',
    'max_weight'          => '最大積載量',
    'has_tail_lift'       => 'パワーゲート',
    'has_high_roof'       => 'ハイルーフ',
    'has_bed'             => 'ベッド',
    'has_4wd'             => '4WD',
    'has_shock_absorber'  => 'サスペンション',
    'outside_size_length' => '外寸長さ',
    'outside_size_width'  => '外寸幅',
    'outside_size_height' => '外寸高さ',
    'inside_size_length'  => '内寸長さ',
    'inside_size_width'   => '内寸幅',
    'inside_size_height'  => '内寸高さ',
    'has_side_door'       => 'サイド扉',
    'has_freezer_standby' => '冷凍機スタンバイ',
    'freezer_sub_engine'  => '冷凍機サブエンジン',
    'has_evaporator'      => '2工バ',
    'registration'        => '免許区分',
    'price'               => '価格',
    'freezing_type'       => '冷凍タイプ',
    'license_type'        => '免許区分',
]);
if (!defined('SEARCH_HISTORY')) define('SEARCH_HISTORY', [
    'body_type'           => [
        'data'  => CAR_BODY_TYPE
    ],
    'size'                => [
        'data'  => CAR_SIZE
    ],
    'manufacture'         => [
        'data'  => CAR_MANUFACTURE
    ],
    'model_year'          => [
        'data'  => JAPANESE_YEAR
    ],
    'gear'                => [
        'data' => CAR_GEAR
    ],
    'max_weight'          => [
        'data' => CAR_MAX_WEIGHT
    ],
    'has_tail_lift'       => [
        'data' => CHECK_FILTER
    ],
    'has_high_roof'       => [
        'data' => CHECK_FILTER
    ],
    'has_bed'             => [
        'data' => CHECK_FILTER
    ],
    'has_4wd'             => [
        'data' => CHECK_FILTER
    ],
    'has_shock_absorber'  => [
        'data' => CAR_SHOCK_ABSORBER
    ],
    'has_side_door'       => [
        'data' => CHECK_FILTER
    ],
    'has_freezer_standby' => [
        'data' => CHECK_FILTER
    ],
    'has_evaporator'      => [
        'data' => CHECK_FILTER
    ],
    'registration'        => [
        'data' => CAR_REGISTRATION
    ],
    'freezing_type'       => [
        'data' => CAR_FREEZING_TYPE
    ],
    'license_type'        => [
        'data' => CAR_LICENSE_TYPE
    ],
]);

if (!defined('TYPE_BUYER')) define('TYPE_BUYER', 1);
if (!defined('TYPE_SELLER')) define('TYPE_SELLER', 2);

if (!defined('NOTIFICATION_STATUS')) define('NOTIFICATION_STATUS', [
    'PRIVATE' => 0,
    'PUBLIC'  => 1,
]);

if (!defined('NOTIFICATION_STATUS_FORM')) define('NOTIFICATION_STATUS_FORM', [
    NOTIFICATION_STATUS['PRIVATE'] => '非公開',
    NOTIFICATION_STATUS['PUBLIC']  => '公開',
]);
if (!defined('CAR_SORT')) define('CAR_SORT', [
    'price:asc'         => '価格が安い順',
    'model_year_y:desc' => '年式が新しい順',
    'km_used:asc'       => '走行距離が少ない順',
    'price:desc'        => '価格が高い順',
    'model_year_y:asc'  => '年式が古い順',
    'km_used:desc'      => '走行距離が多い順',
]);

if (!defined('PHOTO_POSITION')) define('PHOTO_POSITION', [
    1 => '前',
    2 => '後',
    3 => '箱内または床',
    4 => '横',
    5 => 'シャーシ下回り',
]);
