<?php
/**
 * Created by PhpStorm.
 * User: hugomachado
 * Date: 07/09/15
 * Time: 21:14
 */

namespace App\Contracts;


interface AgendaRepositoryInterface {

    public function listForCalendarByUser($id);

    public function paginateByUser($id);

    public function checkIfExists($data);

    public function checkIfBusy($id);

} 