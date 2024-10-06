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

        $fruitSeeds = array(
            array('name' => '(Mango Seedlings - Carabao Mango (Kalabaw) (Seedlings)) East-West Seed', 'base_price' => 560.0, 'profit' => 280.0),
            array('name' => '(Mango Seedlings - Grafted mango seedlings available in nurseries) Ramgo Seeds', 'base_price' => 560.0, 'profit' => 280.0),
            array('name' => '(Papaya 100g - Sinta F1 (Hybrid Papaya)) Known-You Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Papaya 100g - Red Lady Papaya, Solo Papaya) Ramgo Seeds', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Banana Tissue-cultured - Tissue-cultured varieties (Lakatan, Saba, Cavendish)) East-West Seed', 'base_price' => 560.0, 'profit' => 280.0),
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

        $irrigationEquipment = array(
            array('name' => '(Drip Irrigation Systems Various lengths - Drip lines, pressure compensating drippers) Netafim', 'base_price' => 5600.0, 'profit' => 1120.0),
            array('name' => '(Drip Irrigation Systems N/A - Drip emitters and micro-irrigation systems) Rain Bird', 'base_price' => 5600.0, 'profit' => 1120.0),
            array('name' => '(Drip Irrigation Systems N/A - Drip tubes and accessories) Jain Irrigation', 'base_price' => 5600.0, 'profit' => 1120.0),
            array('name' => '(Drip Irrigation Systems N/A - Drip irrigation products for field crops, orchards, and vegetables) Toro', 'base_price' => 5600.0, 'profit' => 1120.0),
            array('name' => '(Sprinkler Systems N/A - Pop-up sprinklers, rotor sprinklers) Hunter Industries', 'base_price' => 8400.0, 'profit' => 1680.0),
            array('name' => '(Sprinkler Systems N/A - Sprinklers and rotor systems) Rain Bird', 'base_price' => 8400.0, 'profit' => 1680.0),
            array('name' => '(Sprinkler Systems N/A - Sprinkler systems for large-scale and small-scale agriculture) Toro', 'base_price' => 8400.0, 'profit' => 1680.0),
            array('name' => '(Sprinkler Systems N/A - Pivot and rotary sprinklers) Nelson Irrigation', 'base_price' => 8400.0, 'profit' => 1680.0),
            array('name' => '(Irrigation Controllers N/A - Smart irrigation controllers (Wi-Fi enabled)) Hunter Industries', 'base_price' => 11200.0, 'profit' => 1680.0),
            array('name' => '(Irrigation Controllers N/A - ESP series, ST8 Wi-Fi Smart Irrigation controllers) Rain Bird', 'base_price' => 11200.0, 'profit' => 1680.0),
            array('name' => '(Irrigation Controllers N/A - Precision series controllers and timers) Toro', 'base_price' => 11200.0, 'profit' => 1680.0),
            array('name' => '(Micro-Irrigation Systems N/A - Micro-sprayers, emitters, and micro-irrigation kits) Netafim', 'base_price' => 5600.0, 'profit' => 1120.0),
            array('name' => '(Micro-Irrigation Systems N/A - Micro tubes, emitters, and sprayers) Jain Irrigation', 'base_price' => 5600.0, 'profit' => 1120.0),
            array('name' => '(Micro-Irrigation Systems N/A - Mini sprinklers, sprayers, and microjets) Antelco', 'base_price' => 5600.0, 'profit' => 1120.0),
            array('name' => '(Pumps (For Irrigation) N/A - Solar-powered and electric water pumps) Grundfos', 'base_price' => 14000.0, 'profit' => 2800.0),
            array('name' => '(Pumps (For Irrigation) N/A - Submersible and solar pumps) Shakti Pumps', 'base_price' => 14000.0, 'profit' => 2800.0),
            array('name' => '(Pumps (For Irrigation) N/A - Centrifugal and submersible water pumps) Hitachi', 'base_price' => 14000.0, 'profit' => 2800.0),
            array('name' => '(Pumps (For Irrigation) N/A - Gasoline-powered water pumps) Honda', 'base_price' => 14000.0, 'profit' => 2800.0),
            array('name' => '(Filters and Fertigation Systems N/A - Sand media filters, screen filters, fertigation systems) Netafim', 'base_price' => 8400.0, 'profit' => 1680.0),
            array('name' => '(Filters and Fertigation Systems N/A - Filters for drip and sprinkler systems) Azud', 'base_price' => 8400.0, 'profit' => 1680.0),
            array('name' => '(Filters and Fertigation Systems N/A - Filtration units, fertigation systems) Jain Irrigation', 'base_price' => 8400.0, 'profit' => 1680.0),
            array('name' => '(Polyethylene Pipes and Fittings Per meter - HDPE pipes and fittings) Atlanta Industries', 'base_price' => 56.0, 'profit' => 11.2),
            array('name' => '(Polyethylene Pipes and Fittings Per meter - Pipes for irrigation systems) Neltex', 'base_price' => 56.0, 'profit' => 11.2),
            array('name' => '(Polyethylene Pipes and Fittings Per meter - Pipes used for water supply and irrigation systems) Cobra Pipes', 'base_price' => 56.0, 'profit' => 11.2),
        );

        $leafyGreens = array(
            array('name' => '(Lettuce 10g - Green Ice, Red Rapid, Romaine) East-West Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Lettuce 10g - Grand Rapids, Red Sails) Known-You Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Lettuce 10g - Cos Lettuce, Looseleaf Lettuce) Ramgo Seeds', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Kangkong (Water Spinach) 10g - Upland, Lowland Kangkong) East-West Seed', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Kangkong (Water Spinach) 10g - Upland Kangkong) Ramgo Seeds', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Basil and Other Herbs 10g - Basil, Dill, Oregano) Ramgo Seeds', 'base_price' => 168.0, 'profit' => 56.0),
            array('name' => '(Basil and Other Herbs 10g - Sweet Basil, Thai Basil) East-West Seed', 'base_price' => 168.0, 'profit' => 56.0),
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
            "Fertilizers",
            "Fruit Seeds",
            "Herbicides",
            "Irrigation Equipment",
            "Leafy Greens",
            "Vegetable Seeds",
        ];

        foreach ($categories as $category) {
            Category::query()->create(['name' => $category]);
        }

        foreach ($fertilizers as $fertilizer) {
            $product = Product::query()->create([
                'internal_id' => 'SBP-' . Product::getNoCollisionID(),
                'name' => $fertilizer['name'],
                'stock_qty' => 100,
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'Fertilizers')->first()->id,
            ]);

            ItemOverhead::query()->create([
                'product_id' => $product->id,
                'profit' => $fertilizer['profit'],
                'base' => $fertilizer['base_price'],
            ]);
        }

        foreach ($fruitSeeds as $seed) {
            $product = Product::query()->create([
                'internal_id' => 'SBP-' . Product::getNoCollisionID(),
                'name' => $seed['name'],
                'stock_qty' => 100,
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'Fruit Seeds')->first()->id,
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
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'Herbicides')->first()->id,
            ]);

            ItemOverhead::query()->create([
                'product_id' => $product->id,
                'profit' => $herbicide['profit'],
                'base' => $herbicide['base_price'],
            ]);
        }

        foreach ($irrigationEquipment as $equipment) {
            $product = Product::query()->create([
                'internal_id' => 'SBP-' . Product::getNoCollisionID(),
                'name' => $equipment['name'],
                'stock_qty' => 100,
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'Irrigation Equipment')->first()->id,
            ]);

            ItemOverhead::query()->create([
                'product_id' => $product->id,
                'profit' => $equipment['profit'],
                'base' => $equipment['base_price'],
            ]);
        }

        foreach ($leafyGreens as $green) {
            $product = Product::query()->create([
                'internal_id' => 'SBP-' . Product::getNoCollisionID(),
                'name' => $green['name'],
                'stock_qty' => 100,
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'Leafy Greens')->first()->id,
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
                'is_suspended' => false,
                'category_id' => Category::query()->where('name', '=', 'Vegetable Seeds')->first()->id,
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

        // Product::factory(50)->create();
        // function generateRandomFloat($min, $max)
        // {
        //     return $min + mt_rand() / mt_getrandmax() * ($max - $min);
        // }

        // foreach (Product::all() as $product) {
        //     $base = generateRandomFloat(100, 30);
        //     $profit = generateRandomFloat(100, 30);

        //     ItemOverhead::query()->create([
        //         'base' => $base,
        //         'profit' => $profit,
        //         'product_id' => $product->id,
        //     ]);
        // }
    }
}
