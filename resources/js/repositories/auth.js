import Repository from '@/service';

const resource = '/login';

export default {
    login (payload) {
        return Repository.post(`${resource}/submit`, payload);
    },
    getAuth () {
        return Repository.get('auth');
    },
};
