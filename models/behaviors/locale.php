<?php
/* 
 * $Id$
 *
 * @author Cauan Cabral - cauan@radig.com.br
 *
 * @copyright Cauan Cabral
 * @license MIT License
 *
 * @package Radig
 * @subpackage L10n
 * @version $Rev$
 * 
 * Este behavior requer PHP versão >= 5.2.4
 * Utiliza a lib "intl", disponível no PECL - http://pecl.php.net/package/intl
 * 
 * Caso utilize PHP versão >= 5.3, ela já esta builtin (não precisa instalar nada)
 */

class LocaleBehavior extends ModelBehavior
{
	public $name = 'Locale';
	
	public $model;
	
	private $cakeAutomagicFields = array('created', 'updated');
	
	private $langs = array(
		'finalLang' => 'en_US',
		'initLang' => 'en_US'
		);

	function setup(&$Model, $config)
	{
		$this->model = $Model;
		$this->settings = $config;
		
		$lang = explode('-', Configure::read('Config.language'));
		
		if(isset($lang[1]))
		{
			$lang[1] = strtoupper($lang[1]);
		}
		
		$lang = implode('_', $lang);
		
		//verifica se é um locale "válido" pro PHP (5 caracteres)
		if(isset($lang[4]))
		{
			$this->langs['initLang'] = $lang;
		}
		else
		{
			$this->langs['initLang'] = Configure::read('Language.default_php');
		}
		
		ini_set('intl.default_locale', $this->langs['initLang']);
	}

	public function beforeValidate()
	{
		$success = TRUE;
		
		// verifica se há dados setados no modelo
		if(isset($this->model->data) && !empty($this->model->data))
		{
			// varre os dados setados
			foreach($this->model->data[$this->model->name] as $field => &$value)
			{
				// caso o campo esteja vazio e não tenha um array como valor, e ainda não seja um campo automagico do cake
				if(!empty($value) && !is_array($value) && !in_array($field, $this->cakeAutomagicFields))
				{
					switch($this->model->_schema[$field]['type'])
					{
						case 'date':
							$success = $this->__dateConvert($value);
							break;
						case 'decimal':
							$success = $this->__decimalConvert($value);
							break;
						case 'float':
						case 'double':
							$success = $this->__stringToFloat($value);
							break;
					}
				}
				
				// caso alguma conversão não seja bem sucedida, aborta o tratamento e retorna false
				if(!$success)
				{
					return FALSE;
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
		$this->__stringToFloat($value);
		
		$nf = new NumberFormatter($this->langs['finalLang'], NumberFormatter::DECIMAL);
		
		if($nf === FALSE)
		{
			return FALSE;
		}
		
		$value = $nf->format($value);
		
		return ($value !== FALSE);
	}

	/**
	 * Converte uma data localizada para padrão de banco de dados (americano)
	 * 
	 * @param string $value
	 * @return bool
	 */
	private function __dateConvert(&$value)
	{		
		$df = new IntlDateFormatter($this->langs['finalLang'],  IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
		
		if($df === FALSE)
		{
			return FALSE;
		}
		
		$value = $df->format($value);
		
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
