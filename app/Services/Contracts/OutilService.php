<?php

namespace App\Services\Contracts;

use App\Models\Outil;
use Illuminate\Database\Eloquent\Collection;

interface OutilService
{
    public function create(array $data): Outil;
    public function update(Outil $outil, array $data): Outil;
    public function delete(Outil $outil): bool;
    public function findById(int $id): ?Outil;
    public function findAll(): Collection;
    public function updateStock(Outil $outil, int $quantity): Outil;
}
