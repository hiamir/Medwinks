<?php

namespace App\Http\Livewire\Admin\Countries;

use App\Http\Livewire\Authenticate;
use App\Models\Country;
use App\Models\Region;
use App\Models\Timezone;
use App\Traits\Data;
use App\Traits\Submit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Datatable extends Authenticate
{
    use WithPagination;
    use Submit;
    use Data;

    public $countryID, $regionID;

    protected $listeners = ['myController'];

    public

        $myModal = [],
        $country = [],
        $region = [];

    public function mount(Request $request)
    {
        $this->resetForm('country');
        $this->resetForm('region');
    }

    protected $messages = [
        'country.name.required' => ':attribute name is required',
        'country.name.alpha' => ':attribute must be alphabets only',
        'country.name.min' => ':attribute must be 4 characters long',
        "country.iso.required" => "ISO is required",
        "country.iso.alpha" => "ISO must be alphabets",
        "country.iso.min" => "ISO requires minimum  2 characters",
        "country.iso.max" => "ISO requires maximum 2 characters",
        "country.iso.unique" => "ISO already exists",
        "country.iso3.required" => "ISO3 is required",
        "country.iso3.alpha" => "ISO must be alphabets",
        "country.iso3.min" => "ISO3 requires minimum  3 characters",
        "country.iso3.max" => "ISO3 requires maximum 3 characters",
        "country.iso3.unique" => "ISO3 already exists",
        "country.fips.required" => "Fips is required",
        "country.fips.alpha" => "Fips must be alphabets",
        "country.fips.min" => "Fips requires minimum characters",
        "country.fips.max" => "Fips requires maximum 2 characters",
        "country.fips.unique" => "Fips already exists",
        "country.continent.required" => "Continent is required",
        "country.continent.alpha" => "Continent must be alphabets",
        "country.continent.min" => "Continent requires minimum characters",
        "country.continent.max" => "Continent requires  maximum 2 characters",
        "country.currency_code.required" => "Continent is required",
        "country.currency_code.alpha" => "Currency Code must be alphabets",
        "country.currency_code" => "Currency Code must be alphabets",
        "country.currency_code.min" => "Continent requires minimum 3 characters",
        "country.currency_code.max" => "Continent requires maximum 3 characters",
        "country.currency_name.required" => "Continent is required",
        "country.currency_name.min" => "Continent requires minimum 2 characters",
        "country.languages.required" => "Languages is required",
        "country.languages.regex" => "Languages must only have alhpa characters and dash",
        "country.phone_prefix.required" => "Phone prefix is required",
        "country.phone_prefix.min" => "Phone prefix requires minimum 2 characters",
        "country.phone_prefix.regex" => "Phone prefix must only contain integers [0-9], +, -",
        "country.geonameid.required" => ":attribute is required",
        "country.geonameid.numeric" => "Geonameid must be integer",
        "country.geonameid.unique" => ":attribute is already taken",

        'region.name.required' => ':attribute name is required',
        'region.name.min' => ':attribute must be 4 characters long',
        'region.timezone.required' => ':attribute is required',
    ];

    public function myController($value)
    {
        $this->myModal = $value;
        switch ($value['model']) {
            case 'country':
                if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                    $this->countryID = $value['record']['formData']['id'];
                    $this->record = Country::where('id', $this->countryID)->first();
                }
                switch ($value['formType']) {
                    case'country':
                        switch ($value['modalType']) {
                            case 'add':
                                $this->resetForm('country');
                                $this->record = new Country();
                                break;
                            case 'update':
                                $this->resetErrorBag();
                                $this->country['name'] = $value['record']['formData']['name'];
                                $this->country['continent'] = $value['record']['formData']['continent'];
                                $this->country['currency_code'] = $value['record']['formData']['currency_code'];
                                $this->country['currency_name'] = $value['record']['formData']['currency_name'];
                                $this->country['phone_prefix'] = $value['record']['formData']['phone_prefix'];
                                $this->country['postal_code'] = $value['record']['formData']['postal_code'];
                                $this->country['languages'] = $value['record']['formData']['languages'];
                                $this->country['iso'] = $value['record']['formData']['iso'];
                                $this->country['iso3'] = $value['record']['formData']['iso3'];
                                $this->country['fips'] = $value['record']['formData']['fips'];
                                $this->country['geonameid'] = $value['record']['formData']['geonameid'];
                                break;
                            case 'delete':
                                break;
                        }
                        break;

                    case 'region':
                        if ($value['modalType'] === 'update' || $value['modalType'] === 'delete') {
                            $this->regionID = $value['record']['formData']['id'];
                            $this->record = Region::where('id', $this->regionID)->first();
                        }
                        switch ($value['modalType']) {
                            case 'add':
                                $this->resetForm('region');
                                $this->record = new Region();
                                $this->region['country_id'] = $value['record']['country']['id'];
                                break;
                            case 'update':
                                $this->resetErrorBag();

                                $this->region['name'] = $value['record']['formData']['name'];
                                $this->region['country_id'] = $value['record']['formData']['country_id'];
                                $this->region['timezone_id'] = $value['record']['formData']['timezone_id'];
                                break;
                            case 'delete':
                                break;
                        }
                        break;
                }
        }
    }

    public function submit()
    {
        switch ($this->myModal['model']) {
            case 'country':
                switch ($this->myModal['formType']) {
                    case 'country':
                        $this->submitForm($this, 'country', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->country, $this->countryRules());
                        break;

                    case 'region':
                        $this->submitForm($this, 'country', $this->myModal['modalType'], $this->myModal['formType'], $this->record, $this->region, $this->regionRules());
                        break;
                }
                break;
        }
    }

    public function render()
    {
        if ($this->permission('admin-countries-view')) {
            $timezone = $this->timezone_for_select();
            $records = Country::with('regions')->orderBy('updated_at', 'desc')->paginate(20);
            return view('livewire.admin.countries.datatable', ['records' => $records, 'timezone' => $timezone]);
        } else {
            return view('livewire.errors.access-denied', ['name' => 'Countries']);
        }


    }

    protected function countryRules()
    {
        return [
            'country.name' => 'required|min:4|unique:countries,name,' . $this->countryID,
            'country.iso' => 'required|alpha|min:2|max:2|unique:countries,iso,' . $this->countryID,
            'country.iso3' => 'required|alpha|min:3|max:3|unique:countries,iso3,' . $this->countryID,
            'country.fips' => 'required|alpha|min:2|max:2|max:2|unique:countries,fips,' . $this->countryID,
            'country.continent' => 'required|alpha||min:2|max:2',
            'country.currency_code' => 'alpha|min:3|max:3',
            'country.currency_name' => 'min:2',
            'country.phone_prefix' => 'min:2|regex:/^([0-9\s\-\+\(\)]*)$/',
            'country.postal_code' => '',
            'country.languages' => 'regex:/^[A-Za-z,\-]+$/',
            'country.geonameid' => 'required|numeric|unique:countries,geonameid,' . $this->countryID,
        ];
    }

    protected function regionRules()
    {
        return [
            'region.name' => 'required|min:4',
            'region.timezone_id' => 'required'

        ];
    }

    protected function validationAttributes()
    {
        return [
            'country.name' => ($this->country['name'] != '') ? $this->country['name'] : 'Country',
            'country.position' => ($this->country['name'] != '') ? $this->country['name'] : 'Country',
            'country.geonameid' => ($this->country['geonameid'] != '') ? $this->country['geonameid'] : 'Geonameid',

            'region.name' => ($this->region['name'] != '') ? $this->region['name'] : 'Region',
            'region.timezone_id' => 'Timezone',
        ];
    }

    public function resetForm($form)
    {
        switch ($form) {
            case 'country':
                $this->country = ['name' => '', 'continent' => '', 'currency_code' => '', 'currency_name' => '', 'phone_prefix' => '', 'postal_code' => '',
                    'languages' => '', 'iso' => '', 'iso3' => '', 'fips' => '', 'geonameid' => '', 'updated_at' => ''];
                break;

            case 'region':
                $this->region = ['name' => '', 'country_id' => '', 'timezone_id' => ''];
                break;
        }
    }
}
