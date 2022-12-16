<?php

use yii\helpers\Html;

    $this->title = 'Квитанция';
?>

<div id = "onPrint">
        <table border="0" cellspacing="4" class="forms">
          <tbody><tr>
            <td class="left" align="left">Дата составления:</td>
            <td valign="top"><?= date('d.m.y') ?></td>
          </tr>
        </tbody></table>
       <br>
        <table border="0" cellspacing="4" class="forms">
          <tbody><tr align="left">
            <td colspan="2">
				<strong>Информация о получателе платежа:</strong><br>
			</td>
          </tr>
          <tr>
            <td class="left" align="left">Наименование получателя платежа:</td>
            <td valign="top"> ОАО "Лапа помощи"</td>
          </tr>
          <tr>
            <td class="left" align="left">ИНН получателя платежа</td>
            <td valign="top">638281947</td>
          </tr>
          <tr>
            <td class="left" align="left">Расчетный счет получателя платежа:</td>
            <td valign="top">84901563829104639584</td>
          </tr>
          <tr>
            <td class="left" align="left">БИК:</td>
			<td valign="top">3762839461</td>
            </tr>
          <tr>
            <td class="left" align="left">В банке (наименование банка): </td>
            <td valign="top">ОАО "Сбербанк"</td>
          </tr>
          <tr>
            <td class="left" align="left">Корреспондентский счет:</td>
            <td valign="top">02301547827488390211</td>
          </tr>
          <tr>
            <td class="left" align="left">Наименование платежа:</td>
            <td valign="top">Оплата услуг ветеринара</td>
          </tr>
        </tbody></table>
        <br>
        <table border="0" cellspacing="4" class="forms">
          <tbody><tr class="forms">
            <td colspan="2" align="left"><strong>Информация о плательщике:</strong></td>
          </tr>
          <tr class="forms">
            <td class="left" align="left">Номер лицевого счета (код) плательщика:</td>
            <td valign="top"><?= $client['phone'] ?></td>
          </tr>
        <tr>
            <td class="left">Плательщик (Ф.И.О.):</td>
            <td valign="top"><?= $client['fio'] ?></td>
        </tr>
        <tr>
            <td class="left">Адрес плательщика:</td>
            <td valign="top">г.Воронеж, ул.Пупкина, д.4а, кв.35</td>
        </tr>
        <tr>
            <td class="left">Сумма платежа:</td>
            <td>1250 руб.</td>
        </tr>
        </tbody></table>
        <div class = "pt-5"><?= Html::button('Печать',[
            'class' => 'btn btn-primary noPrint',
            'onclick' => 'window.print();',
        ]) ?></div>
</div>
<style>
    @media print{
        .noPrint{
            display: none;
        }
    }
</style>