toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Vue.config.devtools = true;

var home = new Vue({
    el: '#app',
    mixins: [mixin],
    data: {
        title: 'Upload File Excel',
        status: null,
        file: '',
        sheetName: 'MemberInfo',
        fileName: 'Choose File',
        apiKey: null,
        formErrors: null,
        bots: {
            infor: null,
            rooms: null,
        },
        auth: window.data.auth
    },
    methods: {
        getBotsInfor() {
            if (!this.auth) {
                toastr.warning('Please Login', 'Warning');

                return;
            }
            if (!this.apiKey) {
                toastr.warning('Please add apiKey', 'Warning');

                return;
            }
            var self = this;
            var authOptions = {
                method: 'GET',
                url: this.url_bots_infor + this.apiKey,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            axios(authOptions).then((response) => {
                self.bots = response.data;
                toastr.success('Success');
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


