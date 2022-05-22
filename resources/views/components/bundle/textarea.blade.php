<div {{$attributes}}>
    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" x-text="label"></label>
    <div class="flex relative">
        {{$slot}}
    </div>
    <div x-show="validationErrors !== '' ">
        <p x-show="validationErrors[livewireName]" class="mt-2 mb-0 text-xs text-red-600 dark:text-red-600"
           x-text="validationErrors[livewireName]">
        </p>
    </div>
</div>


{{--@props(['field'=>''])--}}
{{--<div {{$attributes}} >--}}
{{--    <div--}}
{{--        x-id="['input']"--}}
{{--         x-init="--}}
{{--         if (type === 'date') {--}}
{{--            flatpickr($refs.input,dateConfig)--}}
{{--         }--}}
{{--         if(Object.keys(dateConfig).length > 0 ) flatpickr($refs.inputDate,dateConfig);--}}
{{--"--}}
{{--    >--}}

{{--        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"--}}
{{--               x-text="label"></label>--}}
{{--        <div class="relative">--}}
{{--            <input x-bind="$el.inputData">--}}

{{--            <input x-show="isDate===false" x-ref="input" x-bind="input({'type':type,'disabled':disabled})">--}}

{{--            <input--}}
{{--                :id="$id('input')"--}}
{{--                x-model="xmodel"--}}
{{--    type="text"--}}
{{--                x-ref="input"--}}
{{--                class= 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'--}}
{{--                x-bind="input({--}}
{{--                                    'name':name,--}}
{{--                                    'type':type,--}}
{{--                                    'placeholder':placeholder,--}}
{{--                                    'disabled':disabled,--}}
{{--                                    'errorCount':errorCount,--}}
{{--                                    'dateConfig':dateConfig--}}
{{--                                 });--}}

{{--                   "--}}
{{--            >--}}
{{--            --}}{{--            <input--}}
{{--            --}}{{--               x-ref="input"--}}
{{--            --}}{{--               :value="(errorCount === 0) ? value.alpineValue : value.livewireValue"--}}
{{--            --}}{{--               :name="name"--}}
{{--            --}}{{--               :type="type"--}}
{{--            --}}{{--               :placeholder="placeholder"--}}
{{--            --}}{{--               :disabled="disabled"--}}
{{--            --}}{{--               class = "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"--}}
{{--            --}}{{--            >--}}
{{--            <x-svg.main x-show="Object.keys(dateConfig).length > 0" type="delete"--}}
{{--                        @click.prevent=" flatpickr($refs.input,dateConfig).clear(); "--}}
{{--                        class="flex absolute top-1/2 right-1 transform -translate-x-1 -translate-y-1/2 z-50 ml-2 dark:text-gray-400 dark:hover:text-gray-100"--}}
{{--            ></x-svg.main>--}}
{{--        </div>--}}


{{--        <p  x-show="validationErrors[livName]"  class= "mt-2 mb-0 text-xs text-red-600 dark:text-red-600" x-text="validationErrors[livName]"> </p>--}}
{{--    </template>--}}
{{--        <x-forms.form-error field="passport.date_of_birth"></x-forms.form-error>--}}
{{--    </div>--}}

{{--</div>--}}

