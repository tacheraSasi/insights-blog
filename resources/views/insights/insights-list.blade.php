<div class="mt-2 p-2" id="explore">
  @if($insights->count())
      <!-- Responsive Grid: 1 column on small, 2 columns on medium, 3 columns on large screens -->
      <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-2 gap-y-4 sm:grid-cols-2 lg:grid-cols-3 lg:max-w-none">
          @foreach($insights as $insight)
              <x-card>
                  <!-- Article with Fixed Height and Reduced Gaps -->
                  <article class="flex h-[400px] w-full flex-col justify-between bg-white dark:bg-neutral-900   rounded-lg">
                      <!-- Time, Category Badge, and Reading Time -->
                      <div class="flex items-center gap-x-2 text-xs">
                          <time datetime="{{ $insight->created_at }}" class="text-neutral-500 mx-2">
                              {{ $insight->created_at->diffForHumans() }}
                          </time>
                          <a href="/category/{{ $insight->category->slug }}" class="relative z-10 rounded-full mx-2 bg-neutral-800 px-2 py-1.5 font-medium text-neutral-400 hover:bg-neutral-700">
                              {{ $insight->category->name }}
                          </a>
                      </div>
                      
                      <!-- Reading Time -->
                      <div class="mx-2 mt-1">
                          {!! $insight->reading_time_html !!}
                      </div>

                      <!-- Title and Excerpt -->
                      <div class="group relative">
                          <h3 class="mt-3 text-lg font-semibold leading-6 text-neutral-900 dark:text-neutral-300">
                              <a href="{{ route('insights.show', $insight->slug) }}">
                                  <span class="absolute inset-0"></span>
                                  {{ $insight->title }}
                              </a>
                          </h3>
                          <div class="mt-3 line-clamp-3 h-[200px] overflow-hidden text-sm leading-6 text-gray-600 dark:text-neutral-400">
                              {!! Str::limit($insight->content, 200) !!}
                          </div>
                      </div>

                      <!-- Tags -->
                      @if($insight->tags->count())
                          <div class="mx-2 my-2 flex flex-wrap gap-1">
                              @foreach($insight->tags as $tag)
                                  <a href="{{ route('search') }}?tag={{ $tag->slug }}"
                                     class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-800">
                                      {{ $tag->name }}
                                  </a>
                              @endforeach
                          </div>
                      @endif

                      <!-- Author Info and Like Button -->
                      <div class="relative mt-auto flex items-center justify-between px-2 pb-2">
                          <div class="text-sm leading-6">
                              <p class="font-semibold text-neutral-500">
                                  <a href="/{{ $insight->user->name }}">
                                      {{ $insight->user->name }}
                                  </a>
                              </p>
                          </div>
                          <x-like-button :insight="$insight" :show-text="false" />
                      </div>
                  </article>
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
