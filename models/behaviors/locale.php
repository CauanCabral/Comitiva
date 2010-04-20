<?php
/** 
 * @author Cauan Cabral - cauan@radig.com.br
 *
 * @copyright 2009-2010, Radig - Soluções em TI, www.radig.com.br
 * @license MIT
 *
 * @package Radig
 * @subpackage L10n
 * 
 * Este behavior requer PHP versão >= 5.2.4
 */

App::import('CORE', 'ConnectionManager');

class LocaleBehavior extends ModelBehavior
{
	protected $model;
	
	private $cakeAutomagicFields = array('created', 'updated', 'modified');
	
	private $typesFormat;
	
	private $systemLang;

	public function setup(&$model, $config = array())
	{
		$this->model = $model;
		$this->settings = $config;
		
		$this->systemLang = Configure::read('Language.default');
		
		$db =& ConnectionManager::getDataSource($this->model->useDbConfig);
		
		foreach($db->columns as $type => $info)
		{
			if(isset($info['format']))
				$this->typesFormat[$type] = $info['format'];
		}
	}

	public function beforeValidate(&$model)
	{	
		parent::beforeValidate($model);
		
		return $this->localizeData();
	}
	
	public function beforeSave(&$model)
	{
		parent::beforeSave($model);
		
		return $this->localizeData();
	}
	
	protected function localizeData()
	{
		$status = TRUE;
		
		// verifica se há dados setados no modelo
		if(isset($this->model->data) && !empty($this->model->data))
		{
			// varre os dados setados
			foreach($this->model->data[$this->model->name] as $field => $value)
			{
				// caso o campo esteja vazio e não tenha um array como valor
				if(!empty($value) && !is_array($value) && !in_array($field, $this->cakeAutomagicFields))
				{
					switch($this->model->_schema[$field]['type'])
					{
						case 'date':
						case 'datetime':
						case 'time':
						case 'timestamp':
							$status = ($status && $this->__dateConvert($this->model->data[$this->model->name][$field], $this->model->_schema[$field]['type']));
							break;
						case 'decimal':
						case 'float':
						case 'double':
							$status = ($status && $this->__stringToFloat($this->model->data[$this->model->name][$field]));
							break;
					}
				}
			}
		}
		
		return $status;
	}

	/**
	 * Converte uma string para um decimal localizado
	 * 
	 * @param string $value
	 * @return bool
	 */
	private function __decimalConvert(&$value)
	{
		//TODO implementar um método específico para conversão de decimais, sem depender de extensão
	}

	/**
	 * Converte uma data localizada para padrão de banco de dados (americano)
	 * 
	 * @param string $value
	 * @param string $type -> a valid schema date type, like: 'date', 'datetime', 'timestamp' or 'time'
	 * @return bool
	 */
	private function __dateConvert(&$value, $type = 'date')
	{
		if($this->systemLang === 'pt-br')
		{
			/*
			 * @FIXME remover redundância de busca de padrão
			 */
			if( preg_match('/^\d{1,2}\/\d{1,2}\/\d{2,4}/', $value) )
			{
				$value = preg_replace('/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})/', '$3-$2-$1', $value);
			}
			else if( preg_match('/^\d{1,2}\-\d{1,2}\-\d{2,4}/', $value) )
			{
				$value = preg_replace('/^(\d{1,2})\-(\d{1,2})\-(\d{2,4})/', "$3-$2-$1", $value);
			}
			
			if( $value == null )
				return FALSE;
		}
		
		$dt = new DateTime($value);
		
		if($dt === FALSE)
		{
			return FALSE;
		}
		
		$value = $dt->format($this->typesFormat[$type]);
		
		return ($value !== FALSE);
	}
	
	/**
	 * Converte uma string que representa um número em um float válido
	 * 
	 * Ex.:
	 *  '1.000.000,22' vira '1000000.22'
	 *  '1.12' continua '1.12'
	 *  '1,12' vira '1.12'
	 * 
	 * @param string $value
	 * @return bool
	 */
	private function __stringToFloat(&$value)
	{
		if(is_string($value))
		{	
			// find decimal digits
			if(preg_match('/([\.|,])([0-9]*)$/', $value, $d))
			{
				$d = $d[2];
			}
			else
			{
				// insert zero to rigth side (two for convenience)
				$d = '00';
			}
			
			// extract integer digits
			$arrTmp = preg_split('/([\.|,])([0-9]*)$/', $value);
			$i = preg_replace('/[\.|,]/', '', $arrTmp[0]);
			
			// mount the final float format
			$value = $i . '.' . $d;
			
			return !empty($value);
		}
		
		return FALSE;
	}
}
?>