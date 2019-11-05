<header id="header-hero" class="h-screen w-full flex flex-wrap justify-between flex-col overflow-hidden relative">
    <div class="hero-svg pin-r pin-b block absolute z-0"></div>
    <div class="w-full container mx-auto z-10">
        <nav class="w-full flex flex-col flex-wrap md:flex-row md:flex-no-wrap text-white">
            <ul class="list-reset flex justify-between items-center text-lg px-4 py-0 md:py-4 lg:px-0 w-full md:w-auto lg:mr-8">
                <li class="flex items-center"><img src="/img/bot.png" alt="Bot Logo" style="height: 70px;"></li>
                <li class="md:hidden"><a title="Toggle Mobile Navigation" class="text-3xl"><i class="fas fa-ellipsis-h "></i> <i class="fal fa-ellipsis-h-alt" style="display: none;"></i></a></li>
            </ul>
            <div class="nav-content">
                <div class="md:w-full md:flex">
                    <ul></ul>
                    <ul>
                    @if(Auth::user())
                        <li><a href="#">{{ Auth::user()->name }} </a></li>
                        <li><a href="{{ route('logout-client') }}">Logout</a></li>
                        <input type="hidden" id="checkAuth" value="{{ Auth::user() }}">
                    @else
                        <li><a href="{{ route('login-client') }}">Login</a></li>
                    @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="w-full py-4 text-center align-end text-4xl h-16 self-end z-10"></div>
</header>
