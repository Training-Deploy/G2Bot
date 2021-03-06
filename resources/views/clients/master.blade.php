<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>BOT</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/img/bot.png">
    <link rel="icon" type="image/png" href="/img/bot.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/img/bot.png" sizes="16x16">
    <meta name="theme-color" content="#1d185e">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/library/app.css') }}">

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
                            Upload File Excel
                        </h2>
                        <div class="bg-white rounded-lg p-6 md:flex lg:block box-shadow">
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
                                                <label for="FileSelect">File Select <span class="badge badge-success">.xlsx</span></label>
                                                <upload csrf="{{ csrf_token() }}"></upload>
                                            </div>
                                        </h3>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </a>
                </div>
            </div>
            <listmember v-if="auth" ref="members"></listmember>
            
            <div class="mx-auto container mb-12">
                <h2 class="text-purple-dark text-2xl mb-6">
                    BOT
                </h2>
                <div class="bg-white rounded-lg p-6 md:flex lg:block box-shadow">
                    <div class="form-row">
                        <div class="col-md-8 mb-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="validationTooltip01">API KEY</label>
                                    <input type="text" v-model="api_key" v-on:keyup="checkBot()" placeholder="Please add api key" class="form-control mb-3" id="apikey" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="needs-validation" v-on:submit.prevent="saveBot">
                                        <label for="validationTooltip03">AccountID</label>
                                        <input type="text" class="form-control mb-3" :class="{ 'error-input': formErrors && formErrors.account_id[0]}" v-model="account_id" name="account_id" id="account_id">
                                        <div v-if="formErrors && formErrors.account_id[0]" :class="{ 'error-form': formErrors && formErrors.account_id[0]}" >
                                            @{{ formErrors.account_id[0] }}
                                        </div>
                                        <button class="el-button el-button--primary" :class="{ 'is-disabled': !bots.infor }" :disabled="!bots.infor" type="submit">Save</button>
                                        <button class="el-button el-button--primary" class="form-control" type="button" v-on:click="checkBot()">Check API</button>
                                    </form>
                                </div>
                            </div>
                            <el-switch
                                v-model="bots.togroup"
                                style="display: block"
                                active-color="#13ce66"
                                inactive-color="#ff4949"
                                active-text="Send to Group active"
                                inactive-text="Send to Account private"
                                active-value=1
                                inactive-value=0
                                @change="updateToGroup"
                            />
                        </div>
                        <div class="col-md-4">
                            <div class="card align-items-center" style="width: 18rem;">
                                <h4 class="mt-2">Bot Information</h4>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <img :src="bots.infor ? bots.infor.avatar_image_url : '/img/bot.png'" alt="Bot Logo" style="height: 70px;">
                                    </h5>
                                    <p class="card-text">
                                        @{{ bots.infor ? bots.infor.name : 'Name Bot' }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <listroom ref="listroom" v-show="bots.togroup == 1"></listroom>
                </div>
            </div>
        </section>
    </div>
    @include('clients.common.footer')
    <loading
    :active.sync="isLoading"
    :is-full-page="true"
    :color="loadColor"
    :background-color="loadBg"></loading>
    <notifications group="notify" />
</div>
<script src="{{ mix('/js/library/app.js') }}"></script>
@yield('script')
</body>
</html>
