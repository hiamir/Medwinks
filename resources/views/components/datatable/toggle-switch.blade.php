@props(['id','size'])

<label
    x-init="
                    collection=selectedParentChildIDs
                     $watch('parentID',function(value){
                        collection=selectedParentChildIDs
                     });
                    $watch('collection',function(value){
                        selected=JSON.stringify(value)
                    });
            "
    for="{{$id}}"
       {{$attributes->merge(['class'=>'relative inline-flex items-center mb-4 cursor-pointer'])}}
       >
    <x-forms.toggle x-model="collection" id="{{$id}}" size="{{$size}}"></x-forms.toggle>
    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{$slot}}</span>
</label>


