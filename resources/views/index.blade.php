@include('includes.header')

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1 class="my-4">Главная</h1>
        </div>
        @foreach ($products as $product)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <img class="card-img-top" src="{{ $product->image }}" alt="{{ $product->name }}" style="height: 600px; object-fit: cover;">
                    <div class="card-body">
                        <h2 class="card-title">{{ $product->name }}</h2>
                        <a href="{{ route('product.show', $product) }}" class="btn btn-warning">Подробнее</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@include('includes.footer')
