axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Vue.config.devtools = true;

var home = new Vue({
    el: '#app',
    mixins: [mixin],
    data: {
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
        }
    },
});
