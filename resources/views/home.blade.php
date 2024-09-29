<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Insights') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mt-3">
            @if($insights->count())
                <ul>
                    @foreach($insights as $insight)
                        <x-card>
                            <li class="mb-4">
                                <h3 class="font-bold text-lg">
                                    <a href="{{ route('insights.show', $insight->slug) }}">{{ $insight->title }}</a>
                                </h3>
                                <p class="text-gray-600">{!! Str::limit($insight->content, 500) !!}</p>
                                <div class="text-sm text-gray-500">
                                    <span>{{ $insight->created_at->diffForHumans() }}</span>
                                    <span class="ml-2">|</span>
                                    <span class="ml-2">Category: {{ $insight->category->name }}</span>
                                </div>
                            </li>
                        </x-card>
                    @endforeach
                </ul>

                <!-- Pagination Links -->
                <div class="m-4">
                    {{ $insights->links() }}
                </div>
            @else
                <x-card>No insights available.</x-card>
            @endif
        </div>
       
    </div>
</x-app-layout>
