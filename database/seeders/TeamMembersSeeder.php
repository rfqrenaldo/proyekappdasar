<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team_member;

class TeamMembersSeeder extends Seeder
{
    public function run()
    {
        $teamMembers = [
            ['id' => 1, 'member_id' => 1, 'team_id' => 1, 'role' => 'pm'],
        ['id' => 2, 'member_id' => 2, 'team_id' => 1, 'role' => 'fe'],
        ['id' => 3, 'member_id' => 3, 'team_id' => 1, 'role' => 'be'],
        ['id' => 4, 'member_id' => 4, 'team_id' => 1, 'role' => 'ui_ux'],

        ['id' => 5, 'member_id' => 5, 'team_id' => 2, 'role' => 'pm'],
        ['id' => 6, 'member_id' => 6, 'team_id' => 2, 'role' => 'fe'],
        ['id' => 7, 'member_id' => 7, 'team_id' => 2, 'role' => 'be'],
        ['id' => 8, 'member_id' => 8, 'team_id' => 2, 'role' => 'ui_ux'],

        ['id' => 9, 'member_id' => 9, 'team_id' => 3, 'role' => 'pm'],
        ['id' => 10, 'member_id' => 10, 'team_id' => 3, 'role' => 'fe'],
        ['id' => 11, 'member_id' => 11, 'team_id' => 3, 'role' => 'be'],
        ['id' => 12, 'member_id' => 12, 'team_id' => 3, 'role' => 'ui_ux'],

        ['id' => 13, 'member_id' => 13, 'team_id' => 4, 'role' => 'pm'],
        ['id' => 14, 'member_id' => 14, 'team_id' => 4, 'role' => 'fe'],
        ['id' => 15, 'member_id' => 15, 'team_id' => 4, 'role' => 'be'],
        ['id' => 16, 'member_id' => 16, 'team_id' => 4, 'role' => 'ui_ux'],

        ['id' => 17, 'member_id' => 17, 'team_id' => 5, 'role' => 'pm'],
        ['id' => 18, 'member_id' => 18, 'team_id' => 5, 'role' => 'fe'],
        ['id' => 19, 'member_id' => 19, 'team_id' => 5, 'role' => 'be'],
        ['id' => 20, 'member_id' => 20, 'team_id' => 5, 'role' => 'ui_ux'],
    ];
        foreach ($teamMembers as $teamMember) {
            Team_member::create($teamMember);
        }
    }
}
