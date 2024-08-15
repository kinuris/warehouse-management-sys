<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'internal_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'system_role_id',
        'employee_role_id',
        'is_suspended',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function mostRecentAttendance(): EmployeeAttendance | null
    {
        return EmployeeAttendance::query()
            ->where('employee_id', '=', $this->id)
            ->orderBy('date', 'desc')
            ->first();
    }

    public static function getEmployees(): Collection
    {
        $id = SystemRole::query()->where('name', '=', 'employee')->first()->id;

        return User::query()->where('system_role_id', '=', $id)->get();
    }

    public static function create($fields = []): User
    {
        $role = SystemRole::query()->find($fields['system_role_id']);

        return User::query()->create(array_merge($fields, [
            'internal_id' => 'SB-' . $role->getShortened() . '-' . User::getNoCollisionID(),
        ]));
    }

    public static function getNoCollisionID(): string
    {
        while (true) {
            $end = random_int(0, 9999);

            $like = User::query()->where('internal_id', 'LIKE', "%$end%")->first();

            if ($like === null) {
                return $end;
            }
        }
    }



    public function getFullname(): string
    {
        return $this->first_name . ' ' . ($this->middle_name ? $this->middle_name[0] . '.' : '') . ' ' . $this->last_name;
    }

    public function findInternal(string $id): User
    {
        return User::query()->where('internal_id', '=', $id)->first();
    }

    public function isSysRole(string $role): bool
    {
        $role = SystemRole::query()->where('name', $role)->first();

        return $role->id === $this->system_role_id;
    }

    public function isEmpRole(string $role): bool
    {
        $role = EmployeeRole::query()->where('name', $role)->first();

        return $role->id === $this->employee_role_id;
    }
}
