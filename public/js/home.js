axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Vue.config.devtools = true;

window.data = {
    'auth': $('#checkAuth').val() ?  true : false,
}

var home = new Vue({
    el: '#app',
    mixins: [mixin],
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
                toastr.warning('Please Login', 'Warning');

                return;
            }
            if (!this.api_key) {
                toastr.warning('Please add apiKey', 'Warning');

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
                toastr.success('Api Valid');
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
                toastr.warning('Please Login', 'Warning');

                return;
            }

            var form = new FormData();
            var self = this;
            form.append('file', this.file);
            form.append('sheet', this.sheetName);
            axios.post(self.url_upload_excel, form)
            .then(response => {
                this.displayDataSuccess(response)
                $('#list-members').DataTable().ajax.reload();
            })
            .catch(error => {
                this.displayAlertError(error)
            })
        },

        saveBot() {
            if (!this.auth) {
                toastr.warning('Please Login', 'Warning');

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
                toastr.success('Save Bots Success');
            }).catch((error) => {
                self.formErrors = this.handleError(error);
            });
        },
    },
});

$(document).ready(function () {
    if (window.data.auth) {
        $('#list-members').DataTable({
            "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]],
            "iDisplayLength": 10,
            "process": true,
            "serverSide": false,
            "ajax": 'members',
            "columns": [
                { data:'full_name' },
                { data:'birthday' },
                { data:'company_email' },
                { data:'action' },
            ],
        })
    }
})


