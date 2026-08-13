<?php

namespace Tests\Feature\Catalog;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_table_exists_with_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable("products"));

        $expected = ["id", "salla_id", "slug", "name", "description", "price", "currency", "stock", "is_active", "deleted_at", "created_at", "updated_at"];
        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn("products", $column),
                  " products table is missing column: {$column}"
            );
        }
    }

    public function test_product_variants_table_exists_with_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable("product_variants"));

        $expected = ["id", "product_id", "salla_id", "name", "sku", "price", "stock", "created_at", "updated_at"];
        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn("product_variants", $column),
                   "product_variants table is missing column: {$column}"
            );
        }
    }

    public function test_product_options_table_exists_with_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable("product_options"));

        $expected = ["id", "product_id", "name", "values"];
        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn("product_options", $column),
                    "product_options table is missing column: {$column}"
            );
        }
    }

    public function test_categories_table_exists_with_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable("categories"));

        $expected = ["id", "salla_id", "slug", "name", "parent_id", "created_at", "updated_at"];
        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn("categories", $column),
                "categories table is missing column: {$column}"
            );
        }
    }

    public function test_product_category_pivot_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable("product_category"));

        $this->assertTrue(Schema::hasColumn("product_category", "product_id"));
        $this->assertTrue(Schema::hasColumn("product_category", "category_id"));
    }

    public function test_product_images_table_exists_with_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable("product_images"));

        $expected = ["id", "product_id", "url", "alt", "is_primary", "sort_order"];
        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn("product_images", $column),
                "product_images table is missing column: {$column}"
            );
        }
    }

    public function test_products_slug_is_unique(): void
    {
        $indexes = Schema::getIndexes("products");
        $hasUniqueSlug = collect($indexes)->contains(fn($i) =>
            in_array("slug", $i["columns"]) && $i["unique"] === true
        );
        $this->assertTrue($hasUniqueSlug, "products.slug should have a unique index");
    }

    public function test_products_salla_id_is_unique(): void {
        $indexes = Schema::getIndexes("products");
        $hasUniqueSalla = collect($indexes)->contains(fn($i) =>
            in_array("salla_id", $i["columns"]) && $i["unique"] === true
        );
        $this->assertTrue($hasUniqueSalla, "products.salla_id should have a unique index");
    }

    public function test_categories_supports_self_referencing_hierarchy(): void
    {
        $columns = Schema::getColumnListing("categories");
        $this->assertContains("parent_id", $columns, "categories.parent_id required for hierarchy");
    }

    public function test_product_variants_has_foreign_key_to_products(): void
    {
        $foreignKeys = Schema::getForeignKeys("product_variants");
        $hasFk = collect($foreignKeys)->contains(fn($fk) =>
            in_array("product_id", $fk["columns"]) &&
            str_contains($fk["foreign_table"], "products")
        );
        $this->assertTrue($hasFk, "product_variants.product_id should reference products.id");
    }
}