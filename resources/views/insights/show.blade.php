<x-app-layout>
{{-- 
@section('meta_title', $insight->title)
@section('meta_description', Str::limit($insight->content, 150)) --}}

    <div class="container mx-auto mt-10">
        <h1 class="text-3xl font-bold dark:text-neutral-200">{{ $insight->title }}</h1>
        <p class="text-neutral-600">Category: {{ $insight->category->name }} | {{ $insight->created_at->diffForHumans() }}</p>

        <x-card class="mt-6">
            {!! $insight->content !!}
        </x-card>

        <div class="mt-6 flex">
            <form action="{{ route('insights.like', $insight->id) }}" method="POST">
                @csrf
                <button type="submit" class="text-blue-500">{{ $insight->likes->count() }} Likes</button>
            </form>
        </div>

        <div class="mt-10">
            <h2 class="text-2xl font-bold">Comments ({{ $insight->comments->count() }})</h2>

            <div class="mt-4">
                @foreach($insight->comments as $comment)
                    <div class="mb-4">
                        <p class="text-neutral-700">{!! $comment->comment !!}</p>
                        <p class="text-sm text-neutral-600">{!! $comment->user->name !!} | {{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>

            @auth
                <form action="{{ route('comments.store', $insight->id) }}" class="m-4" method="POST">
                    @csrf
                    <div class="mt-4">
                        <textarea name="comment" class=" w-full" rows="4" required></textarea>
                    </div>
                    <div class="mt-4">
                        <x-primary-button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Add Comment</x-primary-button>
                    </div>
                </form>
            @else
                <p class="text-neutral-600">You must be logged in to comment.</p>
            @endauth
        </div>
    </div>
</x-app-layout>
