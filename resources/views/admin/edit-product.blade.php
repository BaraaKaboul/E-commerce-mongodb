@extends('layouts.admin')
@section('content')

    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Product</h3>
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
                        <a href="{{route('admin.products')}}">
                            <div class="text-tiny">Products</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit product</div>
                    </li>
                </ul>
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
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.update',$prod->id)}}">
                @csrf
                @method('patch')
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter product name"
                               name="name" tabindex="0" value="{{$prod->name}}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug"
                               name="slug" tabindex="0" value="{{$prod->slug}}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="" name="category_id">
                                    <option disabled>Choose category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{$cat->id}}" {{$prod->category_id == $cat->id ? 'selected' : ''}}>{{$cat->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="brand">
                            <div class="body-title mb-10">Brand <span class="tf-color-1">*</span>
                            </div>
                            <div class="select">
                                <select class="" name="brand_id">
                                    <option disabled>Choose Brand</option>
                                    @foreach($brands as $bra)
                                        <option value="{{$bra->id}}" {{$prod->brand_id == $bra->id ? 'selected' : ''}}>{{$bra->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </fieldset>
                    </div>

                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span
                                class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description"
                                  placeholder="Short Description" tabindex="0" aria-required="true"
                                  required="">{{$prod->short_description}}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>

                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                        </div>
                        <textarea class="mb-10" name="description" placeholder="Description"
                                  tabindex="0" aria-required="true" required="">{{$prod->description}}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                </div>
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            @if($prod->image)
                                <div class="item" id="imgpreview">
                                    <img src="{{ asset('Attachments/'.$prod->brand->name.'/'.$prod->name.'/'.$prod->image) }}"
                                         class="effect8" id="showMainImage" alt="">
                                </div>
                            @endif
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="mainImage">
                                    <span class="icon"><i class="icon-upload-cloud"></i></span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                    <input type="hidden" name="old_image" value="{{ $prod->image }}">
                                    <input type="file" id="mainImage" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="body-title mb-10">Upload Gallery Images</div>
                        <div class="upload-image mb-16">
                            @if($prod->images)
                                @foreach(json_decode($prod->images) as $index => $galleryImage)
                                    <div class="item gallery-preview">
                                        <img src="{{ asset('Attachments/'.$prod->brand->name.'/'.$prod->name.'/Gallery/'.$galleryImage) }}">
                                        <input type="hidden" name="old_images[]" value="{{ $galleryImage }}">
                                        <button type="button" class="remove-gallery-image" data-image="{{ $galleryImage }}">×</button>
                                    </div>
                                @endforeach
                            @endif
                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="galleryImages">
                                    <span class="icon"><i class="icon-upload-cloud"></i></span>
                                    <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="galleryImages" name="images[]" accept="image/*" multiple>
                                </label>
                            </div>
                        </div>
                        <div id="galleryPreviews" class="flex flex-wrap gap-10"></div>
                    </fieldset>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Regular Price <span
                                    class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter regular price"
                                   name="regular_price" tabindex="0" value="{{$prod->regular_price}}" aria-required="true"
                                   required="">
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Sale Price <span
                                    class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter sale price"
                                   name="sale_price" tabindex="0" value="{{$prod->sale_price}}" aria-required="true"
                                   required="">
                        </fieldset>
                    </div>


                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter SKU" name="SKU"
                                   tabindex="0" value="{{$prod->SKU}}" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                            </div>
                            <input class="mb-10" type="text" placeholder="Enter quantity"
                                   name="quantity" tabindex="0" value="{{$prod->quantity}}" aria-required="true"
                                   required="">
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="instock" {{$prod->stock_status == 'instock' ? 'selected' : ''}}>InStock</option>
                                    <option value="outofstock" {{$prod->stock_status == 'outofstock' ? 'selected' : ''}}>Out of Stock</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="0" {{$prod->featured == '0' ? 'selected' : ''}}>No</option>
                                    <option value="1" {{$prod->featured == '1' ? 'selected' : ''}}>Yes</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Add product</button>
                    </div>
                </div>
            </form>
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('select[name="brand_id"]').on('change', function() {
                var brandId = $(this).val();
                if (brandId) {
                    $.ajax({
                        url: "{{ URL::to('admin/brand', '') }}/" + brandId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="category_id"]').empty();
                            $('select[name="category_id"]').append('<option disabled value="">Choose category</option>');

                            $.each(data, function(id, name) {
                                $('select[name="category_id"]').append('<option value="' + id + '">' + name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', error);
                        }
                    });
                } else {
                    $('select[name="category_id"]').empty();
                    $('select[name="category_id"]').append('<option disabled value="">Choose category</option>');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            // معالجة الصورة الرئيسية
            $('#mainImage').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showMainImage').attr('src', e.target.result);
                    $('#imgpreview').show();
                }
                reader.readAsDataURL(e.target.files[0]);
            });

            // معالجة معرض الصور
            $('#galleryImages').change(function(e){
                $('#galleryPreviews').empty();
                var files = e.target.files;

                for (var i = 0; i < files.length; i++) {
                    (function(file) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#galleryPreviews').append(`
                        <div class="item gallery-preview">
                            <img src="${e.target.result}" class="effect8">
                        </div>
                    `);
                        }
                        reader.readAsDataURL(file);
                    })(files[i]);
                }
            });

            // حذف صورة من المعرض
            $(document).on('click', '.remove-gallery-image', function(){
                var imageName = $(this).data('image');
                $(this).parent().remove();

                // إضافة حقل مخفي للإشارة إلى الصور المحذوفة
                $('<input>').attr({
                    type: 'hidden',
                    name: 'deleted_images[]',
                    value: imageName
                }).appendTo('form');
            });
        });
    </script>
@endpush
