
@extends('admin.layout.master')

@section('title','Coupon Create')

@section('body')
    <!-- Main -->
    <div class="app-main__inner">

                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                                </div>
                                <div>
                                    User
                                    <div class="page-title-subheading">
                                        View, create, update, delete and manage.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('admin.components.notification')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <form method="post" action="admin/coupon" enctype="multipart/form-data">
                                        @csrf

                                        <div class="position-relative row form-group">
                                            <label for="code" class="col-md-3 text-md-right col-form-label">Coupon Code</label>
                                            <div class="col-md-9 col-xl-8">
                                                <input required name="code" id="code" placeholder="Coupon Code" type="text"
                                                    class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="position-relative row form-group">
                                            <label for="type"
                                                   class="col-md-3 text-md-right col-form-label">Coupon Type</label>
                                            <div class="col-md-9 col-xl-8">
                                                <select required name="type" id="type" class="form-control">
                                                    <option value="">-- Level --</option>
                                                    @foreach(\App\Utilities\Constant::$coupon_status as $key => $value)
                                                        <option value={{$key}}>
                                                            {{$value}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="position-relative row form-group">
                                            <label for="value" class="col-md-3 text-md-right col-form-label">
                                                Coupon Value
                                            </label>
                                            <div class="col-md-9 col-xl-8">
                                                <input name="value" id="value"
                                                    placeholder="Coupon Value" class="form-control" type="number"
                                                    value="">
                                            </div>
                                        </div>

                                        <div class="position-relative row form-group">
                                            <label for="cart_value"
                                                class="col-md-3 text-md-right col-form-label">Cart Value</label>
                                            <div class="col-md-9 col-xl-8">
                                                <input name="cart_value" id="cart_value" placeholder="Cart Value"
                                                    type="number" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="position-relative row form-group mb-1">
                                            <div class="col-md-9 col-xl-8 offset-md-2">
                                                <a href="./admin/coupon" class="border-0 btn btn-outline-danger mr-1">
                                                    <span class="btn-icon-wrapper pr-1 opacity-8">
                                                        <i class="fa fa-times fa-w-20"></i>
                                                    </span>
                                                    <span>Cancel</span>
                                                </a>

                                                <button type="submit"
                                                    class="btn-shadow btn-hover-shine btn btn-primary">
                                                    <span class="btn-icon-wrapper pr-2 opacity-8">
                                                        <i class="fa fa-download fa-w-20"></i>
                                                    </span>
                                                    <span>Save</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- End Main -->
@endsection
