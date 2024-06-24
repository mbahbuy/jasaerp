<?php

namespace App\Controllers\Dashboard\Preference;

use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Config\Database;

class UserController extends BaseController
{
    protected $user, $db, $authorization;

    public function __construct()
    {
        $this->user = new UserModel();
        $this->authorization = service('authorization');
        $this->db = Database::connect();

        session();
    }

    public function index()
    {
        $auth = service('authorization');
        if( in_groups('admin', user_id())){
            $dataRow = $this->db->table('users u')
            ->select('u.id, u.name, u.email, u.initial, u.phone, u.username, g.name AS role, u.status')
            ->join('auth_groups_users gs', 'gs.user_id = u.id', 'inner')
            ->join('auth_groups g', 'g.id = gs.group_id', 'left')
            ->where('parent_id', user_id());
            $data = $dataRow->orderBy('id', 'ASC')->get()->getResult();
            $invaliteRole = 'invalid role(role hanya boleh di isi dengan redaktur, contributor dan editor).';

            return view('dashboard/preference/user', [
                'title' => 'User',
                'hal' => 'preference/user',
                'data' => $data,
                'role' => $auth->groups(),
                'invaliteRole' => $invaliteRole,
            ]);
        } elseif( in_groups('redaktur', user_id())) {
            $dataRow = $this->db->table('users u')
            ->select('u.id, u.name, u.email, u.initial, u.phone, u.username, g.name AS role, u.status')
            ->join('auth_groups_users gs', 'gs.user_id = u.id', 'inner')
            ->join('auth_groups g', 'g.id = gs.group_id', 'left')
            ->where('parent_id', user_id());
            $data = $dataRow->orderBy('id', 'ASC')->get()->getResult();
            $invaliteRole = 'invalid role(role hanya boleh di isi dengan contributor dan kariawan).';

            return view('dashboard/preference/user', [
                'title' => 'User',
                'hal' => 'preference/user',
                'data' => $data,
                'role' => $auth->groups(),
                'invaliteRole' => $invaliteRole,
            ]);
        } else {
                    // Set a 403 status code
            return $this->response->setStatusCode(403)
                ->setJSON(['message' => 'Access Forbidden']);
        }
    }

    public function json()
    { // get data name, username, initial, email for check unique
        $dataRow = $this->db->table('users u')
        ->select('u.name, u.email, u.initial, u.username')
        ->where('parent_id', 'user_id');
        $data = $dataRow->get()->getResult();
        return $this->response->setJSON($data);
    }

