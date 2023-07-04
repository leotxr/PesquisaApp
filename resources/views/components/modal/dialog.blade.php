@props(['id' => null, 'maxWidth' => null, 'maxHeight' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" :maxHeight="$maxHeight" {{ $attributes }} class="bg-white">
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900">
            {{ $title }}
        </div>

        <div class="mt-4 overflow-y-auto text-sm text-gray-600 h-96 md:h-96 lg:h-96">
            {{$content}}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
        {{$footer}}
    </div>
</x-modal>