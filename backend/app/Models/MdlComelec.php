<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdlComelec extends Model {
    
    protected $table = "tbl_comelec";
    
    protected $guarded = ["id"];
    
    
    
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
    
}
