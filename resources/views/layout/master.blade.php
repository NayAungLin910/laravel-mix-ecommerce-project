<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-Commerce</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Padauk:wght@400;700&family=Poppins:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Toastify CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('web_asset/css/argon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web_asset/css/style.css') }}">
    @yield('style')
</head>

<body>
    <!-- header -->
    @if (request()->is('/'))
        @include('layout.homeHeader')
    @else
        @include('layout.header')
    @endif

    @yield('content')
    <div class="bg-dark p-5 text-center text-white">
        Develop By <a href="https://mmcoder.com" class="text-success">MM-Coder</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <!-- Toastify Script -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- Session flashing -->
    @if (session()->has('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                // className: ['bg-danger'],
                style: {
                    background: "linear-gradient(to right, #F58C7E, #F02C11)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    @if (session()->has('info'))
        <script>
            Toastify({
                text: "{{ session('info') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #9CB1E9, #5B82EA)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                destination: "", // can put link 
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #76CA86, #35CD52)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        </script>
    @endif

    <script src="{{ asset('web_asset/js/argon.min.js') }}"></script>
    <script>
        window.updateCart = cart => {
            const cartCount = document.getElementById('cartCount');
            cartCount.innerText = cart;
        }
        window.auth = @json(auth()->user());
        window.locale =  "{{ app()->getLocale() }}"

        const showToast = (message, type) => {
            if (type == "info") {
                Toastify({
                    text: message,
                    duration: 3000,
                    destination: "", // can put link 
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #9CB1E9, #5B82EA)",
                    },
                    onClick: function() {} // Callback after click
                }).showToast();
            }
            if (type == "success") {
                Toastify({
                    text: message,
                    duration: 3000,
                    destination: "", // can put link 
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #76CC68, #40CD29)",
                    },
                    onClick: function() {} // Callback after click
                }).showToast();
            }
            if (type == "error") {
                Toastify({
                    text: message,
                    duration: 3000,
                    destination: "", // can put link 
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #F07E63, #F04D26)",
                    },
                    onClick: function() {} // Callback after click
                }).showToast();
            }

        }
    </script>
    @yield('script')
</body>

</html>
