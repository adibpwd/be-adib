<?Php

namespace App\Repositories;

use App\Models\User;

class UserRepository 
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getByCity($city)
    {
        return $this->user
                ->where('address', 'LIKE', "%{$city}%")
                ->get();
    }
}