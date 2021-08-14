<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AddProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_may_not_add_products()
    {
        $this->get(route('admin.products.create'))
            ->assertRedirect('/admin/login');

        $this->post('/admin/products')
            ->assertRedirect('/admin/login');
    }

    /**
     * @test
     */
    public function an_authenticated_admin_can_add_new_products()
    {
        $this->actingAs(Admin::factory()->create(), 'admin');

        $product = Product::factory()->make();
        $productWithImage = array_merge($product->toArray(), [
            'image' => UploadedFile::fake()->image('avatar.jpg', 200, 350)->size(100)
        ]);

        $this->post('/admin/products', $productWithImage)->assertRedirect(route('admin.products.index'));

        $this->assertEquals($product->name, Product::first()->name);
        $this->assertEquals($product->details, Product::first()->details);
        $this->assertEquals($product->price, Product::first()->price);
    }

    /**
     * @test
     */
    public function a_product_requires_a_name()
    {
        $this->createProduct(['name' => null])
            ->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function a_product_requires_a_details()
    {
        $this->createProduct(['details' => null])
            ->assertSessionHasErrors('details');
    }

    /**
     * @test
     */
    public function a_product_requires_a_price()
    {
        $this->createProduct(['price' => null])
            ->assertSessionHasErrors('price');
    }

    /**
     * @test
     */
    public function a_product_requires_a_numeric_price()
    {
        $this->createProduct(['price' => 'not a num'])
            ->assertSessionHasErrors('price');
    }

    public function createProduct($overrides = [])
    {
        $this->withExceptionHandling()->actingAs(Admin::factory()->create(), 'admin');

        $product = Product::factory()->make($overrides);

        return $this->post('/admin/products', $product->toArray());
    }
}
