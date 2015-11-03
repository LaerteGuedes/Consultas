<?php

namespace App\Contracts;


interface CurriculoRepositoryInterface {

    public function paginateByUser($id);

    public function checkUserHasItem($user_id,$id);
} 