<x-frontendComponent.master>

    {{-- hero Section start --}}
    <div class="container-fluid mb-5">
        <div class="col-lg-10">
            <div class="owl-carousel owl-theme">
                @forelse ($heros as $index => $item)
                    @if ($loop->index % 2 == 0)
                        <!-- Even Item: Image Left, Text Right -->
                        <div class="grid grid-cols lg:grid-cols mb-10 relative" data-aos="fade-up">
                            <div class="flex flex-col lg:flex-row">
                                <img class="w-full lg:w-1/2 h-[700px] object-cover" src="{{ asset($item->image) }}"
                                    alt="Image">
                                <div class="p-6 lg:w-1/2">
                                    <h2 class="text-5xl font-bold mb-4 sm:text-lg">{{ $item->title }}</h2>
                                    <hr class="my-5">
                                    <p class="text-xl text-justify leading-justify sm:text-sm">{!! nl2br(e($item->description)) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Odd Item: Text Left, Image Right -->
                        <div class="grid grid-cols lg:grid-cols mb-10 relative" data-aos="fade-up">
                            <div class="flex flex-col lg:flex-row-reverse">
                                <img class="w-full lg:w-1/2 h-[700px] object-cover" src="{{ asset($item->image) }}"
                                    alt="Image">
                                <div class="p-6 lg:w-1/2">
                                    <h2 class="text-5xl font-bold mb-4 text-right sm:text-lg">{{ $item->title }}</h2>
                                    <hr class="my-5 gap-3 py-3">
                                    <p class="text-xl text-justify leading-justify sm:text-sm">{!! nl2br(e($item->description)) !!}
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

    {{-- Creative Work Section Start --}}
    <div class="swiper-container max-w-5xl ">
        <div class="swiper-wrapper">
            @forelse ($creatives as $item)
                <div class="swiper-slide">
                    <img class="w-full h-auto object-cover" src="{{ asset($item->image) }}" alt="Creative Image"
                        aria-label="{{ $item->title }}" />
                </div>
            @empty
                <p class="text-center text-lg">No items found.</p>
            @endforelse
        </div>
        <div class="swiper-pagination"></div>
    </div>


    {{-- Creative Work Section End --}}

    {{-- Fashion Work Section Start --}}
    <div class="container-fluid mb-5 " data-aos="fade-left">
        <h3 class="text-4xl text-center mx-4 mb-5">Fashion</h3>

        <div class="relative overflow-hidden">
            <div class="owl-carousel owl-fashion owl-theme">
                @forelse ($fashions as $item)
                    <div class="item flex justify-center">
                        <div class="w-full lg:w-3/4">
                            <img class="w-full h-auto object-cover" src="{{ asset($item->image) }}" alt="Fashion Image"
                                aria-label="{{ $item->title }}" />
                        </div>
                    </div>
                @empty
                    <p class="text-center text-lg">No items found.</p>
                @endforelse
            </div>
        </div>
    </div>
    {{-- Fashion Work Section End --}}

    @push('js')
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

                $(".owl-creativity, .owl-fashion").owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: false,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    autoplayHoverPause: true,
                    animateOut: 'fadeOut',
                    animateIn: 'fadeIn',
                    items: 1,
                    smartSpeed: 1000,
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

                // JavaScript for the custom slider
                // JavaScript for the custom slider

            });
        </script>
    @endpush

    @push('css')
        <style>
            .slider img {
                width: 100%;
                height: auto;
                object-fit: cover;
            }
        </style>
    @endpush

</x-frontendComponent.master>


{{--
Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio voluptas natus odit neque at saepe expedita facere? Ullam porro esse enim labore ab itaque dolor nulla sunt mollitia provident, accusantium quam ipsam doloremque ducimus, dolorem illum animi delectus cumque debitis. A voluptas distinctio beatae hic recusandae cupiditate veniam eum impedit?
 --}}
