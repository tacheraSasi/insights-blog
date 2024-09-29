<x-app-layout>
    <x-card>
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold">Write a new Insight</h1>
        
            <form action="{{ route('insights.store') }}" method="POST">
                @csrf
        
                <div class="mt-2">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus autocomplete="title" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>
        
                <div class="mt-2">
                    <label class="block font-bold" for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-select w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
        
                <div class="mt-2">
                    <label class="block font-bold" for="content">Content</label>
                    <x-input-error class="mt-2" :messages="$errors->get('content')" />
                    <textarea name="content" id="content" class="form-textarea w-full " rows="8" required>{{ old('content') }}</textarea>
                </div>
        
                <div class="mt-2">
                    <x-primary-button>{{ __('Create Insight') }}</x-primary-button>                </div>
            </form>
        </div>
    </x-card>
</x-app-layout>