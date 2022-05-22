@props(['name','values'=>[],'placeholder'])
<select id="{{$name}}" name="{{$name}}"
        {{ $attributes->merge(['class' => 'relative bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500']) }}
        >

    <option wire:loading value="" class="relative">
        Loading...
{{--        <svg class="absolute top-3 left-3" width="25" height="20" viewBox="0 0 135 140" xmlns="http://www.w3.org/2000/svg" fill="#fff">--}}
{{--            <rect y="10" width="15" height="120" rx="6">--}}
{{--                <animate attributeName="height"--}}
{{--                         begin="0.5s" dur="1s"--}}
{{--                         values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"--}}
{{--                         repeatCount="indefinite" />--}}
{{--                <animate attributeName="y"--}}
{{--                         begin="0.5s" dur="1s"--}}
{{--                         values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"--}}
{{--                         repeatCount="indefinite" />--}}
{{--            </rect>--}}
{{--            <rect x="30" y="10" width="15" height="120" rx="6">--}}
{{--                <animate attributeName="height"--}}
{{--                         begin="0.25s" dur="1s"--}}
{{--                         values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"--}}
{{--                         repeatCount="indefinite" />--}}
{{--                <animate attributeName="y"--}}
{{--                         begin="0.25s" dur="1s"--}}
{{--                         values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"--}}
{{--                         repeatCount="indefinite" />--}}
{{--            </rect>--}}
{{--            <rect x="60" width="15" height="140" rx="6">--}}
{{--                <animate attributeName="height"--}}
{{--                         begin="0s" dur="1s"--}}
{{--                         values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"--}}
{{--                         repeatCount="indefinite" />--}}
{{--                <animate attributeName="y"--}}
{{--                         begin="0s" dur="1s"--}}
{{--                         values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"--}}
{{--                         repeatCount="indefinite" />--}}
{{--            </rect>--}}
{{--            <rect x="90" y="10" width="15" height="120" rx="6">--}}
{{--                <animate attributeName="height"--}}
{{--                         begin="0.25s" dur="1s"--}}
{{--                         values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"--}}
{{--                         repeatCount="indefinite" />--}}
{{--                <animate attributeName="y"--}}
{{--                         begin="0.25s" dur="1s"--}}
{{--                         values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"--}}
{{--                         repeatCount="indefinite" />--}}
{{--            </rect>--}}
{{--            <rect x="120" y="10" width="15" height="120" rx="6">--}}
{{--                <animate attributeName="height"--}}
{{--                         begin="0.5s" dur="1s"--}}
{{--                         values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"--}}
{{--                         repeatCount="indefinite" />--}}
{{--                <animate attributeName="y"--}}
{{--                         begin="0.5s" dur="1s"--}}
{{--                         values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"--}}
{{--                         repeatCount="indefinite" />--}}
{{--            </rect>--}}
{{--        </svg>--}}
    </option>
    <option value=""> {{$placeholder}}</option>
    @foreach($values as $key=>$value)
        <option value="{{$key}}">{{$value}}</option>
    @endforeach
</select>