    public function store()
    {
        // Validation rules
        $validationRules = [
            'name' => 'required|max_length[225]',
            'username' => 'required|is_unique[users.username]|max_length[225]',
            'email' => 'required|is_unique[users.email]|max_length[225]',
            'initial' => 'required|max_length[25]',
            'role' => 'required|is_not_unique[auth_groups.name]',
            'phone'    => 'permit_empty', // Adjust the validation rule for phone number accordingly
            'pass'     => 'required|min_length[8]',
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar berita.',
            'max_lenght' => '{field} melebihi dari jumlah huruf yang ditentukan',
            'min_lenght' => '{field} kurang dari jumlah huruf yang ditentukan',
            'is_not_unique' => 'Data tidak terdaftar dalam database.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        $dataStore = [];

        $dataStore['parent_id'] = user_id();
        $dataStore['name'] = $this->request->getVar('name');
        $dataStore['username'] = $this->request->getVar('username');
        $dataStore['initial'] = $this->request->getVar('initial');
        $dataStore['email'] = $this->request->getVar('email');
        $dataStore['phone'] = $this->request->getVar('phone') ?? '';
        $dataStore['user_hash'] = md5($dataStore['email']);
        $dataStore['password_hash'] = \Myth\Auth\Password::hash($this->request->getVar('pass'));
        $dataStore['active'] = 1;
        $dataStore['status'] = 'active';

        $this->user->insert($dataStore);
        $this->authorization->addUserToGroup($this->user->insertID(), $this->request->getVar('role'));

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => "User($dataStore[name]) telah disimpan"]);
    }

    public function update($id)
    {
        // Validation rules
        $validationRules = [
            'name' => 'required|max_length[225]',
            'username' => 'required|max_length[225]',
            'email' => 'required|max_length[225]',
            'initial' => 'required|max_length[25]',
            'role' => 'required|is_not_unique[auth_groups.name]',
            'phone'    => 'permit_empty',
            'pass'     => 'permit_empty',
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar berita.',
            'max_lenght' => '{field} melebihi dari jumlah huruf yang ditentukan',
            'min_lenght' => '{field} kurang dari jumlah huruf yang ditentukan',
            'is_not_unique' => 'Data tidak terdaftar dalam database.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        // Fetch the existing article data
        $existingUser = $this->user->find($id);

        if (!$existingUser) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'User tidak ditemukan']);
        }

        $dataUpdate = [];
        $statusUpdate = false;

        if ($this->request->getVar('name') !== '' && $this->request->getVar('name') !== $existingUser->name) {
            $dataUpdate['name'] = $this->request->getVar('name');
            $statusUpdate = true;
        }

        if ($this->request->getVar('username') !== '' && $this->request->getVar('username') !== $existingUser->username) {
            $dataUpdate['username'] = $this->request->getVar('username');
            $statusUpdate = true;
        }

        if ($this->request->getVar('initial') !== '' && $this->request->getVar('initial') !== $existingUser->initial) {
            $dataUpdate['initial'] = $this->request->getVar('initial');
            $statusUpdate = true;
        }

        if ($this->request->getVar('email') !== '' && $this->request->getVar('email') !== $existingUser->email) {
            $dataUpdate['email'] = $this->request->getVar('email');
            $dataUpdate['user_hash'] = md5($dataUpdate['email']);
            $statusUpdate = true;
        }

        if ($this->request->getVar('phone') && $this->request->getVar('phone') !== '' && $this->request->getVar('phone') !== $existingUser->phone) {
            $dataUpdate['phone'] = $this->request->getVar('phone');
            $statusUpdate = true;
        }

        if ($this->request->getVar('pass') && $this->request->getVar('pass') !== '' && \Myth\Auth\Password::verify($this->request->getVar('pass'),$existingUser->password_hash) !== true) {
            $dataUpdate['password_hash'] = \Myth\Auth\Password::hash($this->request->getVar('pass'));
            $statusUpdate = true;
        }

        if ($statusUpdate === true) {
            $this->user->update($id, $dataUpdate);
        }
        
        // Update user role
        $oldRole = $this->db->table('auth_groups g')
            ->select('g.name')
            ->join('auth_groups_users gs', 'gs.group_id = g.id', 'inner')
            ->where('gs.user_id', $id)
            ->get()
            ->getFirstRow();

        if ($this->request->getVar('role') !== $oldRole->name) {
            // Check if the new role exists before updating
            $newRoleExists = $this->db->table('auth_groups')->where('name', $this->request->getVar('role'))->countAllResults() > 0;

            if ($newRoleExists) {
                // Remove user from the old role and add to the new role
                $this->authorization->removeUserFromGroup($id, $oldRole->name);
                $this->authorization->addUserToGroup($id, $this->request->getVar('role'));
            } else {
                // Handle the case where the new role doesn't exist
                return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'New role does not exist']);
            }
        }

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => "User($existingUser->name) telah diupdate"]);
    }

    public function block($id)
    {
        // Fetch the existing article data
        $existingUser = $this->user->find($id);

        if (!$existingUser) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'User tidak ditemukan']);
        }

        $this->user->update($id, ['status' => 'blocked', 'active' => false]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => "User($existingUser->name) telah di-block"]);
    }

    public function unblock($id)
    {
        // Fetch the existing article data
        $existingUser = $this->user->find($id);

        if (!$existingUser) {
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => 'User tidak ditemukan']);
        }

        $this->user->update($id, ['status' => 'active', 'active' => true]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => "User($existingUser->name) telah di-unblock"]);
    }
}
