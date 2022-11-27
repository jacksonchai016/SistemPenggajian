<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payslip extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payslips';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['employee_id', 'contract_id', 'currency', 'start_date', 'end_date', 'deduction', 'bonus', 'payslip_amount'];

    
}
