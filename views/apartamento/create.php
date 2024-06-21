<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Apartamento $model */

$this->title = 'Crear Apartamento';
$this->params['breadcrumbs'][] = ['label' => 'Apartamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartamento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
