<div class="">
    <div class="mt-2">
        @if($insights->count())
            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16   sm:mt-16  lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach($insights as $insight)
                    <x-card>
                        <article class="flex max-w-xl  flex-col items-start justify-between">
                            <div class="flex items-center gap-x-4 text-xs">
                              <time datetime="{{ $insight->created_at }}" class="text-neutral-500">{{ $insight->created_at->diffForHumans() }}</time>
                              <a href="#" class="relative z-10 rounded-full bg-neutral-800 px-3 py-1.5 font-medium text-neutral-400 hover:bg-neutral-700">{{ $insight->category->name }}</a>
                            </div>
                            <div class="group relative">
                              <h3 class="mt-3 text-lg font-semibold leading-6 text-neutral-900 dark:text-neutral-300">
                                <a href="{{ route('insights.show', $insight->slug) }}">
                                  <span class="absolute inset-0"></span> 
                                  {{ $insight->title }}
                                </a>
                              </h3>
                              <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">Illo sint voluptas. Error voluptates culpa eligendi. Hic vel totam vitae illo. Non aliquid explicabo necessitatibus unde. Sed exercitationem placeat consectetur nulla deserunt vel. Iusto corrupti dicta.</p>

                              {{-- <p class="mt-5 line-clamp-3 text-sm leading-6 text-neutral-600">{!! Str::limit($insight->content, 300) !!}</p> --}}
                            </div>
                            <div class="relative mt-8 flex items-center gap-x-4">
                              <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-10 w-10 rounded-full bg-neutral-50">
                              <div class="text-sm leading-6">
                                <p class="font-semibold text-neutral-500">
                                  <a href="#">
                                    <span class="absolute inset-0 "></span>
                                    {{ $insight->user->name }}
                                  </a>
                                </p>
                                <p class="text-neutral-600">Co-Founder / CTO</p>
                              </div>
                            </div>
                          </article>
                        {{-- <li class="flex max-w-xl flex-col items-start justify-between">
                            <h3 class="font-bold text-lg">
                                <a href="{{ route('insights.show', $insight->slug) }}">{{ $insight->title }}</a>
                            </h3>
                            <p class="text-neutral-600">{!! Str::limit($insight->content, 500) !!}</p>
                            <div class="text-sm text-neutral-500">
                                <span>{{ $insight->created_at->diffForHumans() }}</span>
                                <span class="ml-2">|</span>
                                <span class="ml-2">Category: {{ $insight->category->name }}</span>
                            </div>
                        </li> --}}
                    </x-card>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="m-4">
                {{ $insights->links() }}
            </div>
        @else
            <x-card>No insights available.</x-card>
        @endif
    </div>
   
</div>