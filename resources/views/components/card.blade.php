@props(['title' => '', 'class'=> 'py-4'])
<div class="{{$class}}">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            @empty($title)
            @else
                <div class="p-4 mx-2 text-gray-900 dark:text-gray-100 font-lg font-medium border-b-2 border-indigo-500">
                    {{$title}}
                </div>
            @endisset
            <div class="p-6 text-gray-900 dark:text-gray-100">
            {{ $slot }}
            </div>
        </div>
    </div>
</div>