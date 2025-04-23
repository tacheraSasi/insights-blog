<x-app-layout>
    <x-card>
        <h1 class="text-2xl font-bold">Send Email to All Users</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('console.email.send') }}" method="POST">
            @csrf
            <div class="mt-2">
                <x-input-label for="subject" :value="__('Subject')" />
                <x-text-input id="subject" name="subject" type="text"
                    class="mt-1 block w-full focus:outline-none focus:border-none focus:ring focus:ring-neutral-800 dark:focus:ring-neutral-400"
                    :value="old('subject')" required autofocus autocomplete="subject" />
                <x-input-error class="mt-2" :messages="$errors->get('subject')" />
            </div>
            <div class="mt-2">
                <label class="block font-bold" for="message">Message</label>
                <x-input-error class="mt-2" :messages="$errors->get('message')" />
                <textarea name="message" id="message"
                    class="form-textarea w-full p-4 rounded-lg border dark:bg-neutral-900 dark:border-neutral-700 focus:outline-none focus:border-none focus:ring focus:ring-neutral-800 dark:focus:ring-neutral-400 placeholder-neutral-500 dark:placeholder-neutral-400"
                    rows="8" required>{{ old('message') }}</textarea>
            </div>

            <div class="mt-2">
                <x-primary-button>Send</x-primary-button>
            </div>
        </form>
    </x-card>
</x-app-layout>