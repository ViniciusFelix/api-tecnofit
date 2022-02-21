<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Database\Factories\RankingFactory;
use App\Models\Users;
use App\Http\Controllers\ApiController;

class RankingServiceProvider extends ServiceProvider
{
    /**
     * Retorna o ranking do movimento.
     * 
     * @param integer $idMoviment
     * @return \Illuminate\Http\JsonResponse|number|array
     */
    public function getRanking($idMoviment)
    {
        $users = Users::get()->toArray();
        $arrRecord = array();
        foreach ($users as $key => $us) {
            $user = ApiController::getUser($us['id']);
            
            $recordUser = RankingFactory::getRecordUser($idMoviment,$us['id']);
            if ( !empty($recordUser) ) {
                $arrRecord[$key]['movimento'] = $recordUser[0]->movimento;
                $arrRecord[$key]['nome'] = $user['name'];
                $arrRecord[$key]['record'] = $recordUser[0]->record;
                $arrRecord[$key]['data'] = $recordUser[0]->data;
            } else {
                return response()->json([
                    "message" => "Nenhum resultado para o movimento informado."
                ], 201);
            }
        }
        
        return RankingServiceProvider::getPosicao($arrRecord);
    }
    
    /**
     * Montar posicao do usuario.
     * 
     * @param array $arrRecord
     * @return number|array
     */
    public function getPosicao($arrRecord) {
        $arrRecord = RankingServiceProvider::arraySortPeloElemento($arrRecord,'record',SORT_DESC);
        
        $intPosicao = 1;
        foreach ($arrRecord as $key => $record) {
            if ( $key > 0 && $record['record'] == $arrRecord[($key-1)]['record'] ) {
                $intPosicao = $intPosicao-1;
            }
            $arrRecord[$key]['posicao'] = $intPosicao;
            $intPosicao++;
        }
        
        return $arrRecord;
    }
    
    /**
     * Metodo padrao para ordenacao de um array por um elemento contido no array
     *
     * @param array $array
     * @param string $on
     * @param string $order
     * @return array[]
     */
    public function arraySortPeloElemento($array, $on, $order = SORT_ASC)
    {
        setlocale(LC_ALL, "portuguese");
        
        $arrNew = array();
        $arrSortable = array();
        
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $arrSortable[$k] = $v2;
                        }
                    }
                } else {
                    $arrSortable[$k] = $v;
                }
            }
            
            switch ($order) {
                case SORT_ASC:
                    asort($arrSortable, SORT_LOCALE_STRING);
                    break;
                case SORT_DESC:
                    arsort($arrSortable, SORT_LOCALE_STRING);
                    break;
            }
            
            foreach ($arrSortable as $k => $v) {
                $arrNew[$k] = $array[$k];
            }
        }
        
        return $arrNew;
    }
}
