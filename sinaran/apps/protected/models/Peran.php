<?php

/**
 * This is the model class for table "role_management.peran".
 *
 * The followings are the available columns in table 'role_management.peran':
 * @property string $id_peran
 * @property string $nama_peran
 * @property string $deskripsi_peran
 * @property boolean $uflag
 * @property boolean $aflag
 */
class Peran extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'role_management.peran';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_peran, nama_peran, deskripsi_peran, uflag, aflag', 'required'),
			array('id_peran', 'length', 'max'=>45),
			array('nama_peran', 'length', 'max'=>60),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_peran, nama_peran, deskripsi_peran, uflag, aflag', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_peran' => 'Id Peran',
			'nama_peran' => 'Nama Peran',
			'deskripsi_peran' => 'Deskripsi Peran',
			'uflag' => 'Uflag',
			'aflag' => 'Aflag',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_peran',$this->id_peran,true);
		$criteria->compare('nama_peran',$this->nama_peran,true);
		$criteria->compare('deskripsi_peran',$this->deskripsi_peran,true);
		$criteria->compare('uflag',$this->uflag);
		$criteria->compare('aflag',$this->aflag);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Peran the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
