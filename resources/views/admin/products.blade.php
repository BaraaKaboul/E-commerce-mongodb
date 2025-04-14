@extends('layouts.admin')
@section('content')

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>All Products</h3>
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
                        <div class="text-tiny">All Products</div>
                    </li>
                </ul>
            </div>

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
                    <a class="tf-button style-1 w208" href="{{route('admin.product.create.page')}}"><i
                            class="icon-plus"></i>Add new</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>SalePrice</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Featured</th>
                            <th>Stock</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{asset('Attachments/'.$data->brand->name.'/'.$data->name.'/'.$data->image)}}" alt="{{$data->name}}" class="image">
                                </div>
                                <div class="name">
                                    <a href="#" class="body-title-2">{{$data->name}}</a>
                                    <div class="text-tiny mt-3">{{$data->slug}}</div>
                                </div>
                            </td>
                            <td>{{$data->regular_price}}</td>
                            <td>{{$data->sale_price}}</td>
                            <td>{{$data->SKU}}</td>
                            <td>{{$data->category->name}}</td>
                            <td>{{$data->brand->name}}</td>
                            <td>{{$data->featured == 0 ? 'No':'Yes'}}</td>
                            <td>{{$data->stock_status}}</td>
                            <td>{{$data->quantity}}</td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="#" target="_blank">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </a>
                                    <a href="{{route('admin.products.update.page',$data->id)}}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form action="{{route('admin.product.delete',$data->id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <div class="item text-danger delete">
                                            <i class="icon-trash-2"></i>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <h2>no data</h2>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

                    {{$products->links('pagination::bootstrap-5')}}
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
