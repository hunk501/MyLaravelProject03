<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MdlApplication extends Model {
    
    protected $table = "tbl_application";
    
    protected $guarded = ["id"];

    
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
    
    
    public function getComelect() {
        return $this->hasMany("App\Models\MdlComelec", "voters_name", "borrower_name");
    }
}
