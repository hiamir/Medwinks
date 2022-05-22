<?php

namespace App\Http\Livewire\User\Documents;

use App\Http\Livewire\Authenticate;
use App\Models\ServiceRequirement;
use App\Traits\Data;
use App\Traits\Datatable\DocumentDatable;
use App\Traits\Datatable\DocumentPassportCommon;
use App\Traits\Datatable\PassportDatable;
use App\Traits\Submit;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Datatable extends Authenticate
{
    use DocumentPassportCommon;
    use DocumentDatable;
    use WithPagination;
    use WithFileUploads;
    use Submit;
    use Data;

    protected $listeners = ['myController', 'refreshPassportComponent' => '$refresh'];



    public function render()
    {
        if ($this->permission('user-document-view')) {
            $this->documentType='document';
//            $requirements=ServiceRequirement::all();
            $records = ServiceRequirement::with(['documents' => function ($q) {
                $q->with('applications')->where('user_id', auth()->user()->id);
            }])->orderBy('created_at', 'asc')->paginate(10);
            return view('livewire.user.documents.datatable', ['records' => $records]);
        } else {
            return view('livewire.errors.access-denied', ['name' => 'documents']);
        }
    }
}
