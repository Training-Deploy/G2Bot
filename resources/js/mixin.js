var mixin = {
    data: function () {
        return {
            url_bots: '/bots/',
            url_upload_excel: '/members/',
            url_home: '/',
            url_login: '/login/submit',
        };
    },
    methods: {
        handleError (error) {
            let message = '';
            if (typeof error !== 'undefined') {
                if (_.has(error, 'message')) {
                    message = error.message;
                }
            }

            if (typeof error.response !== 'undefined') {
                if (error.response.status === 401) {
                    message = 'UnAuthorized';
                } else if (error.response.status === 404) {
                    message = 'API Route is Missing or Undefined';
                } else if (error.response.status === 405) {
                    message = 'API Route Method Not Allowed';
                } else if (error.response.status === 422) {
                    // Validation Message
                } else if (error.response.status >= 500) {
                    message = 'Server Error';
                }

                if (_.has(error, 'response') && _.has(error.response, 'data')) {
                    if (_.has(error.response.data, 'message') && error.response.data.message.length > 0) {
                        message = error.response.data.message;
                    }
                }
            }

            if (message.length > 0) {
                this.msg(message, 'error');
            }

            return (error.response && error.response.data) ? error.response.data.errors : null;
        },
        handleSuccess (response) {
            let message = '';
            if (typeof response !== 'undefined') {
                if (_.has(response, 'data') && _.has(response.data, 'success')) {
                    message = response.data.success;
                }
            }

            if (message.length > 0) {
                this.msg(message, 'success');
            }
        },
        displayAlertError (error) {
            var template = '<div class="alert alert-danger">';
            error = JSON.parse(error.message);
            if (_.has(error, 'message')) {
                var errs = error.message;
                errs = errs.replace(/<\/?[^>]+(>|$)/g, '');
                template += errs + '</div>';
            } else {
                template += ' Error ! Please try again checking format date time</div>';
            }
            $('#errors').empty();
            $('#errors').html(template);
        },
        displayDataSuccess (response) {
            var template = '<div class="success-upload alert alert-success">' +
      response.success + '<br/> Updated : <b>' + response.updated +
            '</b> Records valid<br/> Failed : <b>' + response.failed +
            ' </b> Records invalid</div> ';
            $('#errors').empty();
            $('#errors').html(template);
        },
        msg (msg, type) {
            Vue.notify({
                group: 'notify',
                type: type,
                text: msg,
                closeOnClick: true,
            });
        },
        perm (key, msg) {
            if (!key) {
                this.msg(msg, 'error');
                throw new Error(key);
            }
        },
    },
};
export { mixin };
