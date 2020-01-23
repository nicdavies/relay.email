<?php

namespace App\Http\Controllers\Web\Billing\Invoice;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class ReadController extends Controller
{
    /**
     * @param Request $request
     * @param string $invoiceId
     * @return Response
     */
    public function __invoke(Request $request, string $invoiceId)
    {
        /** @var User $user */
        $user = $request->user();

        // todo - take another stab at this feature, since it's broken in php7.4
        // @see https://github.com/barryvdh/laravel-dompdf/issues/636

        return $user->downloadInvoice($invoiceId, [
            'vendor' => config('app.name'),
            'product' => 'Premium',
        ]);
    }
}
