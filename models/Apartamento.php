<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "apartamentos".
 *
 * @property int $id
 * @property string $nombre
 * @property float $tarifa
 *
 * @property Reservas[] $reservas
 */
class Apartamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apartamentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'tarifa'], 'required'],
            [['tarifa'], 'number'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'tarifa' => 'Tarifa',
        ];
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['apartamento_id' => 'id']);
    }
}
