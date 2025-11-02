<?php

namespace App\Repositories\Eloquent;

use App\Repositories\BaseRepository;
use App\Repositories\Contracts\PermitApplicationRepositoryInterface;
use App\Models\PermitApplication;
use Illuminate\Support\Collection;

class PermitApplicationRepository extends BaseRepository implements PermitApplicationRepositoryInterface
{
    public function __construct(PermitApplication $model)
    {
        parent::__construct($model);
    }

    // Override method agar bisa load relasi penting
    public function findById(int $id): ?PermitApplication
    {
        return $this->model
            ->with(['user', 'permitType', 'documents', 'approval', 'verification', 'payment'])
            ->find($id);
    }

    public function findByUser(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->with(['permitType', 'approval', 'verification'])
            ->get();
    }

    public function findByStatus(string $status): Collection
    {
        return $this->model
            ->where('status', $status)
            ->with(['user', 'permitType'])
            ->get();
    }
}
