@extends('layouts.admin')
@section('content')

        <div class="main-content-inner">
            <div class="main-content-wrap">
                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                    <h3>Brands</h3>
                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                        <li>
                            <a href="{{route('admin.index')}}">
                                <div class="text-tiny">Dashboard</div>
                            </a>
                        </li>
                        <li>
                            <i class="icon-chevron-right"></i>
                        </li>
                        <li>
                            <div class="text-tiny">Brands</div>
                        </li>
                    </ul>
                </div>
                @if (count($errors) > 0)
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p> {{ $error }}
                                    <p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="wg-filter flex-grow">
                            <form class="form-search">
                                <fieldset class="name">
                                    <input type="text" placeholder="Search here..." class="" name="name"
                                           tabindex="2" value="" aria-required="true" required="">
                                </fieldset>
                                <div class="button-submit">
                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <a class="tf-button style-1 w208" href="{{route('admin.brand.create.page')}}"><i
                                class="icon-plus"></i>Add new</a>
                    </div>
                    <div class="wg-table table-all-user">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Products</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($brands as $data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{asset('Attachments/'.$data->name)}}/{{$data->image}}" alt="" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="#" class="body-title-2">{{$data->name}}</a>
                                        </div>
                                    </td>
                                    <td>{{$data->slug}}</td>
                                    <td><a href="#" target="_blank">0</a></td>
                                    <td>
                                        <div class="list-icon-function">
                                            <a href="{{route('admin.brand.update.page',$data->id)}}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{route('admin.brand.delete',$data->id)}}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <div class="item text-danger delete">
                                                    <i class="icon-trash-2"></i>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                    @empty
                                        <h2>no data</h2>
                                </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                            {{$brands->links('pagination::bootstrap-5')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@push('scripts')
    <script> // هاد الكود مشان اعمل ticket للحذف بالكلاس الي اسمو delete
        $(function (){
            $('.delete').on('click', function (e){
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: 'Are you sure ?',
                    text: 'Once you delete it, you will never recover the data.',
                    type: 'warning',
                    buttons: ['No','Yes'],
                    confirmButtonColor: '#dc3545',
                }).then(function (result){
                    if(result){
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
