<template>
  <div>
    <el-table
      :data="rooms"
      style="width: 100%"
    >
      <el-table-column
        prop="icon_path"
        label="Icon"
        width="180"
      >
        <template slot-scope="scope">
          <img
            class="image chatwork"
            :src="scope.row.icon_path"
          >
        </template>
      </el-table-column>
      <el-table-column
        prop="name"
        label="Name Room"
      />
      <el-table-column
        prop="room_id"
        label="Room ID"
      />
      <el-table-column
        label="Active"
      >
        <template slot-scope="scope">
          <el-switch
            v-model="scope.row.active"
            active-color="#13ce66"
            @change="changeActive(scope.row)"
          />
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>
<script>
import { mixin } from '@/mixin';
import { RepositoryFactory } from '@/factory';
const RoomRepository = RepositoryFactory.get('room');

export default {
    mixins: [mixin],
    data: function () {
        return {
            rooms: [],
            roomsActive: [],
        };
    },
    created () {
    },
    methods: {
        async fetchRooms () {
            var res = await RoomRepository.get(this.$parent.api_key);
            this.rooms = _.toArray(res.data.rooms);
            this.$parent.bots.infor = res.data.infor;
        },
        formatIcon (row) {
            return '<img src=\'' + row.icon_path + '\' />\'';
        },
        changeActive (row) {
            var self = this;
            const data = {
                room_id: row.room_id,
                room_name: row.name,
                api_key: self.$parent.api_key,
                active: row.active,
            };
            RoomRepository.save(data);
        },
    },
};
</script>
