<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\EmployeeRole;
use App\Models\ItemOverhead;
use App\Models\Product;
use App\Models\SystemRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $fertilizers = array(
            array('name' => '(Urea Fertilizer (46-0-0) 50 kg bag) Complete Fertilizer (Urea)', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Urea Fertilizer (46-0-0) 50 kg bag) Greenfield Urea', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Urea Fertilizer (46-0-0) 50 kg bag) Atlas Urea', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Ammonium Sulfate (21-0-0) 50 kg bag) Golden Urea Ammonium Sulfate', 'base_price' => 1232.0, 'profit' => 336.0),
            array('name' => '(Ammonium Sulfate (21-0-0) 50 kg bag) Atlas Fertilizer Ammonium Sulfate', 'base_price' => 1232.0, 'profit' => 336.0),
            array('name' => '(Ammonium Sulfate (21-0-0) 50 kg bag) YaraMila Hydro (Ammonium Sulfate based)', 'base_price' => 1232.0, 'profit' => 336.0),
            array('name' => '(Complete Fertilizer (14-14-14) 50 kg bag) Trac Complete Fertilizer 14-14-14', 'base_price' => 1400.0, 'profit' => 280.0),
            array('name' => '(Complete Fertilizer (14-14-14) 50 kg bag) Atlas Fertilizer Complete 14-14-14', 'base_price' => 1400.0, 'profit' => 280.0),
            array('name' => '(Complete Fertilizer (14-14-14) 50 kg bag) Greenfield Complete Fertilizer', 'base_price' => 1400.0, 'profit' => 280.0),
            array('name' => '(NPK Fertilizer 1 kg) GrowMore 20-20-20 NPK', 'base_price' => 280.0, 'profit' => 112.0),
            array('name' => '(NPK Fertilizer 25 kg) GrowMore 20-20-20 NPK', 'base_price' => 840.0, 'profit' => 280.0),
            array('name' => '(NPK Fertilizer 25 kg bag) YaraMila 16-16-16', 'base_price' => 1008.0, 'profit' => 280.0),
            array('name' => '(NPK Fertilizer 25 kg) Peters Professional 20-20-20', 'base_price' => 1008.0, 'profit' => 280.0),
            array('name' => '(Organic Fertilizer 50 kg bag) Durabloom Organic Fertilizer', 'base_price' => 1680.0, 'profit' => 280.0),
            array('name' => '(Organic Fertilizer 50 kg bag) Biospark Organic Fertilizer', 'base_price' => 1680.0, 'profit' => 280.0),
            array('name' => '(Organic Fertilizer 50 kg bag) Nutrich Organic Fertilizer', 'base_price' => 1680.0, 'profit' => 280.0),
            array('name' => '(Foliar Fertilizer 1 L) Vigormin Foliar Fertilizer', 'base_price' => 560.0, 'profit' => 112.0),
            array('name' => '(Foliar Fertilizer 5 L) Vigormin Foliar Fertilizer', 'base_price' => 2240.0, 'profit' => 280.0),
            array('name' => '(Foliar Fertilizer 1 L) Fertigrow Foliar Fertilizer', 'base_price' => 560.0, 'profit' => 112.0),
            array('name' => '(Foliar Fertilizer 5 L) Fertigrow Foliar Fertilizer', 'base_price' => 2240.0, 'profit' => 280.0),
            array('name' => '(Foliar Fertilizer 1 L) YaraVita Foliar Fertilizer', 'base_price' => 560.0, 'profit' => 112.0),
            array('name' => '(Foliar Fertilizer 5 L) YaraVita Foliar Fertilizer', 'base_price' => 2240.0, 'profit' => 280.0),
        );

        $Insecticide = array( 
            array('name' => 'Decis 2.5 EC Insecticide - Bayer', 'base_price' => 250.0, 'profit' => 100.0),
            array('name' => 'Karate 2.5 EC Insecticide - Syngenta', 'base_price' => 270.0, 'profit' => 90.0),
            array('name' => 'Malathion 57% EC - Ramgo', 'base_price' => 180.0, 'profit' => 60.0),
            array('name' => 'Dibrom Insecticide 100 EC - AMVAC', 'base_price' => 300.0, 'profit' => 120.0),
            array('name' => 'Sevin 85 S Insecticide - East-West Seed', 'base_price' => 200.0, 'profit' => 80.0),
        );

        $herbicides = array(
            array('name' => '(Glyphosate-Based Herbicides 1 L) Roundup (Monsanto) - Active ingredient: Glyphosate', 'base_price' => 840.0, 'profit' => 168.0),
            array('name' => '(Glyphosate-Based Herbicides 5 L) Roundup (Monsanto)', 'base_price' => 3920.0, 'profit' => 840.0),
            array('name' => '(Glyphosate-Based Herbicides 1 L) Lifanil (Local Brand)', 'base_price' => 840.0, 'profit' => 168.0),
            array('name' => '(Glyphosate-Based Herbicides 5 L) Lifanil (Local Brand)', 'base_price' => 3920.0, 'profit' => 840.0),
            array('name' => '(Paraquat-Based Herbicides 1 L) Gramoxone (Syngenta) - Active ingredient: Paraquat', 'base_price' => 840.0, 'profit' => 168.0),
            array('name' => '(Paraquat-Based Herbicides 5 L) Gramoxone (Syngenta)', 'base_price' => 3920.0, 'profit' => 840.0),
            array('name' => '(Paraquat-Based Herbicides 1 L) Paracol (Bayer) - Active ingredient: Paraquat', 'base_price' => 840.0, 'profit' => 168.0),
            array('name' => '(Paraquat-Based Herbicides 5 L) Paracol (Bayer)', 'base_price' => 3920.0, 'profit' => 840.0),
            array('name' => '(Pre-Emergence Herbicides 1 L) Prowl (BASF) - Active ingredient: Pendimethalin', 'base_price' => 840.0, 'profit' => 168.0),
            array('name' => '(Pre-Emergence Herbicides 5 L) Prowl (BASF)', 'base_price' => 3920.0, 'profit' => 840.0),
            array('name' => '(Pre-Emergence Herbicides 1 L) Lasso (Monsanto) - Active ingredient: Alachlor', 'base_price' => 840.0, 'profit' => 168.0),
            array('name' => '(Pre-Emergence Herbicides 5 L) Lasso (Monsanto)', 'base_price' => 3920.0, 'profit' => 840.0),
            array('name' => '(Pre-Emergence Herbicides 1 L) Dual Gold (Syngenta) - Active ingredient: S-Metolachlor', 'base_price' => 840.0, 'profit' => 168.0),
            array('name' => '(Pre-Emergence Herbicides 5 L) Dual Gold (Syngenta)', 'base_price' => 3920.0, 'profit' => 840.0),
            array('name' => '(Selective Herbicides 1 L) Basagran (BASF) - Active ingredient: Bentazon', 'base_price' => 840.0, 'profit' => 168.0),
            array('name' => '(Selective Herbicides 5 L) Basagran (BASF)', 'base_price' => 3920.0, 'profit' => 840.0),
            array('name' => '(Selective Herbicides 1 L) 2,4-D Amine (Multiple Brands) - Active ingredient: 2,4-D', 'base_price' => 560.0, 'profit' => 112.0),
            array('name' => '(Selective Herbicides 5 L) 2,4-D Amine (Multiple Brands)', 'base_price' => 2520.0, 'profit' => 560.0),
            array('name' => '(Selective Herbicides 1 L) Machete (Syngenta) - Active ingredient: Butachlor', 'base_price' => 840.0, 'profit' => 168.0),
            array('name' => '(Selective Herbicides 5 L) Machete (Syngenta)', 'base_price' => 3920.0, 'profit' => 840.0),
            array('name' => '(Selective Herbicides) Machete (Syngenta)', 'base_price' => 3920.0, 'profit' => 840.0),
        );

        $fungicides = array(
            array('name' => 'Dithane M-45 (1 kg) - Bayer', 'base_price' => 450.0, 'profit' => 150.0),
            array('name' => 'Ridomil Gold (250 g) - Syngenta', 'base_price' => 380.0, 'profit' => 120.0),
            array('name' => 'Mancozeb 75 WP (1 kg) - UPL', 'base_price' => 420.0, 'profit' => 140.0),
            array('name' => 'Folicur 250 EC (100 ml) - Bayer', 'base_price' => 600.0, 'profit' => 200.0),
            array('name' => 'Score 250 EC (250 ml) - Syngenta', 'base_price' => 720.0, 'profit' => 180.0),
            array('name' => 'Antracol WP70 (1 kg) - Bayer', 'base_price' => 480.0, 'profit' => 160.0),
            array('name' => 'Topsin M 70 WP (500 g) - Nippon Soda', 'base_price' => 360.0, 'profit' => 120.0),
            array('name' => 'SAAF Fungicide (250 g) - UPL', 'base_price' => 300.0, 'profit' => 100.0),
            array('name' => 'Copper Oxychloride 50 WP (500 g) - Indofil', 'base_price' => 280.0, 'profit' => 90.0),
            array('name' => 'Nativo 75 WG (100 g) - Bayer', 'base_price' => 850.0, 'profit' => 250.0),
            array('name' => 'Curzate M8 (250 g) - Dupont', 'base_price' => 390.0, 'profit' => 110.0),
            array('name' => 'Ziram 76 DF (1 kg) - UPL', 'base_price' => 430.0, 'profit' => 130.0),
            array('name' => 'Tricyclazole 75 WP (500 g) - Adama', 'base_price' => 370.0, 'profit' => 110.0),
            array('name' => 'Cabrio Top (250 g) - BASF', 'base_price' => 460.0, 'profit' => 140.0),
            array('name' => 'Contaf Plus (100 ml) - Willowood', 'base_price' => 210.0, 'profit' => 70.0),
            array('name' => 'Hexaconazole 5% SC (1 Liter) - Insecticides India', 'base_price' => 550.0, 'profit' => 180.0),
            array('name' => 'Propiconazole 25% EC (250 ml) - Syngenta', 'base_price' => 600.0, 'profit' => 200.0),
            array('name' => 'Validamycin 3% L (500 ml) - T-Stanes', 'base_price' => 430.0, 'profit' => 120.0),
            array('name' => 'Tilt 250 EC (250 ml) - Syngenta', 'base_price' => 700.0, 'profit' => 230.0),
            array('name' => 'Melody Duo (250 g) - Bayer', 'base_price' => 780.0, 'profit' => 260.0),
            array('name' => 'Amistar Top (250 ml) - Syngenta', 'base_price' => 950.0, 'profit' => 300.0),
            array('name' => 'Trichoderma viride Bio-Fungicide (1 kg) - Agrinos', 'base_price' => 350.0, 'profit' => 100.0),
            array('name' => 'Sulfur 80% WDG (1 kg) - Indofil', 'base_price' => 280.0, 'profit' => 90.0),
        );
        

        $molliride = array(
            array('name' => 'Metaldehyde 5% Pellet (1 kg) - Bayer', 'base_price' => 320.0, 'profit' => 80.0),
            array('name' => 'Sluggo Molluscicide (500 g) - Neudorff', 'base_price' => 280.0, 'profit' => 70.0),
            array('name' => 'Deadline M-Ps (1 kg) - AMVAC', 'base_price' => 350.0, 'profit' => 90.0),
            array('name' => 'Ferric Phosphate 1% Granule (1 kg) - Certis', 'base_price' => 300.0, 'profit' => 75.0),
            array('name' => 'Ortho Bug-Geta Snail & Slug Killer (1 lb / ~454g) - Scotts', 'base_price' => 250.0, 'profit' => 60.0),
            array('name' => 'Slug Bait 4% Metaldehyde (500 g) - Ramgo Agro', 'base_price' => 260.0, 'profit' => 65.0),
            array('name' => 'Snail Buster (1 kg) - East-West Agro', 'base_price' => 340.0, 'profit' => 85.0),
        );
        

        $vegetableSeeds = array(
            array('name' => '(Tomato Seeds 10g - Diamante Max, Tinago, Red Jewel) East-West Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Tomato Seeds 100g - Diamante Max, Tinago, Red Jewel) East-West Seed', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Tomato Seeds 10g - T-52, Cherry Tomato) Known-You Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Tomato Seeds 100g - T-52, Cherry Tomato) Known-You Seed', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Tomato Seeds 10g - Harabas, Monte Carlo) Ramgo Seeds', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Tomato Seeds 100g - Harabas, Monte Carlo) Ramgo Seeds', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Eggplant Seeds 10g - Casino, Dumaguete Long Purple) East-West Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Eggplant Seeds 100g - Casino, Dumaguete Long Purple) East-West Seed', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Eggplant Seeds 10g - Black Beauty) Known-You Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Eggplant Seeds 100g - Black Beauty) Known-You Seed', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Eggplant Seeds 10g - Talong Bughaw, Batanes Long Purple) Ramgo Seeds', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Eggplant Seeds 100g - Talong Bughaw, Batanes Long Purple) Ramgo Seeds', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Peppers (Chili and Bell Pepper) 10g - Hot Pepper Django, Bellstar Bell Pepper) East-West Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Peppers (Chili and Bell Pepper) 100g - Hot Pepper Django, Bellstar Bell Pepper) East-West Seed', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Peppers (Chili and Bell Pepper) 10g - Labuyo, Sweet Pepper California Wonder) Ramgo Seeds', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Peppers (Chili and Bell Pepper) 100g - Labuyo, Sweet Pepper California Wonder) Ramgo Seeds', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Peppers (Chili and Bell Pepper) 10g - Sweet Pepper Wonder Bell) Known-You Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Peppers (Chili and Bell Pepper) 100g - Sweet Pepper Wonder Bell) Known-You Seed', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Bitter Gourd (Ampalaya) Seeds 10g - Galaxy, Sta. Rita, Preciosa) East-West Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Bitter Gourd (Ampalaya) Seeds 100g - Galaxy, Sta. Rita, Preciosa) East-West Seed', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Bitter Gourd (Ampalaya) Seeds 10g - Ampalaya Lagkitan) Ramgo Seeds', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Bitter Gourd (Ampalaya) Seeds 100g - Ampalaya Lagkitan) Ramgo Seeds', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Bitter Gourd (Ampalaya) Seeds 10g - Jade Star, Green Glory) Known-You Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Bitter Gourd (Ampalaya) Seeds 100g - Jade Star, Green Glory) Known-You Seed', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => "(Okra Seeds 10g - Smooth Green, Lady's Finger) East-West Seed", 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => "(Okra Seeds 100g - Smooth Green, Lady's Finger) East-West Seed", 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Okra Seeds 10g - Emerald Green) Ramgo Seeds', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Okra Seeds 100g - Emerald Green) Ramgo Seeds', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Okra Seeds 10g - Okra) Known-You Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Okra Seeds 100g - Okra) Known-You Seed', 'base_price' => 1120.0, 'profit' => 280.0),
            array('name' => '(Corn Seeds 1 kg - P3396, P3707 (Hybrid Corn)) Pioneer (Corteva Agriscience)', 'base_price' => 280.0, 'profit' => 112.0),
            array('name' => '(Corn Seeds 5 kg - P3396, P3707 (Hybrid Corn)) Pioneer (Corteva Agriscience)', 'base_price' => 1400.0, 'profit' => 280.0),
            array('name' => '(Corn Seeds 1 kg - DK818, DK919) Monsanto (Dekalb)', 'base_price' => 280.0, 'profit' => 112.0),
            array('name' => '(Corn Seeds 5 kg - DK818, DK919) Monsanto (Dekalb)', 'base_price' => 1400.0, 'profit' => 280.0),
            array('name' => '(Corn Seeds 1 kg - NK6410, NK3067) Syngenta', 'base_price' => 280.0, 'profit' => 112.0),
            array('name' => '(Corn Seeds 5 kg - NK6410, NK3067) Syngenta', 'base_price' => 1400.0, 'profit' => 280.0),
        );



        $admin_role = SystemRole::query()->create([
            'name' => 'admin',
        ]);

        $role = SystemRole::query()->create([
            'name' => 'manager',
        ]);

        SystemRole::query()->create([
            'name' => 'employee',
        ]);

        $emp_role = EmployeeRole::query()->create([
            'name' => 'management'
        ]);

        EmployeeRole::query()->create([
            'name' => 'driver'
        ]);

        EmployeeRole::query()->create([
            'name' => 'receiver'
        ]);

        EmployeeRole::query()->create([
            'name' => 'laborer'
        ]);

        $categories = [
            "Fertilizer",
            "Insecticide",
            "Herbicides",
            "Fungicide",
            "Molliride",
            "others",
        ];

        foreach ($categories as $category) {
            Category::query()->create(['name' => $category]);
        }

        foreach ($fertilizers as $fertilizer) {
            $product = Product::query()->create([
                'internal_id' => 'SBP-' . Product::getNoCollisionID(),
                'name' => $fertilizer['name'],
                'stock_qty' => 100,
                'barcode' => 'FRT' . random_int(10000, 99999),
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'Fertilizer')->first()->id,
            ]);

            ItemOverhead::query()->create([
                'product_id' => $product->id,
                'profit' => $fertilizer['profit'],
                'base' => $fertilizer['base_price'],
            ]);
        }

        foreach ($Insecticide as $seed) {
            $product = Product::query()->create([
                'internal_id' => 'SBP-' . Product::getNoCollisionID(),
                'name' => $seed['name'],
                'stock_qty' => 100,
                'barcode' => 'INS' . random_int(10000, 99999),
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'Insecticide')->first()->id,
            ]);

            ItemOverhead::query()->create([
                'product_id' => $product->id,
                'profit' => $seed['profit'],
                'base' => $seed['base_price'],
            ]);
        }

        foreach ($herbicides as $herbicide) {
            $product = Product::query()->create([
                'internal_id' => 'SBP-' . Product::getNoCollisionID(),
                'name' => $herbicide['name'],
                'stock_qty' => 100,
                'barcode' => 'HRB' . random_int(10000, 99999),
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'Herbicides')->first()->id,
            ]);

            ItemOverhead::query()->create([
                'product_id' => $product->id,
                'profit' => $herbicide['profit'],
                'base' => $herbicide['base_price'],
            ]);
        }

        foreach ($fungicides as $equipment) {
            $product = Product::query()->create([
                'internal_id' => 'SBP-' . Product::getNoCollisionID(),
                'name' => $equipment['name'],
                'stock_qty' => 100,
                'barcode' => 'FNG' . random_int(10000, 99999),
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'Fungicide')->first()->id,
            ]);

            ItemOverhead::query()->create([
                'product_id' => $product->id,
                'profit' => $equipment['profit'],
                'base' => $equipment['base_price'],
            ]);
        }

        foreach ($molliride as $green) {
            $product = Product::query()->create([
                'internal_id' => 'SBP-' . Product::getNoCollisionID(),
                'name' => $green['name'],
                'stock_qty' => 100,
                'barcode' => 'MOL' . random_int(10000, 99999),
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'Molliride')->first()->id,
            ]);

            ItemOverhead::query()->create([
                'product_id' => $product->id,
                'profit' => $green['profit'],
                'base' => $green['base_price'],
            ]);
        }

        foreach ($vegetableSeeds as $seed) {
            $product = Product::query()->create([
                'internal_id' => 'SBP-' . Product::getNoCollisionID(),
                'name' => $seed['name'],
                'stock_qty' => 100,
                'barcode' => 'VEG' . random_int(10000, 99999),
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'others')->first()->id,
            ]);

            ItemOverhead::query()->create([
                'product_id' => $product->id,
                'profit' => $seed['profit'],
                'base' => $seed['base_price'],
            ]);
        }

        // NOTE: Manager account
        User::create([
            'first_name' => 'Seed',
            'middle_name' => null,
            'last_name' => 'User',
            'email' => 'wms@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '09508710378',
            'system_role_id' => $role->id,
            'employee_role_id' => $emp_role->id,
        ]);

        // NOTE: Admin account
        User::create([
            'first_name' => 'Seed',
            'middle_name' => null,
            'last_name' => 'User',
            'email' => 'adm@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '09508710377',
            'system_role_id' => $admin_role->id,
            'employee_role_id' => $emp_role->id,
        ]);
    }
}
