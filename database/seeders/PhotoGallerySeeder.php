<?php

namespace Database\Seeders;

use App\Models\product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PhotoGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = product::factory()->create();

        DB::table('product_galleries')->insert([
            'id_products' => $product->id,
            'url' => 'image1.png',
            'is_featured' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
