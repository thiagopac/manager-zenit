<?php

class Setting extends ActiveRecord\Model {
	static $table_name = 'core';

    public function list_states(){

        $pt_BR = array(
            ''=>'Selecione o estado',
            'AC'=>'Acre',
            'AL'=>'Alagoas',
            'AP'=>'Amapá',
            'AM'=>'Amazonas',
            'BA'=>'Bahia',
            'CE'=>'Ceará',
            'DF'=>'Distrito Federal',
            'ES'=>'Espírito Santo',
            'GO'=>'Goiás',
            'MA'=>'Maranhão',
            'MT'=>'Mato Grosso',
            'MS'=>'Mato Grosso do Sul',
            'MG'=>'Minas Gerais',
            'PA'=>'Pará',
            'PB'=>'Paraíba',
            'PR'=>'Paraná',
            'PE'=>'Pernambuco',
            'PI'=>'Piauí',
            'RJ'=>'Rio de Janeiro',
            'RN'=>'Rio Grande do Norte',
            'RS'=>'Rio Grande do Sul',
            'RO'=>'Rondônia',
            'RR'=>'Roraima',
            'SC'=>'Santa Catarina',
            'SP'=>'São Paulo',
            'SE'=>'Sergipe',
            'TO'=>'Tocantins'
        );

        return $pt_BR;
    }

    public function list_countries(){

        $pt_BR = array(
//            ''=>'Selecione o país',
            'Brasil'=>'Brasil'
        );

        return $pt_BR;
    }

    public function list_payment_methods(){

        $pt_BR = array(
            ''=>'Selecione o tipo de pagamento',
            'bank financing'=>'Financiamento bancário',
            'own resources'=>'Recursos próprios',
        );

        return $pt_BR;
    }
}
