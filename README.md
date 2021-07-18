PHP Enum 1.0.0
===============

# 1. composer install

```shell
composer require wgx954418992/php-enum
```

# 2. demo

```php

class OrderStatus extends \apps\enum\classier\Enum
{
    public const WAIT_PAY = ['text' => '待支付'];

    public const PAYED = ['text' => '已支付'];

    public const DELIVERING = ['text' => '配送中'];

    public const COMPLETE = ['text' => '已完成', 'display' => '待评价'];

    public const COMMENTED = ['text' => '已评价'];
}

$a = new OrderStatus(OrderStatus::WAIT_PAY);

var_dump($a->getValue());

$a->then(OrderStatus::WAIT_PAY, OrderStatus::PAYED, function () {
    var_dump('Hit WAIT_PAY,PAYED');
})
    ->then(OrderStatus::DELIVERING, function () {
        var_dump('Hit DELIVERING');
    })
    ->then(OrderStatus::COMPLETE, function () {
        var_dump('Hit COMPLETE');
    })
    ->then(OrderStatus::COMMENTED, function () {
        var_dump('Hit COMMENTED');
    })
    ->fetch();
```
