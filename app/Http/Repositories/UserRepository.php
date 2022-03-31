<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Http\Interfaces\UserRepositoryInterface;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * get a User
     * @param string
     * @return collection
     */
    public function get()
    {
        return User::all();
    }

    /**
     * get a User by it's UUID
     * @param string
     * @return collection
     */
    public function getByUuid($uuid)
    {
        return User::byUuid($uuid)->first();
    }
    /**
     * Create new user.
     * @param array User data
     */
    public function create(array $userData, $image)
    {
        $user = new User();
        try {
            $user->first_name = $userData['first_name'];
            $user->last_name = $userData['last_name'];
            $user->contact_number = $userData['contact_number'];
            $user->address = $userData['address'];
            $user->email = $userData['email'];
            $user->password = Hash::make($userData['password']);
            $user->city = $userData['city'];
            $user->country = $userData['country'];
            $user->state = $userData['state'];
            $user->zip_code = $userData['zip_code'];
            $user->role = 'user';
            $user->image = $image;
            $user->save();
            return $user;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    /**
     * Updates existing user.
     *
     * @param User object
     * @param array User data
     */
    public function update(User $user, array $userData, $file)
    {
        try {
            $user->first_name = $userData['first_name'];
            $user->last_name = $userData['last_name'];
            $user->contact_number = $userData['contact_number'];
            $user->address = $userData['address'];
            $user->email = $userData['email'];
            $user->city = $userData['city'];
            $user->country = $userData['country'];
            $user->state = $userData['state'];
            $user->zip_code = $userData['zip_code'];
            $user->image = $file;
            if (isset($userData['password'])) {
                $user->password = Hash::make($userData['password']);
            }

            $user->save();
            return $user;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
	 * Updates a users email verified at.
	 *
	 * @param int
	 * @param array
	 */
	public function updateEmailVerifyAt(User $user){
        if(!isset($user->email_verified_at)){
            $user->email_verified_at = carbon::now();
            $user->save();
        }
        return $user;
    }

    /**
	 * Updates a user's password.
	 *
	 * @param int
	 * @param array
	 */
	public function updatePassword(User $user, array $userData){
        try {
            if (isset($userData['new_password'])) {
                $user->password = Hash::make($userData['new_password']);
                $user->save();
                return $user;
            }else{
                return false;
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    /**
     * Delete a User.
     * @param User object
     */
    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return $user;
    }

}
