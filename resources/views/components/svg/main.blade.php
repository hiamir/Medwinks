@props(['type'=>null,'class'=>null])
@switch ($type)
    @case('home')
        <x-svg.heroicons.home {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.home>
    @break

    @case('user')
    <x-svg.heroicons.user {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.user>
    @break

    @case('security')
    <x-svg.heroicons.security {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.security>
    @break

    @case('bolt')
    <x-svg.heroicons.bolt {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.bolt>
    @break

    @case('navigation')
    <x-svg.heroicons.navigation {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.navigation>
    @break

    @case('arrow-up')
    <x-svg.heroicons.arrow-up {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.arrow-up>
    @break

    @case('arrow-down')
    <x-svg.heroicons.arrow-down {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.arrow-down>
    @break

    @case('setting')
    <x-svg.heroicons.setting {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.setting>
    @break

    @case('link')
    <x-svg.heroicons.link {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.link>
    @break

    @case('data')
    <x-svg.heroicons.data {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.data>
    @break

    @case('refresh')
    <x-svg.heroicons.refresh {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.refresh>
    @break

    @case('arrow-circle-down')
    <x-svg.heroicons.arrow-circle-down {{$attributes->merge(['class'=>'flex inline-flex h-8 w-8 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.arrow-circle-down>
    @break

    @case('arrow-circle-up')
    <x-svg.heroicons.arrow-circle-up {{$attributes->merge(['class'=>'flex inline-flex h-8 w-8 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.arrow-circle-up>
    @break

    @case('delete')
    <x-svg.heroicons.delete  {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.delete>
    @break

    @case('x')
    <x-svg.heroicons.x  {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.x>
    @break

    @case('delete-open')
    <x-svg.heroicons.x  {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500'. $class]) }} ></x-svg.heroicons.x>
    @break

    @case('check')
    <x-svg.heroicons.check  {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 '. $class]) }} ></x-svg.heroicons.check>
    @break

    @case('chat')
    <x-svg.heroicons.chat  {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 '. $class]) }} ></x-svg.heroicons.chat>
    @break

    @case('dot-circle')
    <x-svg.heroicons.dot-circle  {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 '. $class]) }} ></x-svg.heroicons.dot-circle>
    @break


    @case('check-open')
    <x-svg.heroicons.check-open  {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 '. $class]) }} ></x-svg.heroicons.check-open>
    @break

    @case('question-open')
    <x-svg.heroicons.question-open  {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.question-open>
    @break

    @case('download')
    <x-svg.heroicons.download {{$attributes->merge(['class'=>'flex inline-flex h-5 w-6 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.download>
    @break

    @case('exclamation')
    <x-svg.heroicons.exclamation-circle {{$attributes->merge(['class'=>'flex inline-flex h-5 w-6 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.exclamation-circle>
    @break

    @case('view')
    <x-svg.heroicons.view {{$attributes->merge(['class'=>'flex inline-flex h-5 w-5 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.view>
    @break

    @case('plus')
    <x-svg.heroicons.plus {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.plus>
    @break

    @case('plus-circle')
    <x-svg.heroicons.plus-circle {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.plus-circle>
    @break

    @case('briefcase')
    <x-svg.heroicons.briefcase  {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.briefcase>
    @break

    @case('exclamation-circle')
    <x-svg.heroicons.exclamation-circle  {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.exclamation-circle>
    @break

    @case('document-text')
    <x-svg.heroicons.document-text  {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.document-text>
    @break

    @case('alpine')
    <x-svg.heroicons.home x-show="svg==='home'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.home>

    <x-svg.heroicons.briefcase x-show="svg==='briefcase'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.briefcase>

    <x-svg.heroicons.security x-show="svg==='security'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.security>

    <x-svg.heroicons.navigation x-show="svg==='navigation'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.navigation>

    <x-svg.heroicons.arrow-up x-show="svg==='arrow-up'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.arrow-up>

    <x-svg.heroicons.arrow-down x-show="svg==='arrow-down'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.arrow-down>

    <x-svg.heroicons.setting x-show="svg==='setting'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.setting>

    <x-svg.heroicons.data x-show="svg==='data'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.data>

    <x-svg.heroicons.arrow-circle-down x-show="svg==='arrow-circle-down'" {{$attributes->merge(['class'=>'flex inline-flex h-8 w-8 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.arrow-circle-down>

    <x-svg.heroicons.arrow-circle-up x-show="svg==='arrow-circle-up'" {{$attributes->merge(['class'=>'flex inline-flex h-8 w-8 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.arrow-circle-up>

    <x-svg.heroicons.delete x-show="svg==='delete'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.delete>

    <x-svg.heroicons.check-open  x-show="svg==='check-open'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 '. $class]) }} ></x-svg.heroicons.check-open>

    <x-svg.heroicons.plus-circle x-show="svg==='plus-circle'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-500 cursor-pointer '. $class]) }} ></x-svg.heroicons.plus-circle>

    <x-svg.heroicons.document-text x-show="svg==='document-text'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.document-text>

    <x-svg.heroicons.star x-show="svg==='star'" {{$attributes->merge(['class'=>'flex inline-flex h-6 w-6 text-gray-600 dark:text-gray-300 '. $class]) }}></x-svg.heroicons.star>
    @break
@endswitch


