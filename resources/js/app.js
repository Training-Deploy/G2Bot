/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Vue.config.devtools = true;

window.data = {
    'auth': $('#checkAuth').val() ?  true : false,
}

import Vue from 'vue'
import ListMember from '@comp/ListMember.vue'
import PortalVue from 'portal-vue'
import ElementUI from 'element-ui'
import {mixin} from './mixin'
import en from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import 'element-ui/lib/theme-chalk/index.css'
import BootstrapVue from 'bootstrap-vue'
import datePicker from 'vue-bootstrap-datetimepicker'
import VueDataTables from 'vue-data-tables'
import Notifications from 'vue-notification'
window.Vue = require('vue');
locale.use(en)

Vue.use(ElementUI)
Vue.use(VueDataTables)
Vue.use(PortalVue)
Vue.use(BootstrapVue)
Vue.use(datePicker)
Vue.use(Notifications)

const app = new Vue({
    el: '#app',
    mixins:[mixin],
    components: {
        listmember: ListMember,
    },
    data: {
        title: 'Upload File Excel',
        status: null,
        file: '',
        sheetName: 'MemberInfo',
        fileName: 'Choose File',
        api_key: '',
        account_id: null,
        formErrors: null,
        loginErrors: null,
        bots: {
            infor: null,
            rooms: null,
        },
        credentials: {
            email: null,
            password: null,
            remember: null,
        },
        auth: window.data.auth
    },
    watch: {
        'account_id' () {
            if (this.formErrors && this.formErrors.account_id[0]) this.formErrors.account_id[0] = null;
        },
        
        'credentials.email'() {
            if (this.loginErrors && this.loginErrors.email[0]) this.loginErrors.email[0] = null
        },
        
        'credentials.password'() {
            if (this.loginErrors && this.loginErrors.password[0]) this.loginErrors.password[0] = null
        },
    },
    
    created() {
        if (this.auth) this.getUserInfor();
    },
    methods: {
        checkBot() {
            if (!this.auth) {
                this.msg('Please login', 'warn')
                
                return;
            }
            if (!this.api_key) {
                this.msg('Please add api key', 'error')
                
                return;
            }
            var self = this;
            var authOptions = {
                method: 'GET',
                url: this.url_bots + this.api_key,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then((response) => {
                self.bots = response.data;
                this.msg('Api valid', 'success')
            }).catch((error) => {
                self.bots.infor = null;
                self.bots.rooms = null;
                self.formErrors = this.handleError(error);
            });
        },
        
        login() {
            var self = this;
            var authOptions = {
                method: 'POST',
                url: this.url_login,
                params: this.credentials,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then((response) => {
                location.reload();
            }).catch((error) => {
                self.loginErrors = this.handleError(error);
            });
        },
        
        getUserInfor() {
            var self = this;
            var authOptions = {
                method: 'GET',
                url: '/',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then((response) => {
                self.api_key = response.data.bots[0].api_key;
                self.account_id = response.data.account_id;
            }).catch((error) => {
                self.formErrors = this.handleError(error);
            });
        },
        
        onFileChange(event) {
            this.file = event.target.files[0]
            this.fileName = this.file.name
        },
        attachmentCreate() {
            if (!this.auth) {
                this.msg('Please login', 'warn')

                return;
            }
            
            var form = new FormData();
            var self = this;
            form.append('file', this.file);
            form.append('sheet', this.sheetName);
            axios.post(self.url_upload_excel, form)
            .then(response => {
                this.displayDataSuccess(response)
                this.$refs.members.fetchMembers()
            })
            .catch(error => {
                this.displayAlertError(error)
            })
        },
        
        saveBot() {
            if (!this.auth) {
                this.msg('Please login', 'warn')

                return;
            }
            
            var self = this;
            var authOptions = {
                method: 'POST',
                url: this.url_bots,
                params: {
                    'api_key': this.api_key,
                    'account_id': this.account_id,
                },
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            
            axios(authOptions).then((response) => {
                this.msg('Save bot success', 'success')
            }).catch((error) => {
                self.formErrors = this.handleError(error);
            });
        },
        
    },
});