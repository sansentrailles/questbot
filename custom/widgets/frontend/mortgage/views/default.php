<?php declare(strict_types=1);

use app\custom\helpers\button\ButtonFactory;
use app\custom\helpers\button\ButtonHelper;

?>

<section class="section">
    <div class="mortgage">
        <div class="mortgage__inner">
            <div class="tabs" data-widget="tabs">
                <div class="tabs__title">Калькулятор ипотеки</div>

                <div class="tabs__list">
                    <div class="tabs__tab">По платежу</div>
                    <div class="tabs__tab tabs__tab_active">По стоимости квартиры</div>
                </div>

                <div class="tabs__content">
                    <div class="tabs__panel" data-widget="mortgage-payment" data-percent='<?php echo $rate_deadline; ?>'>
                        <div class="mortgage-grid">
                            <div class="mortgage-grid__inner">
                                <div class="mortgage-grid__row">
                                    <div class="mortgage-grid__item">
                                        <div class="range-slider" data-range="month-payment" data-widget="range-slider" data-min="<?php echo $payment_min; ?>" data-max="<?php echo $payment_max; ?>" data-type="single">
                                            <div class="range-slider__label">
                                                Оплата:

                                                <span class="range-slider__label-span">12 500 359</span>

                                                руб./мес.
                                            </div>

                                            <div class="range-slider__control" data-value="min"></div>
                                            <div class="range-slider__control" data-value="max"></div>

                                            <input type="hidden" data-control="value" value="<?php echo $payment_default ?? 10000; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mortgage-table">
                            <div class="mortgage-table__inner">
                                <div class="mortgage-table__col">
                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">Срок кредита</div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">Стоимость (до)</div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">Первый взнос (от)</div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">Сумма кредита</div>
                                    </div>
                                </div>

                                <div class="mortgage-table__col">
                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">10 лет</div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">
                                            <span class="mortgage-table__label-span">8 000 000</span>

                                            руб.
                                        </div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">
                                            <span class="mortgage-table__label-span">100 000</span>

                                            руб.
                                        </div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">
                                            <span class="mortgage-table__label-span">7 900 000</span>

                                            руб.
                                        </div>
                                    </div>
                                </div>

                                <div class="mortgage-table__col">
                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">15 лет</div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">
                                            <span class="mortgage-table__label-span">10 000 000</span>

                                            руб.
                                        </div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">
                                            <span class="mortgage-table__label-span">350 000</span>

                                            руб.
                                        </div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">
                                            <span class="mortgage-table__label-span">9 750 000</span>

                                            руб.
                                        </div>
                                    </div>
                                </div>

                                <div class="mortgage-table__col">
                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">25 лет</div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">
                                            <span class="mortgage-table__label-span">12 000 000</span>

                                            руб.
                                        </div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">
                                            <span class="mortgage-table__label-span">3 630 000</span>

                                            руб.
                                        </div>
                                    </div>

                                    <div class="mortgage-table__row">
                                        <div class="mortgage-table__label">
                                            <span class="mortgage-table__label-span">8 370 000</span>

                                            руб.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tabs__panel tabs__panel_active" data-widget="mortgage-price" data-percent='<?php echo $rate; ?>'>
                        <div class="mortgage-grid">
                            <div class="mortgage-grid__inner">
                                <div class="mortgage-grid__row">
                                    <div class="mortgage-grid__item">
                                        <div class="range-slider" data-range="price" data-widget="range-slider" data-min="<?php echo $price_min; ?>" data-max="<?php echo $price_max; ?>" data-type="single">
                                            <div class="range-slider__label">
                                                Стоимость:

                                                <span class="range-slider__label-span">12 500 359</span>

                                                руб.
                                            </div>

                                            <div class="range-slider__control" data-value="min"></div>
                                            <div class="range-slider__control" data-value="max"></div>

                                            <input type="hidden" data-control="value" <?php if ($price) {?>value="<?php echo $price; ?>"<?php } ?>>
                                        </div>
                                    </div>

                                    <div class="mortgage-grid__item">
                                        <div class="range-slider" data-range="first-payment" data-widget="range-slider" data-min="<?php echo $deposit_min; ?>" data-max="<?php echo $deposit_max; ?>" data-type="single-percent" data-src-value="<?php echo $price; ?>">
                                            <div class="range-slider__label">
                                                Первый взнос:

                                                <span class="range-slider__label-span">800 000</span>

                                                руб.
                                            </div>

                                            <div class="range-slider__control" data-value="min"></div>
                                            <div class="range-slider__control" data-value="max"></div>

                                            <input type="hidden" data-control="value" value="<?php echo $depositDefaultPrice; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="mortgage-grid__row">
                                    <div class="mortgage-grid__item">
                                        <div class="range-slider" data-range="term" data-unit="year" data-widget="range-slider" data-min="<?php echo $deadline_min; ?>" data-max="<?php echo $deadline_max; ?>" data-type="single">
                                            <div class="range-slider__label">
                                                Срок кредита:

                                                <span class="range-slider__label-span">20</span>

                                                <span class="range-slider__unit">лет</span>
                                            </div>

                                            <div class="range-slider__control" data-value="min"></div>
                                            <div class="range-slider__control" data-value="max"></div>

                                            <input type="hidden" data-control="value" value="<?php echo $deadline_default ?? 1; ?>">
                                        </div>
                                    </div>

                                    <!-- <div class="mortgage-grid__item">
                                        <div class="range-slider" data-widget="range-slider" data-min="0" data-max="450000" data-type="single">
                                            <div class="range-slider__label">
                                                Материнский капитал:

                                                <span class="range-slider__label-span">280 040</span>

                                                руб.
                                            </div>

                                            <div class="range-slider__control" data-value="min"></div>
                                            <div class="range-slider__control" data-value="max"></div>

                                            <input type="hidden" data-control="value">
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>

                        <div class="mortgage-total">
                            <div class="mortgage-total__inner">
                                <div class="mortgage-total__col">
                                    <div class="mortgage-total__label">
                                        Сумма кредита:

                                        <span class="mortgage-total__label-span" data-role="credit"></span>

                                        руб.
                                    </div>
                                </div>

                                <div class="mortgage-total__col">
                                    <div class="mortgage-total__label">
                                        Ставка от:

                                        <span class="mortgage-total__label-span" data-role="percent"><?php echo $rate_from; ?></span>

                                        %
                                    </div>
                                </div>

                                <div class="mortgage-total__col">
                                    <div class="mortgage-total__label">
                                        Платеж от:

                                        <span class="mortgage-total__label-span" data-role="payment"></span>

                                        руб.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mortgage__group">
                <?php echo (new ButtonFactory(ButtonHelper::BTN_MORTGAGE_CONSULT))
                    ->create(['label' => 'Заказать консультацию'], [
                        'FeedbackForm[section]' => '',
                        'FeedbackForm[section]' => 'Заявка на консультацию по ипотеке',
                    ]);
?>

                <div class="mortgage__hint"><?php echo $label; ?></div>
            </div>
        </div>
    </div>
</section>
