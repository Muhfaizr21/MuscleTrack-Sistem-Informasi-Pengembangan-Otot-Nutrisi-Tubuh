<x-layouts.landing>

    <div class="pt-32 pb-16 bg-black z-10 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="font-serif text-5xl sm:text-7xl font-bold text-white">
            Hubungi <span class="text-amber-400">Kami</span>
        </h1>
        <p class="mt-4 text-lg text-gray-400 max-w-2xl mx-auto">
            Punya pertanyaan, feedback, atau ingin bermitra? Kirimkan pesan kepada kami. Kami akan segera merespon Anda.
        </p>
    </div>
</div>
    <div class="bg-black z-10 relative pb-20 sm:pb-32">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg p-8">

                @if(session('success'))
                    <div class="mb-6 bg-amber-400/20 text-amber-300 border border-amber-500/50 p-4 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                     <div class="mb-6 bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md">
                        <p>Ups! Ada beberapa kesalahan:</p>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                   class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                          focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                   class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                          focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50">
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-300">Subjek (Opsional)</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                      focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-300">Pesan Anda</label>
                        <textarea name="message" id="message" rows="5" required
                                  class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                         focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50">{{ old('message') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                            Kirim Pesan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</x-layouts.landing>
