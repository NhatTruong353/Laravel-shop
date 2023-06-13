<?php

namespace App\Utilities;

class Constant
{

    //Order
    const order_status_ReceiveOrders = 1;
    const order_status_Unconfirmed = 2;
    const order_status_Confirmed = 3;
    const order_status_Paid = 4;
    const order_status_Processing = 5;
    const order_status_Shipping = 6;
    const order_status_Finish = 7;
    const order_status_Cancel = 0;
    public static $order_status = [
        self::order_status_ReceiveOrders => 'Receive Orders',
        self::order_status_Unconfirmed => 'Unconfirmed',
        self::order_status_Confirmed => 'Confirmed',
        self::order_status_Paid => 'Paid',
        self::order_status_Processing =>'Processing',
        self::order_status_Shipping=>'Shipping',
        self::order_status_Finish=>'Finish',
        self::order_status_Cancel=>'Cancel',
    ];
    //User
    const user_level_host = 0;
    const user_level_admin = 1;
    const user_level_client = 2;
    public static $user_level = [
        self::user_level_host=>'host',
        self::user_level_admin=>'admin',
        self::user_level_client=>'client',
    ];
    //Comment
    const comment_status_hide = 0;
    const comment_status_show = 1;
    public static $comment_status = [
        self::comment_status_hide => 'Hide',
        self::comment_status_show => 'Show',
    ];
    //Coupon type
    const comment_status_fixed = 0;
    const comment_status_percent= 1;
    public static $coupon_status = [
        self::comment_status_fixed => 'Fixed',
        self::comment_status_percent => 'Percent',
    ];

}
