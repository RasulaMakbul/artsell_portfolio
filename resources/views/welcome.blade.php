<x-frontendComponent.master>


    {{-- hero Section start --}}


    <div class="container-fluid mb-5">
        <div class="col-lg-10">
            <div class="owl-carousel owl-theme">
                @forelse ($heros as $index => $item)
                    {{-- <div
                        class="item flex flex-col lg:flex-row {{ $loop->even ? 'lg:flex-row-reverse' : '' }} items-center justify-between">
                        <!-- Image -->
                        <div class="w-full lg:w-1/2">
                            <img class="w-full h-[500px] object-cover" src="{{ asset($item->image) }}" alt="Image" />
                        </div>
                        <!-- Title and Description -->
                        <div class="w-full lg:w-1/2 p-6">
                            <h2 class="text-4xl font-bold text-gray-600 mb-4">{{ $item->title }}</h2>
                            <p class="text-lg text-gray-300">{{ $item->description }}</p>
                        </div>
                    </div> --}}
                    @if ($loop->index % 2 == 0)
                        <!-- Even Item: Image Left, Text Right -->
                        <div class="grid grid-cols lg:grid-cols mb-10">
                            <div class="flex flex-col lg:flex-row">
                                <img class="w-full lg:w-1/2 h-[700px] object-cover" src="{{ asset($item->image) }}"
                                    alt="Image">
                                <div class="p-6 lg:w-1/2">
                                    <h2 class="text-5xl font-bold mb-4  sm:text-lg">{{ $item->title }}</h2>
                                    <hr class="my-5">
                                    <p class="text-xl text-justify leading-relaxed sm:text-sm">{{ $item->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Odd Item: Text Left, Image Right -->
                        <div class="grid grid-cols lg:grid-cols mb-10">
                            <div class="flex flex-col lg:flex-row-reverse">
                                <img class="w-full lg:w-1/2 h-[700px] object-cover" src="{{ asset($item->image) }}"
                                    alt="Image">
                                <div class="p-6 lg:w-1/2">
                                    <h2 class="text-5xl font-bold mb-4 text-right sm:text-lg">{{ $item->title }}</h2>
                                    <hr class="my-5 gap-3 py-3">
                                    <p class="text-xl text-justify leading-relaxed sm:text-sm">{{ $item->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <p>No items found.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="container-fluid mb-5">
        <h3 class="text-4xl text-left mx-4">Creative work</h3>
        @forelse ($creatives as $item)
            <div
                class="item flex flex-col lg:flex-row {{ $loop->even ? 'lg:flex-row-reverse' : '' }} items-center justify-between">

                <div class="w-full lg:w-1/2">
                    <img class="w-full h-[500px] object-cover" src="{{ asset($item->image) }}" alt="Image" />
                </div>
            </div>
        @empty
        @endforelse
    </div>

    @push('js')
        {{-- <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script> --}}
        <script>
            $(document).ready(function() {
                $(".owl-carousel").owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: false,
                    autoplay: true,
                    autoplayTimeout: 2000,
                    autoplayHoverPause: true,
                    dots: false,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        600: {
                            items: 1,
                        },
                        1000: {
                            items: 1,
                        }
                    }
                });
            });
        </script>
    @endpush


    {{-- hero Section End --}}
</x-frontendComponent.master>

{{--
Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio voluptas natus odit neque at saepe expedita facere? Ullam porro esse enim labore ab itaque dolor nulla sunt mollitia provident, accusantium quam ipsam doloremque ducimus, dolorem illum animi delectus cumque debitis. A voluptas distinctio beatae hic recusandae cupiditate veniam eum impedit?
 --}}
