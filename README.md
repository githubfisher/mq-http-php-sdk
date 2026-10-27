# MQ HTTP PHP SDK  
Alyun MQ Documents: http://www.aliyun.com/product/ons

Aliyun MQ Console: https://ons.console.aliyun.com  

## Intall Composer

To install composer by following commands, or see [composer](https://docs.phpcomposer.com/00-intro.html)
```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```
## Install & Use

Add require to your `composer.json`
```json
{
  "require": {
     "aliyunmq/mq-http-sdk": ">=1.0.4"
  }
}
```
Use Composer to install requires
```bash
composer install
``` 

*Note: php version>=8.4, and `ext-dom` / `ext-xmlreader` extensions of php are required.*

## PHP 8.4+ 改版说明（breaking changes）

相对官方 `aliyunmq/mq-http-sdk 1.0.4`，本版本为支持 PHP 8.4/8.5 做了以下不兼容调整：

1. **生产者/消费者构造函数参数顺序调整**（可选参数 `$instanceId` 移到末尾）：
   - `MQProducer(HttpClient $client, $topicName, $instanceId = null)`
   - `MQTransProducer(HttpClient $client, $topicName, $groupId, $instanceId = null)`
   - `MQConsumer(HttpClient $client, $topicName, $consumer, $messageTag = null, $instanceId = null)`
   - 通过 `MQClient::getProducer()/getConsumer()/getTransProducer()` 调用的代码无需修改。
2. Guzzle 约束升级为 `^7.9`；`HttpClient` 构造选项不再使用 Guzzle 5 的 `defaults` 包装。
3. 全部隐式可空参数改为显式 `?Type`，修复 PHP 8.4 弃用告警；`MQException` 对 `$code` 做了 int 归一化。

## Note
1. Http consumer only support timer msg (less than 3 days), no matter the msg is produced from http or tcp protocol.
2. Order is only supported at special server cluster.

## Samples (github)

[Publish Message](https://github.com/aliyunmq/mq-http-samples/blob/master/php/Producer.php)

[Consume Message](https://github.com/aliyunmq/mq-http-samples/blob/master/php/Consumer.php)

[Transaction Message](https://github.com/aliyunmq/mq-http-samples/blob/master/php/TransProducer.php)

[Publish Order Message](https://github.com/aliyunmq/mq-http-samples/blob/master/php/OrderProducer.php)

[Consume Order Message](https://github.com/aliyunmq/mq-http-samples/blob/master/php/OrderConsumer.php)

## Samples (code.aliyun.com)

[Publish Message](https://code.aliyun.com/aliware_rocketmq/mq-http-samples/blob/master/php/Producer.php)

[Consume Message](https://code.aliyun.com/aliware_rocketmq/mq-http-samples/blob/master/php/Consumer.php)

[Transaction Message](https://code.aliyun.com/aliware_rocketmq/mq-http-samples/blob/master/php/TransProducer.php)

[Publish Order Message](https://code.aliyun.com/aliware_rocketmq/mq-http-samples/blob/master/php/OrderProducer.php)

[Consume Order Message](https://code.aliyun.com/aliware_rocketmq/mq-http-samples/blob/master/php/OrderConsumer.php)