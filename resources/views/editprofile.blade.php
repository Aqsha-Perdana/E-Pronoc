<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>

    <!-- TAILWIND CDN RESMI -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- OPTIONAL: Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#D31119",
                    }
                }
            }
        };
    </script>
</head>

<body class="bg-gray-100">

    <div class="min-h-screen bg-gray-100 py-16">

        <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-2xl p-10 border border-gray-200">

            <!-- Title -->
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                Edit Profile Data
            </h2>

           <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Full Name</label>
        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm 
            focus:border-primary focus:ring-primary"
            placeholder="Masukkan nama lengkap">
    </div>

    <!-- Phone -->
    <div>
        <label class="block text-sm font-medium text-gray-700">No. Telephone</label>
        <input type="number" name="notelp" value="{{ old('notelp', auth()->user()->notelp) }}"
            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm
            focus:border-primary focus:ring-primary"
            placeholder="Masukkan No. Telephone">
    </div>

    <!-- Institution -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Institution</label>
        <input type="text" name="institution" value="{{ old('institution', auth()->user()->institution) }}"
            class="mt-2 w-full rounded-lg border-gray-300 shadow-sm
            focus:border-primary focus:ring-primary"
            placeholder="Masukkan nama institusi">
    </div>

    <!-- Upload Photo -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>

        <div class="flex items-center gap-4">
            <div class="size-20 rounded-full bg-gray-100 border border-gray-300 
                flex items-center justify-center overflow-hidden">

                @if(auth()->user()->photo)
                    <img src="{{ asset('storage/profile/' . auth()->user()->photo) }}"
                         class="size-20 object-cover rounded-full">
                @else
                    <svg class="size-10 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-3.33 0-10 1.67-10 5v1h20v-1c0-3.33-6.67-5-10-5Z" />
                    </svg>
                @endif

            </div>

            <label class="cursor-pointer px-4 py-2 bg-primary text-white text-sm
                   rounded-lg shadow-md hover:bg-red-700 transition">
                Upload Photo
                <input type="file" name="photo" class="hidden">
            </label>
        </div>
    </div>

    <!-- Buttons -->
    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
        <button type="reset"
            class="px-4 py-2 text-gray-700 font-semibold hover:text-gray-900 transition">
            Cancel
        </button>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

    <!-- input lainnya di sini -->

    <button type="submit"
        class="px-6 py-2 bg-primary text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition">
        Save
    </button>
</form>

    </div>

</form>
        </div>

    </div>
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#D31119'
    });
</script>
@endif
</body>

</html>
