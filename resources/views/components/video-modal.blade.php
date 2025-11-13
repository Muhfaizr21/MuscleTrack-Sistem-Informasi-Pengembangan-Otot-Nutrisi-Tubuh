{{-- Video Modal Component --}}
<div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: false, videoUrl: '', exerciseName: '' }"
     x-show="show"
     x-cloak
     @keydown.escape="show = false">

    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity" x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    {{-- Modal Container --}}
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-2xl bg-gray-900 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl sm:p-6 border border-emerald-500/30"
             x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             @click.away="show = false">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white" x-text="exerciseName + ' - Tutorial'"></h3>
                <button @click="show = false" class="text-gray-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Video Player --}}
            <div class="video-container" id="videoContainer">
                {{-- Video akan dimuat dinamis di sini --}}
            </div>

            {{-- Loading State --}}
            <div class="hidden loading-state">
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-500"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Video Trigger Script --}}
<script>
function openVideoModal(videoUrl, exerciseName) {
    const modal = document.querySelector('[x-data]');
    const videoContainer = document.getElementById('videoContainer');
    const loadingState = document.querySelector('.loading-state');

    // Set modal data
    Alpine.nextTick(() => {
        Alpine.raw(modal).__x.$data.videoUrl = videoUrl;
        Alpine.raw(modal).__x.$data.exerciseName = exerciseName;
        Alpine.raw(modal).__x.$data.show = true;
    });

    // Show loading
    videoContainer.classList.add('hidden');
    loadingState.classList.remove('hidden');

    // Load video after a brief delay for smooth transition
    setTimeout(() => {
        loadVideoPlayer(videoUrl, videoContainer);
        videoContainer.classList.remove('hidden');
        loadingState.classList.add('hidden');
    }, 300);
}

function loadVideoPlayer(videoUrl, container) {
    let videoHTML = '';

    if (isYouTubeUrl(videoUrl)) {
        const videoId = getYouTubeId(videoUrl);
        videoHTML = `
            <div class="aspect-w-16 aspect-h-9">
                <iframe class="w-full h-64 md:h-96 rounded-lg"
                        src="https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                </iframe>
            </div>
        `;
    } else if (isVimeoUrl(videoUrl)) {
        const videoId = getVimeoId(videoUrl);
        videoHTML = `
            <div class="aspect-w-16 aspect-h-9">
                <iframe class="w-full h-64 md:h-96 rounded-lg"
                        src="https://player.vimeo.com/video/${videoId}?autoplay=1"
                        frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture"
                        allowfullscreen>
                </iframe>
            </div>
        `;
    } else {
        // Local video file
        videoHTML = `
            <div class="aspect-w-16 aspect-h-9">
                <video class="w-full h-64 md:h-96 rounded-lg" controls autoplay>
                    <source src="${videoUrl}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        `;
    }

    container.innerHTML = videoHTML;
}

// Helper functions
function isYouTubeUrl(url) {
    return url.includes('youtube.com') || url.includes('youtu.be');
}

function isVimeoUrl(url) {
    return url.includes('vimeo.com');
}

function getYouTubeId(url) {
    const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    const match = url.match(regExp);
    return (match && match[7].length === 11) ? match[7] : null;
}

function getVimeoId(url) {
    const regExp = /(?:vimeo\.com\/|player\.vimeo\.com\/video\/)([0-9]+)/;
    const match = url.match(regExp);
    return match ? match[1] : null;
}

// Close modal when pressing Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.querySelector('[x-data]');
        if (modal) {
            Alpine.raw(modal).__x.$data.show = false;
        }
    }
});
</script>

<style>
[x-cloak] {
    display: none !important;
}

.aspect-w-16 {
    position: relative;
}

.aspect-w-16::before {
    content: "";
    display: block;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
}

.aspect-w-16 > * {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
</style>
