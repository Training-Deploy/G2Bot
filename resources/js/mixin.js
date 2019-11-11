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
            const status = error.response.status;
            if (status === 500) {
                this.msg('Api Key Invalid', 'error');

                return;
            }

            if (status === 400) {
                this.msg(error.response.data.message);
                return;
            }
            return (error.response && error.response.data) ? error.response.data.errors : null;
        },
        displayAlertError (error) {
            var template = '<div class="alert alert-danger">';
            if (Array.isArray(error.response.data.error)) {
                var errs = error.response.data.error;
                errs.forEach(element => {
                    element = element.replace(/<\/?[^>]+(>|$)/g, '');
                    template += element + '<br/>';
                    this.msg(element, 'error');
                });
                template += ' </div> ';
            } else {
                template += ' Error ! Please try again checking format date time</div>';
            }
            $('#errors').empty();
            $('#errors').html(template);
        },
        displayDataSuccess (response) {
            const data = response.data;
            var template = '<div class="success-upload alert alert-success">' +
            data.success + '<br/> Updated : <b>' + data.updated +
            '</b> Records valid<br/> Failed : <b>' + data.failed +
            ' </b> Records invalid</div> ';
            this.msg(response.data.success, 'success');
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
    },
};
export { mixin };
