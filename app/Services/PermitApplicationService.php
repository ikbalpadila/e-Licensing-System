<?php

namespace App\Services;

use App\Repositories\Contracts\PermitApplicationRepositoryInterface;
use App\Models\PermitApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PermitApplicationService
{
    public $repository;

    public function __construct(PermitApplicationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createPermit(array $data): PermitApplication
    {
        return DB::transaction(function () use ($data) {
            $permit = $this->repository->create($data);
            Log::info('Permit Application Created', ['id' => $permit->id]);
            return $permit;
        });
    }

    public function updatePermit(int $id, array $data): PermitApplication
    {
        return DB::transaction(function () use ($id, $data) {
            $permit = $this->repository->update($id, $data);
            Log::info('Permit Application Updated', ['id' => $permit->id]);
            return $permit;
        });
    }

    public function deletePermit(int $id): bool
    {
        try {
            return $this->repository->delete($id);
        } catch (Exception $e) {
            Log::error('Failed to delete permit', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public function getUserPermits(int $userId)
    {
        return $this->repository->findByUser($userId);
    }

    public function getPermitsByStatus(string $status)
    {
        return $this->repository->findByStatus($status);
    }
}
