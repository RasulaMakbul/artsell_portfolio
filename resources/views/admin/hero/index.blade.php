<x-admin.master>
    <x-slot:title>
        {{ __('Hero Section') }}
    </x-slot:title>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hero Section</h1>

        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                    data-target="#createHeroModal">
                    <span><i class="fa-solid fa-plus"></i></span>{{ __(' Create') }}
                </button>
            </div>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive small">
        <table class="table table-striped table-sm text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($heros as $hero)
                    <tr class="align-middle">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ asset($hero->image) }}" alt="hero image" class="img-fluid rounded"
                                style="height: 100px; width: 100px;">
                        </td>
                        <td>{{ $hero->title }}</td>
                        <td>
                            @if ($hero->status == 0)
                                <a href="{{ route('hero.active', $hero->id) }}"
                                    class="btn btn-sm link-success">{{ __('Hidden') }}</a>
                            @else
                                <a href="{{ route('hero.inactive', $hero->id) }}"
                                    class="btn btn-sm link-danger">{{ __('Visible') }}</a>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm link-success" data-toggle="modal1"
                                data-target="#showModal{{ $hero->id }}">
                                <i class="fa-solid fa-eye fs-5"></i></i>
                            </button>
                            <button type="button" class="btn btn-sm link-warning" data-toggle="modal2"
                                data-target="#myModal{{ $hero->id }}">
                                <i class="fa-solid fa-pen-to-square fs-5"></i>
                            </button>
                            <form action="{{ route('hero.destroy', $hero->id) }}" method="post"
                                style="display:inline">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm link-danger"
                                    onclick="return confirm('Are you sure want to delete')"><i
                                        class="fa-solid fa-trash fs-5"></i></button>
                            </form>


                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No Hero added!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="modal fade" id="createHeroModal" tabindex="-1" aria-labelledby="createHeroModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="createHeroModalLabel"><span><i
                                class="fa-solid fa-plus"></i></span>{{ __(' Create New Hero') }}</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('hero.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Title') }}</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ old('title') }}">
                            @error('title')
                                <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control" id="description" rows="3" name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="status" name="status">
                            <label class="form-check-label" for="status">{{ __('Acive') }}</label>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('Image') }}</label>
                            <input type="file" class="form-control" id="image" name="image"
                                value="{{ old('image') }}">
                            @error('image')
                                <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">{{ __('Meta Title') }}</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title"
                                value="{{ old('meta_title') }}">
                            @error('meta_title')
                                <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="meta_keyword" class="form-label">{{ __('Meta Keyword') }}</label>
                            <input type="text" class="form-control" id="meta_keyword" name="meta_keyword"
                                value="{{ old('meta_keyword') }}">
                            @error('meta_keyword')
                                <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">{{ __('Meta Description') }}</label>
                            <input type="text" class="form-control" id="meta_description" name="meta_description"
                                value="{{ old('meta_description') }}">
                            @error('meta_description')
                                <small class=" text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-secondary">{{ __('Create') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    @forelse ($heros as $item)
        <div class="modal fade" id="myModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel{{ $item->id }}"> Update Hero
                            {{ $item->title }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('hero.update', $item->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Title') }}</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $item->title) }}">
                                @error('title')
                                    <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <textarea class="form-control" id="description" rows="3" name="description">{{ old('description', $item->description) }}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="status" name="status"
                                    value="{{ $item->status }}" @if ($item->status == 1) checked @endif>
                                <label class="form-check-label" for="status">{{ __('Acive') }}</label>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">{{ __('Image') }}</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    value="{{ old('image') }}">
                                <img src="{{ asset($hero->image) }}" alt="" width="100px" height="100px">
                                @error('image')
                                    <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">{{ __('Meta Title') }}</label>
                                <input type="text" class="form-control" id="meta_title" name="meta_title"
                                    value="{{ old('meta_title', $item->meta_title) }}">
                                @error('meta_title')
                                    <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="meta_keyword" class="form-label">{{ __('Meta Keyword') }}</label>
                                <input type="text" class="form-control" id="meta_keyword" name="meta_keyword"
                                    value="{{ old('meta_keyword', $item->meta_keyword) }}">
                                @error('meta_keyword')
                                    <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">{{ __('Meta Description') }}</label>
                                <input type="text" class="form-control" id="meta_description"
                                    name="meta_description"
                                    value="{{ old('meta_description', $item->meta_description) }}">
                                @error('meta_description')
                                    <small class=" text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @empty
    @endforelse
    @forelse ($heros as $item)
        <div class="modal fade" id="showModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="showModalLabel{{ $item->id }}">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="showModalLabel{{ $item->id }}">
                            {{ $item->title }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card" style="width: auto;">
                            <img src="{{ asset($item->image) }}" class="card-img-top" alt="{{ $item->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->title }}</h5>
                                <p class="card-text">{{ $item->description }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    @empty
    @endforelse
    @push('js')
        <script>
            $(document).ready(function() {
                $('[data-toggle="modal"]').click(function() {
                    var targetModal = $(this).data('target');
                    $(targetModal).modal('show');
                });
            });
            $(document).ready(function() {
                $('[data-toggle="modal1"]').click(function() {
                    var targetModal = $(this).data('target');
                    $(targetModal).modal('show');
                });
            });
            $(document).ready(function() {
                $('[data-toggle="modal2"]').click(function() {
                    var targetModal = $(this).data('target');
                    $(targetModal).modal('show');
                });
            });
        </script>
    @endpush


</x-admin.master>
