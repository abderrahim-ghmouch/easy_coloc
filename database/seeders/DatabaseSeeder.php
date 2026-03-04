<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Colocation;
use App\Models\ColocationMember;
use App\Models\Category;
use App\Models\Expense;
use App\Models\ExpenseDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create System Administrator
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@easycoloc.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
            'status' => 'ACTIVE',
        ]);

        // 2. Create Test Users
        $users = User::factory(10)->create([
            'password' => Hash::make('password'),
            'role' => 'USER',
            'status' => 'ACTIVE',
        ]);

        // 3. Create Multiple Colocations
        Colocation::factory(5)->create()->each(function ($colocation) use ($users) {
            // Pick a random owner from users
            $owner = $users->random();
            
            ColocationMember::create([
                'user_id' => $owner->id,
                'colocation_id' => $colocation->id,
                'role' => 'Owner',
            ]);

            // Add 2-4 more random members
            $members = $users->where('id', '!=', $owner->id)->random(rand(2, 4));
            
            foreach ($members as $user) {
                ColocationMember::create([
                    'user_id' => $user->id,
                    'colocation_id' => $colocation->id,
                    'role' => 'Member',
                ]);
            }

            // Create Categories for this colocation
            $categories = Category::factory(4)->create([
                'colocation_id' => $colocation->id,
            ]);

            // Create Expenses for this colocation
            $allMembers = $colocation->members;
            
            Expense::factory(15)->create([
                'category_id' => function () use ($categories) {
                    return $categories->random()->id;
                },
                'creator_member_id' => function () use ($allMembers) {
                    return $allMembers->random()->id;
                },
            ])->each(function ($expense) use ($allMembers) {
                // Split the expense among members (excluding the creator)
                $debtors = $allMembers->where('id', '!=', $expense->creator_member_id);
                $share = round($expense->amount / $allMembers->count(), 2);

                foreach ($debtors as $debtor) {
                    ExpenseDetail::create([
                        'expense_id' => $expense->id,
                        'debtor_member_id' => $debtor->id,
                        'amount' => $share,
                        'status' => rand(0, 1) ? 'PAID' : 'PENDING',
                    ]);
                }
            });
        });
    }
}
