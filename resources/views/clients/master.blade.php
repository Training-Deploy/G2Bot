<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>BOT</title>
        <link rel="apple-touch-icon" sizes="180x180" href="/img/bot.png">
        <link rel="icon" type="image/png" href="/img/bot.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/img/bot.png" sizes="16x16">
        <meta name="theme-color" content="#1d185e">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/library/app.css') }}">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

        @yield('style')
    </head>
    <body id="top" class="leading-normal text-purple-dark">
        <div id="app-wrapper" class="min-h-screen flex flex-col justify-between">
            <div id="app" class="landing-page flex-grow flex flex-col" v-cloak>
                <div>
                    @include('clients.common.header')
                </div>
                <div class="flex-grow flex flex-col ">
                    <section id="lessons" class="pt-24 py-8 px-4 bg-pale-blue-lighter">
                        <div id="upload" class="mx-auto container mb-12">
                            <h2 class="text-purple-dark text-2xl mb-6">
                                @{{ title }}
                            </h2>
                            <div class="bg-white rounded-lg p-6 md:flex lg:block">
                                <div>
                                    <div class="flex items-start mb-2 d-flex justify-content-center">
                                        <div class="alert alert-warning" role="alert">
                                            <strong>Notice</strong>
                                            <p>
                                                File Support Type : xlsx <br />
                                                Sheet Name Format : <span class="badge badge-success">MemberInfo</span> <br />
                                                Columns Name Format (Require and Optional) : <br />
                                                <span class="badge badge-danger"> fullname </span>
                                                <span class="badge badge-danger"> birthday </span>
                                                <span class="badge badge-secondary"> phone_number </span>
                                                <span class="badge badge-secondary"> gmail </span>
                                                <span class="badge badge-secondary"> github_account </span>
                                                <span class="badge badge-secondary"> viblo_account_link </span>
                                                <span class="badge badge-secondary"> ssh_public_key </span>
                                                <span class="badge badge-secondary"> chatwork_account </span>
                                                <span class="badge badge-secondary"> company_email </span>
                                            </p>
                                        </div>
                                        
                                    </div>
                                    <div id="errors" class="flex items-start mb-2 d-flex justify-content-center">
                                    
                                    </div>
                                </div>
                                <a
                                    class="thumb-card block text-purple hover:text-purple flex-1 lg:flex pb-4 mb-8 border-b md:p-0 md:border-0 md:mb-0 md:mr-6 lg:mr-0">
                                    <div class="d-flex justify-content-center md:pt-6 lg:flex-1 content:center lg:flex lg:justify-between lg:items-center lg:border-b">
                                        <form v-on:submit.prevent="attachmentCreate" class="dropzone">
                                            <div>
                                                <h3 class="text-xl lg:text-2xl leading-normal tracking-normal font-normal">
                                                    <div class="form-group">
                                                        <label for="SheetName">Sheet Name Info Members</label>
                                                        <input type="text" class="form-control" v-model="sheetName"
                                                            name="sheetName" id="sheetName" aria-describedby="helpId"
                                                            placeholder="">
                                                    </div>
                                                </h3>
                                                
                                                <div class="flex items-start mb-2">
                                                    <h3
                                                        class="text-xl lg:text-2xl leading-normal tracking-normal font-normal">
                                                        <div class="form-group">
                                                            <label for="FileSelect">File Select ( .xlsx )</label>
                                                            <div class="custom-file mb-3">
                                                                <input type="file" class="custom-file-input" id="customFile" name="file" @change="onFileChange">
                                                                <label class="custom-file-label" for="customFile">@{{ fileName }}</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary float-right">Upload</button>
                                                    </h3>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </a>
                                <table id="list-members" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Birthday</th>
                                            <th>Company Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
            
                                    </tbody>
                                </table>
                            </div>
                        </div>            
                        <div class="mx-auto container mb-12">
                            <h2 class="text-purple-dark text-2xl mb-6">
                                BOT Information
                            </h2>
                            <div class="bg-white rounded-lg p-6 md:flex lg:block">
                                <a class="thumb-card block text-purple hover:text-purple flex-1 lg:flex pb-4 mb-8 border-b md:p-0 md:border-0 md:mb-0 md:mr-6 lg:mr-0">
                                    <img v-if="bots.infor" v-bind:src="bots.infor.avatar_image_url" class="thumbnail rounded-lg mb-4 bg-blue-darker text-white text-4xl items-center justify-center flex h-48 md:w-full lg:mr-6 lg:h-32 lg:w-64 lg:mb-0 lg:mb-2"/>
                                    <div v-else class="thumbnail rounded-lg mb-4 bg-blue-darker text-white text-4xl items-center justify-center flex h-48 md:w-full lg:mr-6 lg:h-32 lg:w-64 lg:mb-0 lg:mb-2">
                                        <div>
                                            SOON
                                        </div>
                                    </div>
                                    <div class="md:pt-6 lg:flex-1 lg:flex lg:justify-between lg:items-center lg:border-b">
                                        <div>
                                            <div class="flex items-start mb-2">
                                                <h3 class="text-xl lg:text-2xl leading-normal tracking-normal font-normal">
                                                    @{{ bots.infor ? bots.infor.name : "Bot Name" }}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-right leading-loose hidden lg:block">
                                            <div class="text-sm flex justify-end mb-2"></div>
                                            <div>
                                                <span class="py-1 px-2 uppercase bg-iron-darker text-xs rounded-sm inline-block">
                                                Save
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="mx-auto container mb-12" v-if="bots.rooms" >
                            <h2 class="text-purple-dark text-2xl mb-6">
                                List Room
                            </h2>
                            <div class="bg-white rounded-lg p-6 md:flex lg:block" v-for="room in bots.rooms">
                                <a class="thumb-card block text-purple hover:text-purple flex-1 lg:flex pb-4 mb-8 border-b md:p-0 md:border-0 md:mb-0 md:mr-6 lg:mr-0">
                                    <img v-bind:src="room.icon_path" class="thumbnail rounded-lg mb-4 bg-blue-darker text-white text-4xl items-center justify-center flex h-48 md:w-full lg:mr-6 lg:h-32 lg:w-64 lg:mb-0 lg:mb-2"/>
                                    <div class="md:pt-6 lg:flex-1 lg:flex lg:justify-between lg:items-center lg:border-b">
                                        <div>
                                            <div class="flex items-start mb-2">
                                                <h3 class="text-xl lg:text-2xl leading-normal tracking-normal font-normal">
                                                    @{{ room.name }}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="text-right leading-loose hidden lg:block">
                                            <div class="text-sm flex justify-end mb-2"></div>
                                            <div>
                                                <span class="py-1 px-2 uppercase bg-iron-darker text-xs rounded-sm inline-block">
                                                Selecte
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
            </div>
            @include('clients.common.footer')
            <script>
                window.data = {
                    'auth': '{!! Auth::user() ? true : false !!}',
                }
            </script>
        </div>
        <script src="{{ mix('/js/library/app.js') }}"></script>
        <script src="{{ asset('/js/mixin.js') }}"></script>
        <script src="{{ asset('/js/home.js') }}"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        @yield('script')
    </body>
</html>
