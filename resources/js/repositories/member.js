import Repository from '@/service';

const resource = '/members';

export default {
    upload (payload) {
        return Repository.post(`${resource}`, payload);
    },
    get () {
        return Repository.get(`${resource}`);
    },
    edit (payload) {
        return Repository.patch(`${resource}/${payload.id}`, payload);
    },
    delete (id) {
        return Repository.delete(`${resource}/${id}`);
    },
    deleteMultiple (payload) {
        return Repository.post(`${resource}/multipledelete`, payload);
    },
};
