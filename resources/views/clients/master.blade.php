<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>BOT</title>
        <link rel="apple-touch-icon" sizes="180x180" href="/img/bot.png">
        <link rel="icon" type="image/png" href="/img/bot.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/img/bot.png" sizes="16x16">
        <meta name="theme-color" content="#1d185e">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}">
        @yield('style')
    </head>
    <body id="top" class="leading-normal text-purple-dark">
        <div id="app-wrapper" class="min-h-screen flex flex-col justify-between">
            <div id="app" class="landing-page flex-grow flex flex-col">
                <div>
                    @include('clients.common.header')
                </div>
                <div class="flex-grow flex flex-col ">
                    <section id="lessons" class="pt-24 py-8 px-4 bg-pale-blue-lighter">
                        <div class="mx-auto container mb-12">
                            <h2 class="text-purple-dark text-2xl mb-6">
                                BOT Information
                            </h2>
                            <div class="bg-white rounded-lg p-6 md:flex lg:block">
                                <a class="thumb-card block text-purple hover:text-purple flex-1 lg:flex pb-4 mb-8 border-b md:p-0 md:border-0 md:mb-0 md:mr-6 lg:mr-0">
                                    <div class="thumbnail rounded-lg mb-4 bg-blue-darker text-white text-4xl items-center justify-center flex h-48 md:w-full lg:mr-6 lg:h-32 lg:w-64 lg:mb-0 lg:mb-2">
                                        <div>
                                            SOON
                                        </div>
                                    </div>
                                    <div class="md:pt-6 lg:flex-1 lg:flex lg:justify-between lg:items-center lg:border-b">
                                        <div>
                                            <div class="flex justify-between mb-6 lg:hidden">
                                                <div></div>
                                                <div><span class="py-1 px-2 uppercase bg-iron-darker text-xs rounded-sm inline-block">
                                                    Intermediate
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex items-start mb-2">
                                                <h3 class="text-xl lg:text-2xl leading-normal tracking-normal font-normal">
                                                    Awesome BOT
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-right leading-loose hidden lg:block">
                                            <div class="text-sm flex justify-end mb-2"></div>
                                            <div>
                                                <span class="py-1 px-2 uppercase bg-iron-darker text-xs rounded-sm inline-block">
                                                Delete
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="mx-auto container mb-12">
                            <h2 class="text-purple-dark text-2xl mb-6">
                                List Room
                            </h2>
                            <div class="bg-white rounded-lg p-6 md:flex lg:block">
                                <a class="thumb-card block text-purple hover:text-purple flex-1 lg:flex pb-4 mb-8 border-b md:p-0 md:border-0 md:mb-0 md:mr-6 lg:mr-0">
                                    <div class="thumbnail rounded-lg mb-4 bg-blue-darker text-white text-4xl items-center justify-center flex h-48 md:w-full lg:mr-6 lg:h-32 lg:w-64 lg:mb-0 lg:mb-2">
                                        <div>
                                            SOON
                                        </div>
                                    </div>
                                    <div class="md:pt-6 lg:flex-1 lg:flex lg:justify-between lg:items-center lg:border-b">
                                        <div>
                                            <div class="flex justify-between mb-6 lg:hidden">
                                                <div></div>
                                                <div><span class="py-1 px-2 uppercase bg-iron-darker text-xs rounded-sm inline-block">
                                                    Intermediate
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex items-start mb-2">
                                                <h3 class="text-xl lg:text-2xl leading-normal tracking-normal font-normal">
                                                    [Dev] [Example] Project Manager
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-right leading-loose hidden lg:block">
                                            <div class="text-sm flex justify-end mb-2"></div>
                                            <div>
                                                <span class="py-1 px-2 uppercase bg-iron-darker text-xs rounded-sm inline-block">
                                                Selected
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a class="thumb-card block text-purple hover:text-purple flex-1 lg:flex ">
                                    <div class="thumbnail rounded-lg mb-4 bg-blue-darker text-white text-4xl items-center justify-center flex h-48 md:w-full lg:mr-6 lg:h-32 lg:w-64 lg:mb-0 lg:mt-2">
                                        <div>
                                            SOON
                                        </div>
                                    </div>
                                    <div class="md:pt-6 lg:flex-1 lg:flex lg:justify-between lg:items-center ">
                                        <div>
                                            <div class="flex justify-between mb-6 lg:hidden">
                                                <div></div>
                                                <div><span class="py-1 px-2 uppercase bg-iron-darker text-xs rounded-sm inline-block">
                                                    Advanced
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex items-start mb-2">
                                                <h3 class="text-xl lg:text-2xl leading-normal tracking-normal font-normal">
                                                    Exercise 1: Rendering a List of Users
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-right leading-loose hidden lg:block">
                                            <div class="text-sm flex justify-end mb-2"></div>
                                            <div><span class="py-1 px-2 uppercase bg-iron-darker text-xs rounded-sm inline-block">
                                                Select
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            @include('clients.common.footer')
        </div>
        @yield('script')
    </body>
</html>
