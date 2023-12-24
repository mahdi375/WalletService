<?php

namespace App\Http\Controllers\V1;

use App\Traits\RespondApi;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests;
    use RespondApi;
    use ValidatesRequests;
}
