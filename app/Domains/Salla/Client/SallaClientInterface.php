<?php

namespace App\Domains\Salla\Client;

interface SallaClientInterface
{
    public function getProducts(): array;

    public function getProduct(int $sallaId): ?array;

    public function getProductsByCategory(string $categorySlug): array;

    public function getCategories(): array;

    public function checkStock(int $sallaProductId, int $quantity): array;

    public function createOrder(array $orderData): array;
}
