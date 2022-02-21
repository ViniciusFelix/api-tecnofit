<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RankingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name()
        ];
    }
    
    /**
     * Retorno do recorde pelo usuario e movimento.
     * 
     * @param integer $idMoviment
     * @param integer $idUser
     * @return array
     */
    public function getRecordUser($idMoviment,$idUser)
    {
        $sql = "
            select 
            	pr.value as record,
                pr.`date` as data,
                m.name as movimento
            from tecnofit.personal_record pr 
            join tecnofit.moviments m 
              on m.id = pr.moviment_id 
            where pr.value = (
            select max(pr2.value)
             from tecnofit.personal_record pr2 
             where pr2.user_id = {$idUser}
               and pr2.moviment_id = {$idMoviment})
            and pr.user_id = {$idUser}
            and pr.moviment_id = {$idMoviment}
            order by pr.`date` desc
        ";
        
        return \DB::select($sql);
    }
}
