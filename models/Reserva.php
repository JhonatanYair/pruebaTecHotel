<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservas".
 *
 * @property int $id
 * @property int $apartamento_id
 * @property int $cliente_id
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $estado
 * @property string $fecha_creacion
 *
 * @property Apartamentos $apartamento
 * @property Clientes $cliente
 */
class Reserva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apartamento_id', 'cliente_id', 'fecha_inicio', 'fecha_fin'], 'required'],
            [['apartamento_id', 'cliente_id'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['apartamento_id', 'fecha_inicio', 'fecha_fin'], 'unique', 'targetAttribute' => ['apartamento_id', 'fecha_inicio', 'fecha_fin']],
            [['apartamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Apartamento::class, 'targetAttribute' => ['apartamento_id' => 'id']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['cliente_id' => 'id']],
            [['estado', 'estado'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'apartamento_id' => 'Apartamento ID',
            'cliente_id' => 'Cliente ID',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'estado' => 'Estado',
            'fecha_creacion' => 'Fecha Creacion',
        ];
    }

    /**
     * Gets query for [[Apartamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApartamento()
    {
        return $this->hasOne(Apartamento::class, ['id' => 'apartamento_id']);
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::class, ['id' => 'cliente_id']);
    }
}
