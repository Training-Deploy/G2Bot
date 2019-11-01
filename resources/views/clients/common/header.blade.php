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
                    @else
                        <li><a href="{{ route('login-client') }}">Login</a></li>
                    @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container mx-auto flex flex-wrap mt-4 md:-mt-16 z-10">
        <div class="w-full flex flex-wrap px-4 z-10">
            <div class="w-full lg:w-3/5 flex flex-wrap justify-center flex-col">
                <div class="md:mt-10 md:mr-16 md:pr-8">
                    <div class="md:bg-white rounded flex flex-wrap md:flex-no-wrap md:p-1 mt-6 relative">
                        <input type="text" placeholder="API Key" v-model="apiKey" class="l-h rounded bg-white flex-grow outline-none p-4-template md:py-0 font-medium tracking-wide text-purple"> <!---->
                        <button v-on:click="getBotsInfor()" class="btnmain md:btnmain-lg btnmain-green-gradient flex items-center p-4-template mt-2 md:mt-0 w-full md:w-auto justify-center">
                            <span>Start</span> <!---->
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full py-4 text-center align-end text-4xl h-16 self-end z-10"></div>
</header>
