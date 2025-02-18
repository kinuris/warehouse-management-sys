@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-4 mt-16 md:mt-0">Register Delivery</h1>
    <form action="{{ route('order_deliver', ['order' => $order->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="time" class="block text-gray-700 text-sm font-bold mb-2">Delivery Time:</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('delivery_time') border-red-500 @enderror" type="datetime-local" value="{{ old('delivery_time') ?? now() }}" required name="delivery_time" id="time">
            @error('delivery_time')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="proof" class="block text-gray-700 text-sm font-bold mb-2">Proof of Delivery:</label>
            <div class="flex items-center">
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('proof') border-red-500 @enderror" type="file" name="proof" id="proof" capture="environment" accept="image/*">
                <button type="button" onclick="document.getElementById('proof').click()" class="ml-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Take Picture
                </button>
            </div>
            @error('proof')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <img id="preview" src="#" alt="Preview" class="hidden mt-2 rounded-lg shadow-lg max-w-md w-full h-auto object-cover border-2 border-gray-200 transition-all duration-300 hover:scale-105">
        </div>

        <a class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-1" href="{{ route('deliveries') }}">Back</a>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1.5 px-4 rounded cursor-pointer register-button" type="submit">Register Delivery</button>
    </form>
</div>
@endsection

@section('script')
<script>
    // function resetLastModifiedDate(file, newDate) {
    //     const newFile = new File([file], file.name, {
    //         type: file.type,
    //         lastModified: newDate.getTime()
    //     });
    //     return newFile;
    // }

    document.getElementById('proof').addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // document.querySelector('button.register-button').addEventListener('click', function(e) {
    //     e.preventDefault();

    //     const formData = new FormData();

    //     formData.append('delivery_time', document.getElementById('time').value);
    //     formData.append('proof', file);

    //     fetch("{{ route('order_deliver', ['order' => $order->id]) }}", {
    //         method: 'POST',
    //         body: formData,
    //         headers: {
    //             'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
    //         }
    //     })
    // });
</script>
@endsection