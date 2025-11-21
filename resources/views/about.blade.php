@extends('layouts.app')

@section('title', 'About')
@section('description', 'Learn more about our company, mission, and values. Discover what makes us unique and why you should choose us.')
@section('keywords', 'about, company, mission, values, team, information')

@section('header-actions')
@endsection

@push('head')
    <style>
        .hero-header{
            width: 100%;
            min-height: calc(100vh - 100px); /* Adjust for header and padding */
            background: #222;
            padding: 2rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .wrapper{
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding-top: 2rem;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .container .hero-pic{
            width: 300px;
            height: 300px;
            border-radius: 50%;
            overflow: hidden;
            border: 15px solid #444;
            box-shadow: 5px 7px 25px rgba(0,0,0,0.5);
        }
        .hero-pic img{
            height: 100%;
            width: 100%;
            transition: 0.5s;
        }
        .hero-pic img:hover{
            transform: scale(1.2);
        }
        .hero-text{
            max-width: 500px;
            display: flex;
            flex-direction: column;
            color: #e5e5e5;
        }
        .hero-text h5{
            color:#e5e5e5;
            font-size: 14px;
        }
        .hero-text h1{
            color: #007ced;
            font-size: 3rem;
        }
        .hero-text p{
            color:#e5e5e5;
        }
        .btn-group{
            margin:45px 0;
        }
        .btn-group .btn{
            border-color: #d5d5d5;
            color:#fff;
            background-color: #333;
            padding: 12px 25px;
            margin: 5px 5px;
            margin-right:7px;
            border-radius: 30px;
            border:2px solid #e5e5e5;
            box-shadow:  0 10px 10px -8px rgb(0 0 0 / 78%);
            text-decoration: none;
            display: inline-block;
        }
        .btn.active{
            border-color: #007ced;
        }
        .hero-text .social i{
            color: #e5e5e5;
            font-size: 18px;
            margin-right: 15px;
            transition: 0.5s;
            cursor: pointer;
        }
        .hero-text .social i:hover{
            color:#007ced;
            transform: rotate(360deg);
        }

        /* Mobile */
        @media (max-width:768px){
            .container{
                flex-direction: column;
                padding-top:2rem;
                text-align: center;
            }
            .hero-text{
                padding:40px 0px;
                align-items: center;
            }
            .hero-text .social {
                text-align: center;
                display: flex;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="hero-header">
        <div class="wrapper">
            <div class="container">
                <div class="hero-pic">
                    <img src="{{ asset('images/main_photo.webp') }}" alt="profile pic">
                </div>

                <div class="hero-text">
                    <h5>Hi I'm</h5>
                    <h1><span class="input">Dedi Ir</span></h1>

                    <p>I'm just an ordinary guy who is interested in the world of editing, drawing, poetry, rhymes, literation, photography.</p>

                    <div class="btn-group">
                        <a href="https://edu.abjad.eu.org" class="btn active">Dedi Ir</a>
                        <a href="https://edu.abjad.eu.org" class="btn active">https://edu.abjad.eu.org</a>
                    </div>

                    <div class="social">
                        <a href="https://www.instagram.com/ded.dedii"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Typed.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.10/typed.min.js"></script>
    <script>
        // Typed Animation
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof Typed !== 'undefined') {
                var typed = new Typed(".input", {
                    strings: ["Dedi Ir","Dedi Ir","Dedi Ir"],
                    typeSpeed: 55,
                    backSpeed: 55,
                    loop: true
                });
            }

            console.log("About page loaded with Dedi IR profile! 🚀");
        });
    </script>
@endpush