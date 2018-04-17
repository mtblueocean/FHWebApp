@extends('layouts.app')

@section('content')       
<section style="margin-top: 80px" id="slider"><!--slider-->
    @if(isset($csrf_error))
        <script>
            showAlert("{{$csrf_error}}");
        </script>
    @endif

    <div class="home-container" style="padding-top: 140px">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">

                <div class="col-sm-6 col-md-6 col-lg-6 video-container">                   
                    <iframe width="640" height="360" src="https://www.youtube.com/embed/e55jQCk5-PY?rel=0&amp;contols=0&amp;showinfo=0"
frameborder="0" allowfullscreen class=""></iframe>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6 home-right">
                    <p class="p1">Find a program. Track your progress. Change Your Life.</p>
                    <div class="col-sm-12">
                        <div class="col-sm-4 col-md-4 col-lg-4"  class="home-right-image">
                            <img src="{{asset('images/home/E-Commerce.png')}}"  alt="" />
                            <p class="p2">Program Finder Marketplace</p>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4"  class="home-right-image">
                            <img src="{{asset('images/home/Marketing.png')}}" alt="" />
                            <p class="p2">Workout + Nutrition Tracker</p>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4"  class="home-right-image">
                            <img src="{{asset('images/home/App_Development.png')}}" alt="" />
                            <p class="p2">Simple Activity Management</p>
                        </div>
                    </div>
                    <p style="text-align: center; margin-top: 50px; font-size: 20px">FitHabit is a powerful & easy to use personal workout tracker for iOS. Choose from free workout and nutrition plans or
get custom plans created by some of the worlds best personal trainers delivered seamlessly to your device. You'll be able to easily track your journey to better health with FitHabit.</p>
                    <div style="text-align: center; margin-top: 30px; font-size: 22px">
                        <a href="https://www.fithabit.io/application" style="color:#9893eb">View All Features</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section><!--/slider-->
@endsection