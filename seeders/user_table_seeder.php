<?php

declare(strict_types = 1);

use Hyperf\Database\Seeders\Seeder;
use App\Model;
use Illuminate\Hashing\BcryptHasher;

class UserTableSeeder extends Seeder {

    /**
     * @Inject 
     * @var BcryptHasher
     */
    protected $hash;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->hash = new BcryptHasher();
        Model\User::create([
            'username' => 'admin',
            'password' => $this->hash->make('123456'),
            'nick_name' => '超级管理员',
            'real_name' => '超级管理员'
        ]);
    }

}
