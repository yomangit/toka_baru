<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;

class User extends Authenticatable implements LdapAuthenticatable
{
    use HasFactory, Notifiable, AuthenticatesWithLdap;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    public function getLdapDomainColumn(): string
    {
        return 'domain';
    }

    public function getLdapGuidColumn(): string
    {
        return 'guid';
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'lookup_name',
        'employee_id',
        'gender',
        'date_birth',
        'date_commenced',
        'username',
        'company_id',
        'department',
        'end_date',
        'role_user_permit_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function Dept()
    {
        return $this->belongsTo(Department::class,'department');
    }


    public function scopeSearchFor($query, $term)
    {
        $query->when(
            $term ?? false,
            fn($query, $term) => $query->where('name', 'LIKE', '%' . $term . '%')
                ->orWhere('email', 'LIKE', '%' . $term . '%')
                ->orWhere('lookup_name', 'LIKE', '%' . $term . '%')
                ->orWhere('employee_id', 'LIKE', '%' . $term . '%')
                ->orWhere('username', 'LIKE', '%' . $term . '%')
        );
    }
    public function scopeSearchNama($query, $t)
    {
        $query->when(
            $t ?? false,
            fn($query, $t) => $query->where('lookup_name', 'LIKE', '%' . $t . '%')
        );
    }
    public function scopeSearchId($query, $t)
    {
        $query->when(
            $t ?? false,
            fn($query, $t) => $query->where('id', 'LIKE',$t)
        );
    }
    public function ResponsibleRole()
    {
        return $this->belongsToMany(ResponsibleRole::class, 'event_user_securities');
    }

    public function TypeEventReport()
    {
        return $this->belongsToMany(TypeEventReport::class, 'event_user_securities');
    }
}
