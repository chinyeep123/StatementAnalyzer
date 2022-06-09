<?php
namespace Ant\StatementAnalyzer\Http\Controllers\Web;

// use App\Models\Order;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StatementAnalyzerController extends Controller {
    public function index() {
        return view('statement-analyzer::index');
        // $orders = \App\Models\Order::where('user_id', Auth::user()->id)->latest()->paginate(5);
        // return view('order.index', compact('orders'));
    }

    public function show() {
        
    }

    // public function showSigned (Order $order) {
    //     if (Auth::check() && Auth::user()->id == $order->user_id) {
    //         return redirect($order->url);
    //     }
    //     return view('order.show-signed', compact('order'));
    // }

    // public function downloadPdf(Order $order) {
    //     // Use signed route instead
    //     // if ($order->user_id != Auth::user()->id && !$this->authorize('invoice.downloadAny')) {
    //     //     abort(403, 'Access Denied');
    //     // }

    //     return $order->invoice->downloadPdf($order->number.'-invoice.pdf');
    // }
}