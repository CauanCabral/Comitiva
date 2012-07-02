<?php
App::uses('AppModel', 'Model');
class StatusMessage extends AppModel {
    public $useDbConfig = 'dataArray';

    public $recursive = -1;

    /**
     * @var array Códigos de Status
     *
     * 1    Aguardando pagamento: o comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento.
     * 2    Em análise: o comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.
     * 3    Paga: a transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento.
     * 4    Disponível: a transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta.
     * 5    Em disputa: o comprador, dentro do prazo de liberação da transação, abriu uma disputa.
     * 6    Devolvida: o valor da transação foi devolvido para o comprador.
     * 7    Cancelada: a transação foi cancelada sem ter sido finalizada.
     */
    public $records = array(
        array('id' => 1, 'name' => 'AGUARDANDO PAGAMENTO'),
        array('id' => 2, 'name' => 'EM ANÁLISE'),
        array('id' => 3, 'name' => 'PAGA'),
        array('id' => 4, 'name' => 'DISPONÍVEL'),
        array('id' => 5, 'name' => 'EM DISPUTA'),
        array('id' => 6, 'name' => 'DEVOLVIDA'),
        array('id' => 7, 'name' => 'CANCELADA')
    );
}