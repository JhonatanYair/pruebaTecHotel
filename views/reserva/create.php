<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Apartamento;
use app\models\Cliente;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Reserva */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reserva-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'apartamento_id')->dropDownList(
        ArrayHelper::map(Apartamento::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Seleccione un apartamento', 'id' => 'apartamento-select']
    ) ?>

    <?= $form->field($model, 'cliente_id')->dropDownList(
        ArrayHelper::map(Cliente::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Seleccione un cliente']
    ) ?>

    <?= $form->field($model, 'fecha_inicio')->input('date', ['id' => 'fecha-inicio']) ?>

    <?= $form->field($model, 'fecha_fin')->input('date', ['id' => 'fecha-fin']) ?>

    <div class="form-group">
        <?= Html::submitButton('Crear Reserva', ['class' => 'btn btn-success']) ?>
    </div>

    <div id="fechas-ocupadas"></div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$('#apartamento-select').on('change', function() {
    var apartamentoId = $(this).val();
    if (apartamentoId) {
        $.ajax({
            url: '{url}', // Utilizamos la función de Yii para obtener la URL
            method: 'GET', // Método de solicitud GET
            data: { apartamento_id: apartamentoId },
            success: function(data) {
                var fechasOcupadas = $('#fechas-ocupadas');
                fechasOcupadas.empty();
                if (data.length > 0) {
                    fechasOcupadas.append('<h4>Fechas Ocupadas:</h4>');
                    $.each(data, function(index, reserva) {
                        fechasOcupadas.append('<p>Desde ' + reserva.fecha_inicio + ' hasta ' + reserva.fecha_fin + '</p>');
                    });
                } else {
                    fechasOcupadas.append('<p>No hay fechas ocupadas.</p>');
                }
            },
            error: function() {
                $('#fechas-ocupadas').text('Hubo un error en la solicitud.');
            }
        });
    } else {
        $('#fechas-ocupadas').empty();
    }
});
JS;

// Sustituir '{url}' con la URL generada por Yii para el controlador y la acción
$script = str_replace('{url}', Url::to(['reserva/get-reservas']), $script);

$this->registerJs($script);
?>
