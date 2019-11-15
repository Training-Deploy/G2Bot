import Repository from '@/service';

const resource = '/bots';

export default {
    save (payload) {
        return Repository.post(`${resource}`, payload);
    },
    updateStatus (api, status) {
        return Repository.patch(`${resource}/${api}`, {
            to_group: status,
        });
    },
    check (api) {
        return Repository.get(`${resource}/${api}`);
    },
};
