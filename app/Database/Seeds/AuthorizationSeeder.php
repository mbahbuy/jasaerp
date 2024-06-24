<?php 
namespace App\Database\Seeds;

class AuthorizationSeeder extends \CodeIgniter\Database\Seeder{
    public function run(){
        $authorization = service('authorization');
        $groups = [
            'admin' => 'Administrator',
            'redaktur' => 'Redaktur',
            'contributor' => 'Contributor',
            'kariawan' => 'Kariawan',
        ];

        // $groupModel = model('Myth\Auth\Models\GroupModel');
        foreach ($groups as $group => $description) {
            $authorization->createGroup($group, $description);
        }

        // $permissions = [
        //     'crud_user' => 'create, read, update and delete user.',
        //     'change_template' => 'can change template for frontEnd.',
        //     'preference' => 'can use preference menu.',
        //     'report' => 'can use report menu.',
        //     'web_management' => 'can use web_management menu.',
        //     'editorial' => 'can use editorial menu.',
        //     'gallery' => 'can use gallery menu.',
            
        // ];

        // // $permissionModel = model('Myth\Auth\Models\PermissionModel');
        // foreach($permissions as $name => $description){
        //     $authorization->createPermission($name, $description);
        // }
        
        // foreach ($permissions as $key => $value) {
        //     switch ($key) {
        //         case 'crud_user':
        //             $authorization->addPermissionToGroup($key, 'admin');
        //             break;
                
        //         case 'change_template':
        //             $authorization->addPermissionToGroup($key, 'admin');
        //             $authorization->addPermissionToGroup($key, 'redaktur');
        //             break;
                
        //         case 'preference':
        //             $authorization->addPermissionToGroup($key, 'admin');
        //             $authorization->addPermissionToGroup($key, 'redaktur');
        //             break;
                
        //         case 'report':
        //             $authorization->addPermissionToGroup($key, 'admin');
        //             $authorization->addPermissionToGroup($key, 'redaktur');
        //             $authorization->addPermissionToGroup($key, 'contributor');
        //             break;
        //         default:
        //             $authorization->addPermissionToGroup($key, 'admin');
        //             $authorization->addPermissionToGroup($key, 'redaktur');
        //             $authorization->addPermissionToGroup($key, 'contributor');
        //             $authorization->addPermissionToGroup($key, 'editor');
        //             break;
        //     }
        // }
    }
}