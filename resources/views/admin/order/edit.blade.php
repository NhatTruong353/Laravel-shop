
@extends('admin.layout.master')

@section('title','Order Status')

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
                                    Order
                                    <div class="page-title-subheading">
                                        View, create, update, delete and manage.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <form action="/admin/order/{{$order->id}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        @include('admin.components.notification')


                                        <div class="position-relative row form-group">
                                            <label for="name" class="col-md-3 text-md-right col-form-label">ID Order</label>
                                            <div class="col-md-9 col-xl-8">
                                                <input disabled name="name" id="name"  type="text"
                                                    class="form-control" value="#{{ $order->id }}">
                                            </div>
                                        </div>

                                        <div class="position-relative row form-group">
                                            <label for="date" class="col-md-3 text-md-right col-form-label">Date</label>
                                            <div class="col-md-9 col-xl-8">
                                                <input disabled name="name" id="date"  type="text"
                                                       class="form-control" value="{{ $order->created_at }}">
                                            </div>
                                        </div>
                                        <div class="position-relative row form-group">
                                            <label for="pay" class="col-md-3 text-md-right col-form-label">Payment Type</label>
                                            <div class="col-md-9 col-xl-8">
                                                <input disabled name="name" id="pay"  type="text"
                                                       class="form-control" value="{{ $order->payment_type }}">
                                            </div>
                                        </div>

                                        <div class="position-relative row form-group">
                                            <label for="total" class="col-md-3 text-md-right col-form-label">Total</label>
                                            <div class="col-md-9 col-xl-8">
                                                <input disabled name="name" id="total"  type="text"
                                                       class="form-control" value="${{$order->total_order}}">
                                            </div>
                                        </div>

                                        <div class="position-relative row form-group">
                                            <label for="status"
                                                class="col-md-3 text-md-right col-form-label">Status</label>
                                            <div class="col-md-9 col-xl-8">
                                                @if($order->payment_type == "pay_later")
                                                <select required name="status" id="status" class="form-control">
                                                    <option value="">-- Status --</option>
                                                    @foreach(\App\Utilities\Constant::$order_status as $key => $value)
                                                        <option value={{$key}} {{$order->status == $key ? 'selected' : ''}}>
                                                            {{$value}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @else
                                                    <select required name="status" id="status" class="form-control">
                                                        <option value="">-- Status --</option>
                                                        @foreach(array_slice(\App\Utilities\Constant::$order_status,3) as $key => $value)
                                                            <option value={{$key + 4}} {{$order->status == ($key + 4) ? 'selected' : ''}}>
                                                                {{$value}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>



                                        <div class="position-relative row form-group mb-1">
                                            <div class="col-md-9 col-xl-8 offset-md-2">
                                                <a href="./admin/user" class="border-0 btn btn-outline-danger mr-1">
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
