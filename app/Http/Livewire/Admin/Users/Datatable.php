<?php

namespace App\Http\Livewire\Admin\Users;

use App\Mail\ResetPassword;
use App\Mail\Welcome;
use App\Models\User;
use App\Traits\Data;
use App\Traits\Query;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rules;

class Datatable extends Component
{
    use WithPagination;
    use Data;
    use Query;

    public
        $header = null,
        $modalType = null,
        $modalSize = 'medium',
        $openModal = true,
        $confirmModalStatus = true,
        $toastAlert = [],
        $record,
        $rolePermissions,
        $allRolePermissions,
        $permissions,
        $userID,
        $user = ['name' => '', 'email' => ''];


    protected $messages = [
        'user.name.required' => 'The Name cannot be empty.',
        'user.name.string' => ':attribute must be a string.',
        'user.name.min' => 'The Name must have minimum 4 characters.',
        'user.name.max' => ':attribute cannot exceed more than 255 characters.',
        'user.email.required' => 'The Email Address cannot be empty.',
        'user.email.string' => ':attribute Email must be a string.',
        'user.email.max' => ':attribute cannot exceed more than 255 characters.',
        'user.email.email' => ':attribute is not a valid email Address.',
        'user.email.unique' => ':attribute Email Address already exists!.',
        'user.password.required' => 'The Password cannot be empty.',
        'user.password.confirmed' => 'The two Password do not match.',
    ];

    public function addButton()
    {
        $this->reset();
        $this->modalType = 'add';
        $this->modalSize = 'medium';
        $this->header = "Add User";
        $this->record = new User();

    }


    public function editButton($id)
    {
        $this->resetErrorBag();
        $this->modalType = 'update';
        $this->modalSize = 'medium';
        $this->header = "Update User";
        $this->userID = $id;
        $this->record = User::where('id', $id)->first();
        $this->user['id'] = $this->record->id;
        $this->user['name'] = $this->record->name;
        $this->user['email'] = $this->record->email;
    }

    public function deleteButton($id)
    {
        $this->modalType = 'delete';
        $this->header = "Delete User";
        $this->userID = $id;
        $this->record = User::where('id', $id)->first();
    }

    public function passwordButton($id)
    {
        $this->modalType = 'reset_password';
        $this->header = "Reset password";
        $this->userID = $id;
        $this->record = User::where('id', $id)->first();
    }


    public function submit()
    {

        switch ($this->modalType) {
            case 'add':
            case 'update':
                $this->validate();
                $this->record->name = Data::capitalize_each_word($this->user['name']);
                $this->record->email = $this->user['email'];
                if($this->modalType =='add'){
                    $password=Data::generate_password();
                    $this->record->password = Hash::make($password);
                    $this->record->save();
                    Mail::to($this->record->email)->send(new Welcome($this->record->name, $this->record->email, $password));
                }else{
                    $this->record->save();
                }
                $this->openModal = false;
                ($this->modalType == 'add') ? $this->toastAlert = ['alert' => 'success', 'message' => $this->record->name . ' added successfully!'] : $this->toastAlert = ['alert' => 'success', 'message' => $this->record->name . ' updated successfully!'];
                break;

            case 'delete':
                $this->record->delete();
                $this->confirmModalStatus = !$this->confirmModalStatus;
                $this->toastAlert = ['alert' => 'danger', 'message' => $this->record->name . ' deleted successfully!'];
                break;

            case 'reset_password':
                $password = Data::generate_password();
                $this->record->password = Hash::make($password);
                $this->record->save();
                Mail::to($this->record->email)->send(new ResetPassword($this->record->name, $this->record->email, $password));
                $this->confirmModalStatus = !$this->confirmModalStatus;
                $this->toastAlert = ['alert' => 'success', 'message' => 'Password was rest for ' . $this->record->name];
                break;

        }

    }

    public function render()
    {
        $records = User::paginate(10);
        return view('livewire.admin.users.datatable', ['records' => $records]);


    }

    protected function rules()
    {
        return [
            'user.name' => 'required|min:4',
            'user.email' => 'required|email|unique:users,email,' . $this->userID,
//            'user.password' => 'required', 'confirmed',Password::defaults()
        ];
    }

    protected function validationAttributes()
    {
        return [
            'user.name' => $this->user['name'],
            'user.email' => $this->user['email'],
        ];
    }

}
