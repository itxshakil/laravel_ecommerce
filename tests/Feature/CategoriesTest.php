<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function admin_can_add_new_category()
    {
        $this->actingAs(Admin::factory()->create(), 'admin');
        $this->post(route('admin.categories.store'), [
            'name' => 'laptops'
        ]);

        // Check for no duplicates
        $this->post(route('admin.categories.store'), [
            'name' => 'Laptops'
        ]);

        $this->assertCount(1, Category::all());
        $this->assertDatabaseHas('categories', ['name' => 'laptops']);
    }
}
