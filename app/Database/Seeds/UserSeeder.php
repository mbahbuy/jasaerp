<?php 
namespace App\Database\Seeds;

class UserSeeder extends \CodeIgniter\Database\Seeder{
    public function run(){
        $userModel = model('Myth\Auth\Models\UserModel');
        $authorization = service('authorization');
        
        $userModel->insert([
            'name' => 'Admin',
            'parent_id' => 0,
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'initial' => 'adm',
            'password_hash' => \Myth\Auth\Password::hash('admin12345'),
            'active' => 1,
        ]);
        $authorization->addUserToGroup($userModel->insertID(), 'admin');

        
        $userModel->insert([
            'name' => 'Redaktur',
            'parent_id' => 1,
            'username' => 'redaktur',
            'email' => 'redaktur@gmail.com',
            'initial' => 'rdtr',
            'password_hash' => \Myth\Auth\Password::hash('redaktur12345'),
            'active' => 1,
        ]);
        $authorization->addUserToGroup($userModel->insertID(), 'redaktur');

        $userModel->insert([
            'name' => 'Contributor',
            'parent_id' => 2,
            'username' => 'contributor',
            'email' => 'contributor@gmail.com',
            'initial' => 'ctr',
            'password_hash' => \Myth\Auth\Password::hash('contributor12345'),
            'active' => 1,
        ]);
        $authorization->addUserToGroup($userModel->insertID(), 'contributor');

        $userModel->insert([
            'name' => 'Kariawan',
            'parent_id' => 2,
            'username' => 'kariawan',
            'email' => 'kariawan@gmail.com',
            'initial' => 'krwn',
            'password_hash' => \Myth\Auth\Password::hash('kariawan12345'),
            'active' => 1,
        ]);
        $authorization->addUserToGroup($userModel->insertID(), 'kariawan');

    }
}