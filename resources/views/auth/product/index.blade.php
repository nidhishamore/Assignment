@extends('auth.product.layout')

@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{$message}}</p>
        </div>
    @endif
    <div class="pull-right">
        <a class="btn btn-primary" href="/products/create"> Add Product </a>
    </div>
    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Date Created</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->description ?? '--'}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->created_at}}</td>
                <td>
                    <form method="POST" action="{{ route('products.destroy',$product->product_id) }}">
                    <a href="{{ route('products.show',$product->product_id) }}" title="show">
                        <i class="fas fa-eye text-success  fa-lg"></i>
                    </a>

                    <a href="{{ route('products.edit',$product->product_id) }}">
                        <i class="fas fa-edit  fa-lg"></i>
                    </a>
                        @csrf
                        @method('DELETE')

                        <button type="submit" title="delete" style="border: none; background-color:transparent;">
                            <i class="fas fa-trash fa-lg text-danger"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
{!! $products->links() !!}
@endsection