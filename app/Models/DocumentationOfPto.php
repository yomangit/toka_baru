<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cjmellor\Approval\Concerns\MustBeApproved;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentationOfPto extends Model
{
    use HasFactory;
    use MustBeApproved;
    protected $table="documentation_of_ptos";
    protected $fillable=[
        'name_doc',
        'description',
        'reference'
    ];
    
}
