<?php

namespace App\Http\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
	/**
	 * Get's all users
	 *
	 * @param int
	 */
	public function get();

	/**
	 * Get's a User by it's UUID
	 *
	 * @param int
	 */
	public function getByUuid($uuid);

	/**
	 * Create new user.
	 *
	 * @param array
	 */
	public function create(array $userData, $image);

	/**
	 * Updates a user.
	 *
	 * @param int
	 * @param array
	 */
	public function update(User $user, array $userData, $file);

    /**
	 * Updates a user's password.
	 *
	 * @param int
	 * @param array
	 */
	public function updatePassword(User $user, array $userData);

    /**
	 * Updates a users email verified at.
	 *
	 * @param int
	 * @param array
	 */
	public function updateEmailVerifyAt(User $user);
}
