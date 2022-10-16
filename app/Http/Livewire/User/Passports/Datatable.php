<?php

namespace App\Http\Livewire\User\Passports;

use App\Http\Livewire\Authenticate;
use App\Models\Country;
use App\Models\Passport;
use App\Traits\Data;
use App\Traits\Datatable\DocumentPassportCommon;
use App\Traits\Datatable\PassportDatable;
use App\Traits\Submit;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Datatable extends Authenticate
{
    use DocumentPassportCommon;
    use PassportDatable;
    use WithPagination;
    use WithFileUploads;
    use Submit;
    use Data;

    protected $listeners = ['myController', 'refreshPassportComponent' => '$refresh'];

    public function render()
    {
        if ($this->permission('user-passport-view')) {
            $this->documentType='passport';
            $countries = Country::select('id', 'name')->get();
            switch ($this->userRoles()['active']) {
                case 'userRoleActive':
                    if (in_array('manager', $this->userRoles()['roles'])) {
                        $records = Passport::with('applications')->where('user_id', auth()->user()->id)->orderBy('active', 'DESC')
                            ->orderBy('accepted', 'DESC')->orderBy('revision', 'DESC')->orderBy('rejected', 'DESC')->paginate(20);
                    } else {
                        $records = Passport::with('applications')->where('user_id', auth()->user()->id)->orderBy('active', 'DESC')->paginate(20);
                    }
                    return view('livewire.user.passports.datatable', ['records' => $records, 'countries' => $countries]);
                default:
                    return view('livewire.errors.access-denied', ['name' => 'passports']);
            }
        }
    }
}
