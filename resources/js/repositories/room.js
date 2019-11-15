import Repository from '@/service';

const resource = '/rooms';

export default {
    save (payload) {
        return Repository.post(`${resource}`, payload);
    },
    get (api) {
        return Repository.get(`${resource}/fetch/${api}`);
    },
};
