<?php
/**
 * Helper para formatação de dados no padrão brasileiro
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Juan Basso <jrbasso@gmail.com>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

class FormatacaoHelper extends AppHelper {

	var $helpers = array('Time', 'Number');

	/* Datas */

	function data($data = null) {
		$data = $this->_ajustaDataHora($data);
		return $this->Time->format('d/m/Y', $data);
	}

	function dataHora($dataHora = null, $segundos = true) {
		$dataHora = $this->_ajustaDataHora($dataHora);
		if ($segundos) {
			return $this->Time->format('d/m/Y H:i:s', $dataHora);
		}
		return $this->Time->format('d/m/Y H:i', $dataHora);
	}

	function dataCompleta($dataHora = null) {
		$_diasDaSemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
		$_meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

		$dataHora = $this->_ajustaDataHora($dataHora);
		$w = date('w', $dataHora);
		$n = date('n', $dataHora) - 1;

		return sprintf('%s, %02d de %s de %04d, %s', $_diasDaSemana[$w], date('d', $dataHora), $_meses[$n], date('Y', $dataHora), date('H:i:s', $dataHora));
	}

	function _ajustaDataHora($data) {
		if (is_null($data)) {
			return time();
		}
		return $data;
	}

	/* Números */

	function precisao($numero, $casasDecimais = 3) {
		return sprintf("%01.{$casasDecimais}f", $numero);
	}

	function porcentagem($numero, $casasDecimais = 2) {
		return $this->precisao($numero, $casasDecimais) . '%';
	}

	function moeda($valor, $opcoes = array()) {
		$padrao = array(
			'before'=> 'R$ ',
			'after' => '',
			'zero' => 'R$ 0,00',
			'places' => 2,
			'thousands' => '.',
			'decimals' => ',',
			'negative' => '()',
			'escape' => true
		);
		$config = array_merge($padrao, $opcoes);
		if ($valor > -1 && $valor < 1) {
			$formatado = $this->Number->format(abs($valor), $config);
			if ($valor < 0 ) {
				if ($config['negative'] == '()') {
					$formatado = '(' . $formatado .')';
				} else {
					$formatado = $config['negative'] . $formatado;
				}
			}
			return $formatado;
		}
		return $this->Number->currency($valor, null, $config);
	}

	function moedaPorExtenso($numero) {
		// Adaptado de http://forum.imasters.uol.com.br/index.php?showtopic=125375
		$singular = array('centavo', 'real', 'mil', 'milhão', 'bilhão', 'trilhão', 'quatrilhão');
		$plural = array('centavos', 'reais', 'mil', 'milhões', 'bilhões', 'trilhões', 'quatrilhões');

		$c = array('', 'cem', 'duzentos', 'trezentos', 'quatrocentos', 'quinhentos', 'seiscentos', 'setecentos', 'oitocentos', 'novecentos');
		$d = array('', 'dez', 'vinte', 'trinta', 'quarenta', 'cinquenta', 'sessenta', 'setenta', 'oitenta', 'noventa');
		$d10 = array('dez', 'onze', 'doze', 'treze', 'quatorze', 'quinze', 'dezesseis', 'dezesete', 'dezoito', 'dezenove');
		$u = array('', 'um', 'dois', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove');

		$z = 0;
		$rt = '';

		$valor = number_format($numero, 2, '.', '.');
		$inteiro = explode('.', $valor);
		$tamInteiro = count($inteiro);

		// Normalizandos os valores para ficarem com 3 digitos
		$inteiro[0] = sprintf('%03d', $inteiro[0]);
		$inteiro[$tamInteiro - 1] = sprintf('%03d', $inteiro[$tamInteiro - 1]);

		$fim = $tamInteiro - 1;
		if ($inteiro[$tamInteiro - 1] <= 0) {
			$fim--;
		}
		foreach ($inteiro as $i => $valor) {
			$rc = $c[$valor{0}];
			if ($valor > 100 && $valor < 200) {
				$rc = 'cento';
			}
			$rd = '';
			if ($valor{1} > 1) {
				$rd = $d[$valor{1}];
			}
			$ru = '';
			if ($valor > 0) {
				if ($valor{1} == 1) {
					$ru = $d10[$valor{2}];
				} else {
					$ru = $u[$valor{2}];
				}
			}

			$r = $rc;
			if ($rc && ($rd || $ru)) {
				$r .= ' e ';
			}
			$r .= $rd;
			if ($rd && $ru) {
				$r .= ' e ';
			}
			$r .= $ru;
			$t = $tamInteiro - 1 - $i;
			if (!empty($r)) {
				$r .= ' ';
				if ($valor > 1) {
					$r .= $plural[$t];
				} else {
					$r .= $singular[$t];
				}
			}
			if ($valor == '000') {
				$z++;
			} elseif ($z > 0) {
				$z--;
			}
			if ($t == 1 && $z > 0 && $inteiro[0] > 0) {
				if ($z > 1) {
					$r .= ' de ';
				}
				$r .= $plural[$t];
			}
			if (!empty($r)) {
				if ($i > 0 && $i < $fim  && $inteiro[0] > 0 && $z < 1) {
					if ($i < $fim) {
						$rt .= ', ';
					} else {
						$rt .= ' e ';
					}
				} elseif ($t == 0 && $inteiro[0] > 0) {
					$rt .= ' e ';
				} else {
					$rt .= ' ';
				}
				$rt .= $r;
			}
		}

		if (empty($rt)) {
			return 'zero';
		}
		return trim($rt);
	}

}

?>