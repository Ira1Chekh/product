<?php

namespace Tests\Unit;

use App\Models\Currency;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $seed = true;
    protected $seeder = DatabaseSeeder::class;
    public Currency $currency;
    public $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
        $this->client = $this->signIn();
        Artisan::call('db:seed', ['--class' => 'CurrencySeeder']);

        $this->currency = Currency::first();
    }

    public function test_product_can_be_stored()
    {
        $data = $this->getProductData();
        $this->post(route('products.store'), $data)->assertStatus(201);
        $this->assertDatabaseHas('products',
            $this->getDatabaseProductData($data, ['currency'])
        );
    }

    public function test_product_validation_works()
    {
        $data = [
            'title' => $this->faker->title,
            'price' => -600,
            'currency_id' => $this->currency->id,
        ];
        $this->post(route('products.store'), $data)->assertStatus(302);
    }

    public function test_product_can_be_updated()
    {
        $product = Product::factory()->create();
        $data = $this->getProductData();
        $this->put(route('products.update', [$product->id]), $data)->assertStatus(200);
        $this->assertDatabaseHas('products',
            $this->getDatabaseProductData($data, ['currency'])
        );
    }

    protected function getProductData(): array
    {
        return [
            'title' => $this->faker->title,
            'price' => $this->faker->numberBetween(1, 999999),
            'currency_id' => $this->currency->id,
        ];
    }

    protected function getDatabaseProductData(array $data, array $keys): array
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $keys)) {
                $data[$key.'_id'] = $value;
                unset($data[$key]);
            }
        }

        return $data;
    }

    protected function signIn()
    {
        $client = User::factory()->create();
        Sanctum::actingAs($client, ['*']);

        return $client;
    }

}
