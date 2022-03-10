<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Client extends Model
{
    use HasFactory;

    use Sortable;

    public $sortable= ['id', 'name', 'surname', 'description', 'company_id'];


    public function clientCompany() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
