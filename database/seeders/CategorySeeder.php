<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Bevestigingsmateriaal', 'icon' => '🧰', 'description' => 'voor onderhoud en montage', 'color' => '#3B82F6', 'sort_order' => 1],
            ['name' => 'Persoonlijke beschermingsmiddelen (PBM)', 'icon' => '👷‍♂️', 'description' => 'veiligheidsuitrusting', 'color' => '#EF4444', 'sort_order' => 2],
            ['name' => 'Gereedschap', 'icon' => '🔧', 'description' => 'manueel & elektrisch', 'color' => '#10B981', 'sort_order' => 3],
            ['name' => 'Technische onderhoudsmaterialen', 'icon' => '⚙️', 'description' => 'smeervet, o-ringen, slangen', 'color' => '#F59E0B', 'sort_order' => 4],
            ['name' => 'Specifieke Aquafin/riolering gerelateerde tools', 'icon' => '🛠️', 'description' => 'putdekselhaak, rioolcamera, etc.', 'color' => '#8B5CF6', 'sort_order' => 5],
            ['name' => 'Diversen / Verbruiksgoederen', 'icon' => '📦', 'description' => 'tie-wraps, batterijen, spray\'s', 'color' => '#6B7280', 'sort_order' => 6]
        ];

        foreach ($categories as $category) {
            Category::create($category + ['is_active' => true]);
        }
    }
}