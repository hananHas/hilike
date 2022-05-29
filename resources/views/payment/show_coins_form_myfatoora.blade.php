<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>HiLike</title>

  

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
        .StripeElement--invalid {
            border-color: #fa755a;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
        .container {
        display: flex;
        justify-content: center;
        }
        .center {
        width: 80%;
        }
    </style>
</head>
<body>

    {{-- <div class="wrapper">
        <div class="content-wrapper">
            <div class="row">
                <div class="container">
                    <div class="center">
                
                <form method="POST" action="{{ route('plan.pay', $user_id) }}" class="card-form mt-3 mb-3">
                    @csrf
                    <input type="hidden" name="payment_method" class="payment-method">
                    <input type="hidden" name="package_id" value="{{$package_id}}">
                    <input type="hidden" name="plan_id" value="{{$plan_id}}">
                    <input class="form-control" name="card_holder_name" placeholder="Card holder name" required><br>
                    <div class="col-lg-12 col-md-12">
                        <div id="card-element"></div>
                    </div>
                    <div id="card-errors" role="alert"></div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary pay">
                            Purchase
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
        </div>
    </div>
 --}}

 <div style="margin-top:30px">
    <div id="card-element"></div>
<button style="margin-left:20px" class="btn btn-primary pay" onclick="submit()">Purchase</button>

</div>



<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
<script src="https://portal.myfatoorah.com/cardview/v1/session.js"></script>
<script>
var config = {
    countryCode: '{{$intent->CountryCode}}', // Here, add your Country Code you receive from InitiateSession Endpoint.
    sessionId: '{{$intent->SessionId}}', // Here you add the "SessionId" you receive from InitiateSession Endpoint.
    cardViewId: "card-element",
          // The following style is optional.
    style: {
        direction: "ltr",
        cardHeight: 200,
        input: {
            color: "black",
            fontSize: "13px",
            fontFamily: "sans-serif",
            inputHeight: "32px",
            inputMargin: "15px",
            borderColor: "c7c7c7",
            borderWidth: "1px",
            borderRadius: "8px",
            boxShadow: "",
            placeHolder: {
                holderName: "Name On Card",
                cardNumber: "Number",
                expiryDate: "MM / YY",
                securityCode: "CVV",
            }
        },
        label: {
            display: false,
            color: "black",
            fontSize: "13px",
            fontWeight: "normal",
            fontFamily: "sans-serif",
            text: {
                holderName: "Card Holder Name",
                cardNumber: "Card Number",
                expiryDate: "Expiry Date",
                securityCode: "Security Code",
            },
        },
        error: {
            borderColor: "red",
            borderRadius: "8px",
            boxShadow: "0px",
        },
    },
};
myFatoorah.init(config);


function submit() {
    myFatoorah.submit()
    // On success
    .then(function (response) {
    // Here you need to pass session id to you backend here
    var sessionId = response.SessionId;
    var cardBrand = response.CardBrand;
    var coin_id = '{{$coin_id}}';
    var user_id = '{{$user_id}}';
    var csrf = document.querySelector('meta[name="csrf-token"]').content;
    $.ajax({
        url: '{{url("/coin/my_fatoora_payment")}}'+"/"+ coin_id,
        type: 'post',
        data : {
            sessionId: sessionId,
            cardBrand: cardBrand,
            user_id: user_id,
            _token: csrf
        },
        
        success: function(data){
            console.log(data) 
        },
        error: function(error){
            console.log(error);  
        }
    });
    
    })
    // In case of errors
    .catch(function (error) {
        console.log(error);
    });
}
</script>
</body>
</html>
