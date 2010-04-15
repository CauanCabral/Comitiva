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

class LocaleBehavior extends ModelBehavior
{
	protected $model;
	
	private $cakeAutomagicFields = array('created', 'updated', 'modified');
	
	private $systemLang;

	public function setup(&$model, $config = array())
	{
		$this->model = $model;
		$this->settings = $config;
		
		$this->systemLang = Configure::read('Language.default');
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
							$this->__dateConvert($this->model->data[$this->model->name][$field]);
							break;
						case 'decimal':
						case 'float':
						case 'double':
							$this->__stringToFloat($this->model->data[$this->model->name][$field]);
							break;
					}
				}
			}
		}
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
	 * @return bool
	 */
	private function __dateConvert(&$value)
	{
		
		if($this->systemLang === 'pt-br')
		{
			if(preg_match('/\d{1,2}\/\d{1,2}\/\d{2,4}/', $value))
				$value = implode('-', array_reverse(explode('/', $value)));
			else if(preg_match('/\d{1,2}\-\d{1,2}\-\d{2,4}/', $value))
				$value = implode('-', array_reverse(explode('-', $value))); 
		}
		
		$dt = new DateTime($value);
		
		if($dt === FALSE)
		{
			return FALSE;
		}
		
		$value = $dt->format('Y-m-d H:i:s');
		
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