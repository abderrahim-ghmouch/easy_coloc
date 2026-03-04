<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Colocation;
use App\Models\ColocationMember;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users
        $admin = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@easycoloc.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
            'status' => 'ACTIVE',
        ]);

        $owner = User::factory()->create([
            'name' => 'Sarah Connor',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password'),
            'role' => 'USER',
            'status' => 'ACTIVE',
        ]);

        $member1 = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'USER',
            'status' => 'ACTIVE',
        ]);

        $member2 = User::factory()->create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'USER',
            'status' => 'ACTIVE',
        ]);

        // 2. Create a Colocation
        $coloc = Colocation::create([
            'name' => 'Cyberdyne Heights',
            'description' => 'Main operations base for the resistance.',
            'status' => 'ACTIVE',
        ]);

        // 3. Add Members to Colocation
        ColocationMember::create([
            'user_id' => $owner->id,
            'colocation_id' => $coloc->id,
            'role' => 'Owner',
        ]);

        ColocationMember::create([
            'user_id' => $member1->id,
            'colocation_id' => $coloc->id,
            'role' => 'Member',
        ]);

        ColocationMember::create([
            'user_id' => $member2->id,
            'colocation_id' => $coloc->id,
            'role' => 'Member',
        ]);

        // 4. Create Categories
        $categories = [
            ['name' => 'Groceries', 'description' => 'Food and household supplies'],
            ['name' => 'Utilities', 'description' => 'Electricity, water, and internet'],
            ['name' => 'Maintenance', 'description' => 'Repairs and cleaning services'],
            ['name' => 'Entertainment', 'description' => 'Subscriptions and shared events'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'description' => $cat['description'],
                'colocation_id' => $coloc->id,
            ]);
        }

        // 5. Create Expenses
        $groceryCat = Category::where('name', 'Groceries')->first();
        $utilityCat = Category::where('name', 'Utilities')->first();

        $expense1 = Expense::create([
            'title' => 'Weekly Supplies',
            'amount' => 120.00,
            'category_id' => $groceryCat->id,
            'creator_member_id' => 1, // First member (Owner)
        ]);

        $expense2 = Expense::create([
            'title' => 'Optic Fiber Internet',
            'amount' => 45.00,
            'category_id' => $utilityCat->id,
            'creator_member_id' => 2, // John Doe
        ]);

        // Create Details for Expenses
        foreach ([$expense1, $expense2] as $expense) {
            $members = $coloc->members;
            $share = round($expense->amount / $members->count(), 2);
            
            foreach ($members as $m) {
                if ($m->id != $expense->creator_member_id) {
                    $expense->details()->create([
                        'debtor_member_id' => $m->id,
                        'amount' => $share,
                        'status' => 'PENDING',
                    ]);
                }
            }
        }
    }
}
