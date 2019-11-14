import AuthRepository from '@/repositories/auth';
import MemberRepository from '@/repositories/member';
import BotRepository from '@/repositories/bot';
import RoomRepository from '@/repositories/room';

const repositories = {
    auth: AuthRepository,
    member: MemberRepository,
    bot: BotRepository,
    room: RoomRepository,
};

const RepositoryFactory = {
    get: name => repositories[name],
};

export { RepositoryFactory };
