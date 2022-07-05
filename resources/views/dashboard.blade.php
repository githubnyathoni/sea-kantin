@extends('layouts.app')

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{$message}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Products -->
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="d-flex card-header justify-content-between">
                    <h5 class="card-title">Products</h5>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#productModal">Add Product</button>
                </div>

                <!-- Modal Create Product -->
                <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('storeProduct') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="productModalLabel">New Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="col-form-label">Name:</label>
                                        <input type="text" name="name" class="form-control" id="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stock" class="col-form-label">Stock:</label>
                                        <input type="number" name="stock" class="form-control" id="stock" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="col-form-label">Price:</label>
                                        <input type="number" name="price" class="form-control" id="price" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="col-form-label">Description:</label>
                                        <textarea class="form-control" name="description" id="description" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="col-form-label">Image:</label>
                                        <input type="file" name="image" accept="image/*" class="form-control" id="image" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Name</th>
                                  <th scope="col">Description</th>
                                  <th scope="col">Stock</th>
                                  <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $key => $product)
                                    <tr>
                                      <th>{{$products->firstItem() + $key}}</th>
                                      <td>{{$product->name}}</td>
                                      <td>{{$product->description}}</td>
                                      <td>{{$product->stock}}</td>
                                      <td>@rupiah($product->price)</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">You don't have any products</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            {!! $products->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Balance -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Balance</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="text-center mt-3">
                                <h3>@rupiah($balance)</h3>
                                <small class="text-muted">Balance Available</small>
                            </div>
                        </div>
                        <div class="col">
                            <form method="POST" action="{{ route('withdrawBalance') }}">
                                @csrf
                                <label>Amount</label>
                                <input type="number" class="form-control" min="0" max="{{$balance}}" name="amount" required>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary text-center mt-2">Withdraw</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- History of Seller -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">History</h5>
                </div>
                <div class="card-body">
                    @forelse($history as $item)
                        <div class="row">
                            <div class="col">
                                <h6 class="mb-0">Someone has bought your {{$item->product->name}} {{$item->qty}} pieces.</h6>
                                <small class="text-muted text-end">{{$item->created_at->diffForHumans()}}</small>
                            </div>
                        </div>
                    @empty
                        <div class="row">
                            <div class="col">
                                <p class="text-center">You never sold anything.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
