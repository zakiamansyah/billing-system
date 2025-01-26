<?php 
 
namespace Database\Seeders; 
 
use App\Models\Customers; 
use App\Models\Vps; 
// use Illuminate\Database\Console\Seeds\WithoutModelEvents; 
use Illuminate\Database\Seeder; 
 
class DatabaseSeeder extends Seeder 
{ 
    /** 
     * Seed the application's database. 
     */ 
    public function run(): void 
    { 
        $customers = Customers::factory(10)->create(); 
        
        //Pick RAM and Storage with extension MB
        $ramOptions = [1024, 2048, 4096, 8192, 16384]; 
        $storageOptions = [10240, 20480, 30720, 40960, 51200, 61440, 71680, 81920, 92160, 102400]; 
 
        $customers->each(function ($customer) use ($ramOptions, $storageOptions) { 
            Vps::factory(1)->create([ 
                'customer_id' => $customer->id, 
                'cpu' => fake()->numberBetween(1, 4), 
                'ram' => fake()->randomElement($ramOptions), 
                'storage' => fake()->randomElement($storageOptions), 
                'status' => fake()->randomElement(['active', 'suspended']) 
            ]); 
        }); 
    } 
}
