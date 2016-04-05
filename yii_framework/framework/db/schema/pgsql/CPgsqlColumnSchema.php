<?php
/**
 * CPgsqlColumnSchema class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CPgsqlColumnSchema class describes the column meta data of a PostgreSQL table.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package system.db.schema.pgsql
 * @since 1.0
 */
class CPgsqlColumnSchema extends CDbColumnSchema
{

        public function typecast($value)
        {
                /*WARNING: I had to add this check:
                 * when the table column is a boolean there are problems because php 
                 * represents boolean differently and there is a misconversion
                 * with this modification it seems to work
                 */
                if(stripos($this->type,'bool')!==false || 
                   stripos($this->type,'boolean')!==false){
                   
                   if(isset($value)) 
			$lower_value = strtolower($value);
                        
                   if($value===TRUE || $value===true || $lower_value === 't' || $lower_value === 'true' ||
                           $lower_value==='y' || $lower_value==='yes' || $lower_value==='on' ||
                           $lower_value==='1' || $value===1 ) 
                        return 'true';
                   else 
                        return 'false';
                
                }
                //END OF MODIFICATION
                
                if(gettype($value)===$this->type || $value===null || 
                   $value instanceof CDbExpression)
                  return $value;
                if($value===''){ //
                        if($this->type === 'bool') //KLUDGE If it's a boolean, when there is void we return '0'
                                return '0'; //
                        else //
                                return $this->type==='string' ? '' : null;
                } //
  
                switch($this->type){
                  case 'string': return (string)$value;
                  case 'integer': return (integer)$value;
                  case 'boolean': return (boolean)$value;
                  case 'double':
                  default: return $value;
                }
        }

	/**
	 * Extracts the PHP type from DB type.
	 * @param string $dbType DB type
	 */
	protected function extractType($dbType)
	{
		if(strpos($dbType,'[')!==false || strpos($dbType,'char')!==false || strpos($dbType,'text')!==false)
			$this->type='string';
		elseif(strpos($dbType,'bool')!==false)
			$this->type='boolean';
		elseif(preg_match('/(real|float|double)/',$dbType))
			$this->type='double';
		elseif(preg_match('/(integer|oid|serial|smallint)/',$dbType))
			$this->type='integer';
		else
			$this->type='string';
	}

	/**
	 * Extracts the default value for the column.
	 * The value is typecasted to correct PHP type.
	 * @param mixed $defaultValue the default value obtained from metadata
	 */
	protected function extractDefault($defaultValue)
	{
		if($defaultValue==='true')
			$this->defaultValue=true;
		elseif($defaultValue==='false')
			$this->defaultValue=false;
		elseif(strpos($defaultValue,'nextval')===0)
			$this->defaultValue=null;
		elseif(preg_match('/^\'(.*)\'::/',$defaultValue,$matches))
			$this->defaultValue=$this->typecast(str_replace("''","'",$matches[1]));
		elseif(preg_match('/^-?\d+(\.\d*)?$/',$defaultValue,$matches))
			$this->defaultValue=$this->typecast($defaultValue);
		// else is null
	}
}
