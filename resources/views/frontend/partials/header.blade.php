 <header id="header">
    <nav class="navbar navbar-fixed-top" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('frontend.home') }}">Ticket Reservation</a>
            </div>
             <div class="collapse navbar-collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{ route('frontend.home') }}">Home</a></li>
                    
                    <li><a href="{{route('frontend.reserve')}}">Reservation</a></li>
                    
                    <li><a href="#contact">Contact</a></li>

                    @if(auth()->user())
                    <li><a href="">{{auth()->user()->name}}  </a></li> 
                    <li><a href="{{route('user.logout')}}">  Logout</a></li> 
                    @else           
                    <li><a href="{{route('user.login')}}">Login</a></li>  
                    <li><a href="{{route('user.registration')}}">Registration</a></li>  
                    @endif                   
                       
                </ul>
            </div>
        </div><!--/.container-->
    </nav><!--/nav-->		
</header><!--/header-->	
