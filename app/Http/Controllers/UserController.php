<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Helpers\ApiResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    protected $userService;


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function index()
    {
        $users = $this->userService->getUsers();

        return ApiResponse::success(
            UserResource::collection($users),
            'Data user berhasil diambil'
        );
    }


    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser(
            $request->validated()
        );

        return ApiResponse::success(
            new UserResource($user),
            'User berhasil dibuat',
            201
        );
    }


        public function show($id)
    {
        $user = $this->userService->getUser($id);

        if (!$user) {
            return ApiResponse::error(
                'User tidak ditemukan',
                null,
                404
            );
        }

        return ApiResponse::success(
            new UserResource($user),
            'User ditemukan'
        );
    }


    public function update(
        UpdateUserRequest $request,
        $id
    )
    {
        $user = $this->userService->updateUser(
            $id,
            $request->validated()
        );

        return ApiResponse::success(
            new UserResource($user),
            'User berhasil diperbarui'
        );
    }


    public function destroy($id)
    {
        $this->userService->deleteUser($id);

        return ApiResponse::success(
            null,
            'User berhasil dihapus'
        );
    }
}