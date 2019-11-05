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
                        <li><a href="#loginModal" role="button" data-toggle="modal">Login</a></li>
                    @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div id="loginModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Login</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="text-center social-btn">
                        <a  href="{{ route('login-client') }}" class="btn btn-primary btn-block"><i class="fab fa-google"></i> Sign in with <b>Google</b></a>
                    </div>
                    <div class="or-seperator"><i>or</i></div>
                    <form class="form" role="form" autocomplete="off" id="formLogin" novalidate="" v-on:submit.prevent="login()">
                        <div class="form-group">
                            <label for="uname1">Email</label>
                            <input type="email" v-model.trim="credentials.email" class="form-control form-control-lg" :class="{ 'error-input': loginErrors && loginErrors.email[0] } "name="email" id="emai;" required="">
                            <div v-if="loginErrors && loginErrors.email[0]" class="error-form">@{{ loginErrors.email[0] }}</div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" v-model.trim="credentials.password" class="form-control form-control-lg" class="{ 'error-input: loginErrors && loginErrors.password'}" id="pwd1" required="" autocomplete="new-password">
                            <div v-if="loginErrors && loginErrors.password" class="error-form">@{{ loginErrors.password[0] }}</div>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="rememberMe" name="remember" v-model="credentials.remember">
                          <label class="custom-control-label" for="rememberMe">Remember me</label>
                        </div>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-success btn-lg" id="btnLogin">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
