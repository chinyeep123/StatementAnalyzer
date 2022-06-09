@extends('layouts.user-dashboard')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexboxgrid/6.3.1/flexboxgrid.min.css" integrity="sha512-YHuwZabI2zi0k7c9vtg8dK/63QB0hLvD4thw44dFo/TfBFVVQOqEG9WpviaEpbyvgOIYLXF1n7xDUfU3GDs0sw==" crossorigin="anonymous" />
    
    <div id="primary" class="content-area primary">
        <main id="main" class="site-main">
            <div class="ast-woocommerce-container">

            <nav class="woocommerce-breadcrumb">
                <a href="{{ url('/') }}">Home</a>&nbsp;&#47;&nbsp;Orders</nav>
                <header class="woocommerce-products-header">
                    <h1 class="woocommerce-products-header__title page-title">View Orders</h1>
                </header>
            </nav>

            <div style="margin-bottom: 10px;">
                <div class="row">
                    <div class="col-md-3">Reference</div>
                    <div class="col-md-3">{{ $order->reference }}</div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">Status</div>
                    <div class="col-md-3">{{ $order->statusText }}</div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">Total</div>
                    <div class="col-md-3">{{ $order->displayTotal() }}</div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">Date</div>
                    <div class="col-md-3">{{ $order->created_at }}</div>
                </div>
            </div>

            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                <thead>
                    <tr>
                        <th class="product-name">Product</th>
                        <th class="product-price">Price</th>
                        <th class="product-quantity">Quantity</th>
                        <th class="product-subtotal">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr class="woocommerce-cart-form__cart-item cart_item">
                            <td><a target="_blank" href="{{ $item->url }}">{{ $item->name }}</a></td>
                            <td>{{ $item->displayPrice }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td style="text-align: right">{{ $item->displayTotal }}</td>
                        </tr>
                    @endforeach
                    
                    @foreach($order->getCharges() as $charges)
                        <tr>
                            <td colspan="3" class="text-right" style="text-align: right">
                                {{ $charges->getText() }}
                            </td>
                            <td style="text-align: right">
                                {{ $charges->displayPrice() }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right" style="text-align: right">
                            Total:
                        </td>
                        <td style="text-align: right">
                            {{ $order->displayTotal() }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="row">
                <div class="col-md-6">
                    <h2>Billing Address</h2>
                    <div>{{ $order->billpayer->company_name }}<br/>
                    {{ $order->billpayer->name }}<br/>
                    {{ $order->billpayer->address->fullAddress }}
                    </div>
                    <div>{{ $order->billpayer->contact_number }}</div>
                </div>
                <div class="col-md-6">
                    <h2>Shipping Address</h2>
                    <div>{{ $order->shippingContact->lastname }} {{ $order->shippingContact->firstname }}<br/>
                    {{ $order->shippingContact->address->fullAddress }}</div>
                    <div>{{ $order->shippingContact->contact_number }}</div>
                </div>
            </div>
        </main>
    </div>
@endsection