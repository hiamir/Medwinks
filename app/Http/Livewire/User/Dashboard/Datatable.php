<?php

namespace App\Http\Livewire\User\Dashboard;

use App\Http\Livewire\Admin\Users;
use App\Http\Livewire\Authenticate;
use App\Models\Application;
use App\Models\Country;
use App\Models\Document;
use App\Models\Passport;
use App\Models\PermissionExtends;
use App\Models\Region;
use App\Models\User;
use App\Traits\Data;
use App\Traits\Datatable\General;
use App\Traits\Submit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Datatable extends Authenticate
{
    use WithPagination;
    use General;
    use Submit;
    use Data;

    public array $chartData = ['label' => '', 'data' => ''];

    public $permissionID;

    protected $listeners = ['myController'];


    public function getChartData()
    {
        if($this->isUserManager){
            $applications = Application::
            select(
                DB::raw("COUNT(*) as count"),
                DB::raw("MONTH(created_at) as Month"),
                DB::raw("MONTHNAME(created_at) as 'Month_Name'")
            )->whereYear('created_at', Carbon::now()->year)
                ->groupBy('Month')
                ->orderBy('Month')
                ->get();


            $this->chartData = [];
            foreach ($applications as $row) {
                $this->chartData['label'][] = $row->Month_Name;
                $this->chartData['data'][] = (int)$row->count;
            }
        }else{
            $applications = Application::
            select(
                DB::raw("COUNT(*) as count"),
                DB::raw("MONTH(created_at) as Month"),
                DB::raw("MONTHNAME(created_at) as 'Month_Name'")
            )->whereYear('created_at', Carbon::now()->year)
                ->groupBy('Month')
                ->orderBy('Month')
                ->where('users_id',auth()->user()->id)
                ->get();


            $this->chartData = [];
            foreach ($applications as $row) {
                $this->chartData['label'][] = $row->Month_Name;
                $this->chartData['data'][] = (int)$row->count;
            }
        }

    }

    public function mount(Request $request)
    {
        $this->getChartData();
    }

    public function openApplication($id)
    {
        session()->put('code', $id);
        return ($this->isUserManager ?  redirect()->to('application/'.$id) : redirect()->to('application/'.$id) );
    }

    public function goApplication($code)
    {
        session()->put('code', $code);
        return ($this->isUserManager ?  redirect()->to('applications-all-submissions') : redirect()->to('applications-submissions') );
    }

    public function goDocument($code)
    {
        session()->put('code', $code);
        return ($this->isUserManager ?  redirect()->to('applications-all-documents') : redirect()->to('documents') );
    }



    public function render()
    {
        if ($this->permission('user-dashboard-view')) {
            $clients = User::select(DB::raw("COUNT(*) AS clientsCount"))
                ->whereHas('applications')->first();


            if ($this->isUserManager) {
                $documentsRevisionCount=count(Document::where('accepted',0)->where('rejected',0)->where('revision',0)->get());

                $newApplicationsCount=count(Application::where('accepted',0)->where('rejected',0)->where('revision',0)->get());
                $applications = Application::
                select(DB::raw("COUNT(*) AS applicationCount"))
                    ->selectRaw("
                        SUM(CASE WHEN (applications.accepted = '0' AND applications.revision = '0' AND applications.rejected = '0') THEN 1 ELSE 0 END) AS newCount,
                        SUM(CASE WHEN applications.accepted = '1' THEN 1 ELSE 0 END) AS acceptedCount,
                        SUM(CASE WHEN applications.revision = '1' THEN 1 ELSE 0 END) AS revisionCount,
                        SUM(CASE WHEN applications.rejected = '1' THEN 1 ELSE 0 END) AS rejectedCount
                        ")
                    ->first();

                if($applications->acceptedCount === null)  $applications->acceptedCount=0;
                if( $applications->revisionCount === null )  $applications->revisionCount=0;
                if($applications->rejectedCount === null )  $applications->rejectedCount=0;

                $attentionPassport=User::Wherehas('passports',function($p){
                    $p->where('active',1)->whereDate('expiry_date', '<', now());
                })->get();
                $documentAction= Document::with(['user','serviceRequirement','comments'])->where('accepted',0)->where('revision',0)->where('rejected',0)->orderBy('updated_at','desc')->get();

                $latest = Application::with(['service', 'user'])->orderBy('created_at', 'desc')->get()->take(5);
                return view('livewire.user.dashboard.datatable', ['clients' => $clients, 'applications' => $applications, 'latest' => $latest,
                    'newApplicationCount'=>$newApplicationsCount,'documentsRevisionCount'=>$documentsRevisionCount,'attentionPassport'=>$attentionPassport,'documentAction'=>$documentAction]);
            } else {
                $documentsRevisionCount=count(Document::where('user_id',auth()->user()->id)->where('revision',1)->get());
                $newApplicationsCount=count(Application::where('accepted',0)->where('rejected',0)->where('revision',0)->where('users_id', auth()->user()->id)->get());
                $applications = Application::
                select(DB::raw("COUNT(*) AS applicationCount"))
                    ->selectRaw("
                        SUM(CASE WHEN (applications.accepted = '0' AND applications.revision = '0' AND applications.rejected = '0') THEN 1 ELSE 0 END) AS newCount,
                        SUM(CASE WHEN applications.accepted = '1' THEN 1 ELSE 0 END) AS acceptedCount,
                        SUM(CASE WHEN applications.revision = '1' THEN 1 ELSE 0 END) AS revisionCount,
                        SUM(CASE WHEN applications.rejected = '1' THEN 1 ELSE 0 END) AS rejectedCount
                        ")
                    ->where('users_id', auth()->user()->id)->first();
                if($applications->acceptedCount === null)  $applications->acceptedCount=0;
                if( $applications->revisionCount === null )  $applications->revisionCount=0;
                if($applications->rejectedCount === null )  $applications->rejectedCount=0;

                $attentionPassport=Passport::where('user_id',auth()->user()->id)->first();
               $documentAction= Document::with(['serviceRequirement','comments'])->where('user_id',auth()->user()->id)->where('accepted',0)->where('revision',1)->where('rejected',0)->get();


                $latest = Application::with(['service', 'user'])->orderBy('created_at', 'desc')->where('users_id', auth()->user()->id)->get()->take(5);

                return view('livewire.user.dashboard.datatable', ['clients' => $clients, 'applications' => $applications,
                    'latest' => $latest,'newApplicationCount'=>$newApplicationsCount,'documentsRevisionCount'=>$documentsRevisionCount,'attentionPassport'=>$attentionPassport,'documentAction'=>$documentAction]);
            }


        } else {
            return view('livewire.errors.access-denied', ['name' => 'Dashboard']);
        }


    }


}
