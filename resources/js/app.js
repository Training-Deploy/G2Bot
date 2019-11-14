/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import ListMember from '@comp/ListMember.vue';
import ListRoom from '@comp/ListRoom.vue';
import Upload from '@comp/Upload.vue';
import PortalVue from 'portal-vue';
import ElementUI from 'element-ui';
import { mixin } from './mixin';
import en from 'element-ui/lib/locale/lang/en';
import locale from 'element-ui/lib/locale';
import 'element-ui/lib/theme-chalk/index.css';
import BootstrapVue from 'bootstrap-vue';
import datePicker from 'vue-bootstrap-datetimepicker';
import VueDataTables from 'vue-data-tables';
import Notifications from 'vue-notification';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import { RepositoryFactory } from '@/factory';
const AuthRepository = RepositoryFactory.get('auth');
const MemberRepository = RepositoryFactory.get('member');
const BotRepository = RepositoryFactory.get('bot');

require('./bootstrap');
Vue.config.devtools = true;

window.data = {
    auth: !!$('#checkAuth').val(),
};
window.Vue = require('vue');
locale.use(en);

Vue.use(ElementUI);
Vue.use(VueDataTables);
Vue.use(PortalVue);
Vue.use(BootstrapVue);
Vue.use(datePicker);
Vue.use(Notifications);

var app = new Vue({
    el: '#app',
    components: {
        listmember: ListMember,
        Loading,
        listroom: ListRoom,
        Upload,
    },
    mixins: [mixin],
    data: {
        isLoading: false,
        loadColor: '#519df0',
        loadBg: '#ececec',
        status: null,
        file: '',
        sheetName: 'MemberInfo',
        api_key: '',
        account_id: null,
        formErrors: null,
        loginErrors: null,
        bots: {
            infor: null,
            togroup: 1,
        },
        credentials: {
            email: null,
            password: null,
            remember: null,
        },
        auth: window.data.auth,
    },
    watch: {
        'account_id' () {
            if (this.formErrors && this.formErrors.account_id[0]) { this.formErrors.account_id[0] = null; }
        },

        'credentials.email' () {
            if (this.loginErrors && this.loginErrors.email[0]) { this.loginErrors.email[0] = null; }
        },

        'credentials.password' () {
            if (this.loginErrors && this.loginErrors.password[0]) { this.loginErrors.password[0] = null; }
        },

        'api_key' () {
            if (this.api_key && this.auth) { this.$refs.listroom.fetchRooms(); }
        },
    },

    created () {
        if (this.auth) { this.getUserInfor(); }
    },
    methods: {
        checkBot () {
            this.perm(this.auth, 'Please login');
            this.perm(this.api_key, 'Please add Api key');
            var self = this;
            BotRepository.check(this.api_key)
                .then((response) => {
                    self.bots.infor = response.data.infor;
                });
        },

        login () {
            AuthRepository.login(this.credentials)
                .then(() => {
                    location.reload();
                })
                .catch((error) => {
                    this.loginErrors = this.handleError(error);
                });
        },
        getUserInfor () {
            var self = this;
            AuthRepository.getAuth()
                .then((response) => {
                    if (response.data.bots.length > 0) {
                        if (_.has(response.data.bots[0], 'api_key')) {
                            self.api_key = response.data.bots[0].api_key;
                            self.bots.togroup = _.toString(response.data.bots[0].to_group);
                        }
                    }
                    self.account_id = response.data.account_id;
                });
        },

        onFileChange (event) {
            this.file = event.target.files[0];
            this.fileName = this.file.name;
        },

        attachmentCreate () {
            this.perm(this.auth, 'Please login');

            var form = new FormData();
            form.append('file', this.file);
            form.append('sheet', this.sheetName);
            MemberRepository.upload(form)
                .then(response => {
                    this.displayDataSuccess(response);
                    this.$refs.members.fetchMembers();
                })
                .catch(error => {
                    this.displayAlertError(error);
                });
        },

        saveBot () {
            this.perm(this.auth, 'Please login');
            BotRepository.save({
                api_key: this.api_key,
                account_id: this.account_id,
                to_group: this.bots.togroup,
            });
        },

        updateToGroup () {
            this.perm(this.api_key, 'Please add api');
            BotRepository.updateStatus(this.api_key, this.bots.togroup);
        },
    },
});

export { app };
