<?php

declare(strict_types=1);

namespace app\custom\widgets\frontend\mortgage;

use Yii;
use yii\base\Widget;

class MortgageCalculator extends Widget
{
    public $template;
    public $price;

    public function __construct(
        $config = []
    ) {
        parent::__construct($config);
    }

    public function init(): void
    {
        parent::init();
    }

    public function run()
    {
        if ($this->template === null) {
            $this->template = 'default';
        }

        $percent = Yii::$app->setting->get('mortgage.percent');
        $label = Yii::$app->setting->get('mortgage.label');

        $payment_min     = Yii::$app->setting->get('mortgage.payment_min');
        $payment_max     = Yii::$app->setting->get('mortgage.payment_max');
        $payment_default = Yii::$app->setting->get('mortgage.payment_default');

        $deposit_min     = Yii::$app->setting->get('mortgage.deposit_min');
        $deposit_max     = Yii::$app->setting->get('mortgage.deposit_max');
        $deposit_default = Yii::$app->setting->get('mortgage.deposit_default');

        $price_min = Yii::$app->setting->get('mortgage.price_min');
        $price_max = Yii::$app->setting->get('mortgage.price_max');

        $deadline_min = Yii::$app->setting->get('mortgage.deadline_min');
        $deadline_max = Yii::$app->setting->get('mortgage.deadline_max');
        $deadline_default = Yii::$app->setting->get('mortgage.deadline_default');

        $rate = $this->parseRate(Yii::$app->setting->get('mortgage.rate'));
        $rate_deadline = $this->parseDeadlineRate(Yii::$app->setting->get('mortgage.rate_deadline'));
        $rate_from = Yii::$app->setting->get('mortgage.rate_from');

        $depositDefaultPrice = ($this->price * $deposit_default) / 100;

        return $this->render($this->template, [
            'percent' => $percent,
            'label' => $label,
            'payment_min' => $payment_min,
            'payment_max' => $payment_max,
            'payment_default' => $payment_default,
            'deposit_min' => $deposit_min,
            'deposit_max' => $deposit_max,
            'deposit_default' => $deposit_default,
            'price_min' => $price_min,
            'price_max' => $price_max,
            'deadline_min' => $deadline_min,
            'deadline_max' => $deadline_max,
            'deadline_default' => $deadline_default,
            'price' => $this->price,
            'depositDefaultPrice' => $depositDefaultPrice,
            'rate' => json_encode($rate),
            'rate_deadline' => json_encode($rate_deadline),
            'rate_from' => $rate_from,
        ]);
    }

    private function parseRate(string $params)
    {
        $lines = explode("\n", $params);
        if (\count($lines) === 0) {
            return false;
        }

        $result = [];
        foreach ($lines as $item) {
            [$limits, $percent] = explode(':', $item);
            if (!$limits) {
                continue;
            }

            $percent = preg_replace('/\s+/', '', $percent);

            [$from, $to] = explode('-', $limits);

            $result[] = [
                'from' => $from,
                'to' => $to,
                'percent' => $percent,
            ];
        }

        return $result;
    }

    private function parseDeadlineRate(string $params)
    {
        $lines = explode("\n", $params);
        if (\count($lines) === 0) {
            return false;
        }

        $result = [];
        foreach ($lines as $item) {
            [$years, $percent] = explode(':', $item);
            if (!$years || !$percent) {
                continue;
            }

            $percent = preg_replace('/\s+/', '', $percent);

            $result[] = [
                'term' => $years,
                'percent' => $percent,
            ];
        }

        return $result;
    }
}
