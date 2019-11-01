var mixin = {
    data: function () {
        return {
            url_bots_infor: '/bots/',
            url_upload_excel: '/members/',
        }
    },
    methods: {
        handleError(error) {
            if (error.response.status == 500) {
                toastr.error('ApiKey invalid', 'Error');

                return;
            }

            return (error.response && error.response.data) ? error.response.data.errors : null;
        },
        displayAlertError(error) {
            var template = '<div class="alert alert-danger">'
            if (Array.isArray(error.response.data.error)) {
                var errs = error.response.data.error;
                errs.forEach(element => {
                    element = element.replace(/<\/?[^>]+(>|$)/g, "")
                    template += element + '<br/>'
                    toastr.error(element)
                });
                template += ' </div> '
            } else {
                template += ' Error ! Please try again checking format date time</div>'
            }
            $('#errors').empty()
            $('#errors').html(template)
        },
        displayDataSuccess(response) {
            let data = response.data
            var template = '<div class="alert alert-success">' +
            data.success + '<br/> Updated : <b>' + data.updated +
            '</b> Records valid<br/> Failed : <b>' + data.failed +
            ' </b> Records invalid</div> '
            toastr.success(response.data.success)
            
            $('#errors').empty()
            $('#errors').html(template)
        }
    },
}