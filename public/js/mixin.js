var mixin = {
    data: function () {
        return {
            url_bots_infor: '/bots/',
        }
    },
    methods: {
        handleError(error) {
            if (error.response.status == 500) {
                toastr.error('ApiKey invalid', 'Error');

                return;
            }

            return (error.response && error.response.data) ? error.response.data.errors : null;
        }
    },
}