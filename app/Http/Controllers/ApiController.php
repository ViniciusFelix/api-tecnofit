<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Providers\RankingServiceProvider;
use App\Models\Users;

class ApiController extends Controller
{
    /**
     * Metodo retorna o ranking pelo movimento.
     * 
     * @param integer $idMoviment
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getRankingMoviments($idMoviment) {
        $ranking = RankingServiceProvider::getRanking($idMoviment);
        return response($ranking, 200);
    }
    
    /**
     * Metodo retorna o usuario.
     * 
     * @param integer $id
     * @return array
     */
    public function getUser($id) {
        return Users::where('id', $id)->get()->toArray()[0];
    }
}
