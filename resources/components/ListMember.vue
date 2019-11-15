<template>
  <div>
    <b-modal
      ref="edit-member"
      size="xl"
      centered
      hide-footer
      title="Edit Members"
    >
      <form
        ref="form"
        @submit.stop.prevent="editSubmit"
      >
        <div class="row">
          <div class="form-group col-md-4">
            <b-form-group
              label="Full Name"
              plaintext
              label-for="name-input"
              invalid-feedback="Name is required"
            >
              <b-form-input
                id="name-input"
                v-model="selectedMember.full_name"
                required
                readonly
              />
            </b-form-group>
          </div>
          <div class="form-group col-md-4">
            <b-form-group
              label="Birthday"
              label-for="name-input"
              invalid-feedback="Name is required"
            >
              <date-picker
                v-model="selectedMember.birthday"
                :config="options"
              />
            </b-form-group>
          </div>
          <div class="form-group col-md-4">
            <b-form-group label="Chatwork Account">
              <b-form-input
                id="chatwork-input"
                v-model="selectedMember.chatwork_account"
              />
            </b-form-group>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <b-form-group label="Company Email">
              <b-form-input
                id="company-input"
                v-model="selectedMember.company_email"
              />
            </b-form-group>
          </div>
          <div class="form-group col-md-4">
            <b-form-group label="Github Account">
              <b-form-input
                id="github-input"
                v-model="selectedMember.github_account"
              />
            </b-form-group>
          </div>
          <div class="form-group col-md-4">
            <b-form-group label="Gmail">
              <b-form-input
                id="gmail-input"
                v-model="selectedMember.gmail"
              />
            </b-form-group>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <b-form-group label="Phone">
              <b-form-input
                id="phone-input"
                v-model="selectedMember.phone"
              />
            </b-form-group>
          </div>
          <div class="form-group col-md-4">
            <b-form-group label="SSH Key">
              <b-form-input
                id="ssh-input"
                v-model="selectedMember.ssh_key"
              />
            </b-form-group>
          </div>
          <div class="form-group col-md-4">
            <b-form-group label="Viblo Link">
              <b-form-input
                id="viblo-input"
                v-model="selectedMember.viblo_link"
              />
            </b-form-group>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <b-button
              type="submit"
              variant="el-button el-button--primary"
            >
              Save
            </b-button>
          </div>
        </div>
      </form>
    </b-modal>
    <b-modal
      id="confirm_delete"
      ref="confirm_delete"
      title="Delete Confirm"
      button-size="sm"
      @ok="multipleDelete"
    >
      <p class="my-2">
        Are you want delete records ??
      </p>
    </b-modal>
    <div
      id="membersManage"
      class="mx-auto container mb-12"
    >
      <h2 class="text-purple-dark text-2xl mb-6">
        Members Manage
      </h2>
      <div class="bg-white rounded-lg p-6 md:flex lg:block box-shadow vld-parent">
        <div style="margin-bottom: 10px">
          <el-row>
            <el-col :span="4">
              <transition name="router-anim">
                <el-button
                  v-show="selectedRow.length > 0"
                  type="danger"
                  @click="confirmDelete"
                >
                  Multiple Delete
                </el-button>
              </transition>
            </el-col>
            <el-col :span="6">
              <el-input
                v-model="filters[0].value"
                placeholder="Search"
              />
            </el-col>
          </el-row>
          <el-row>
            <el-col :span="22">
              <b-form-group>
                <b-form-checkbox-group
                  id="checkbox-columns"
                  v-model="titles"
                  :options="optionsCol"
                  inline
                  :state="state"
                  class="mt-2"
                />
                <b-form-invalid-feedback :state="state">
                  Please select columns greater 1
                </b-form-invalid-feedback>
              </b-form-group>
            </el-col>
          </el-row>
        </div>
        <data-tables
          :data="members.data"
          :filters="filters"
          :action-col="actionCol"
          :page-size="10"
          :pagination-props="{ background: true, pageSizes: [5, 10, 15, 20] }"
          @selection-change="handleSelectionChange"
        >
          <el-table-column
            type="selection"
            width="55"
          />

          <el-table-column
            v-for="title in titles"
            :key="title.prop"
            :prop="title.prop"
            :label="title.label"
            sortable="custom"
          />
        </data-tables>
      </div>
    </div>
  </div>
</template>

<script>
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
import { mixin } from '@/mixin';
import { RepositoryFactory } from '@/factory';
const MemberRepository = RepositoryFactory.get('member');

export default {
    mixins: [mixin],
    data: function () {
        return {
            state: true,
            date: new Date(),
            options: {
                format: 'YYYY-MM-DD',
                useCurrent: false,
            },
            optionsCol: [
                { text: 'Full Name', value: { label: 'Full Name', prop: 'full_name' } },
                { text: 'Birth Day', value: { label: 'Birth Day', prop: 'birthday' } },
                { text: 'Company Email', value: { label: 'Company Email', prop: 'company_email' } },
                { text: 'Gmail', value: { label: 'gmail', prop: 'gmail' } },
                { text: 'Phone', value: { label: 'Phone', prop: 'phone' } },
                { text: 'Github', value: { label: 'Github', prop: 'github_account' } },
                { text: 'SSH', value: { label: 'SSH', prop: 'ssh_key' } },
                { text: 'Chatwork', value: { label: 'Chatwork', prop: 'chatwork_account' } },
            ],
            members: [],
            selectedMember: [],
            titles: [
                { label: 'Full Name', prop: 'full_name' },
                { label: 'Birth Day', prop: 'birthday' },
                { label: 'Company Email', prop: 'company_email' },
            ],
            filters: [
                {
                    prop: ['full_name', 'company_email', 'birthday'],
                    value: '',
                },
            ],
            selectedRow: [],
            actionCol: {
                props: { label: 'Action', align: 'center' },
                buttons: [
                    {
                        props: {
                            type: 'primary',
                            icon: 'el-icon-edit',
                        },
                        handler: row => {
                            this.$refs['edit-member'].show();
                            this.selectedMember = row;
                        },
                        label: 'Edit',
                    },
                    {
                        props: {
                            type: 'danger',
                            icon: 'el-icon-delete',
                        },
                        handler: row => {
                            this.members.data.splice(this.members.data.indexOf(row), 1);
                            this.deleteSubmit(row.id);
                        },
                        label: 'Delete',
                    },
                ],
            },
        };
    },
    watch: {
        titles: function () {
            if (this.titles.length >= 1) { this.state = true; } else { this.state = false; }
        },
    },
    created: function () {
        this.fetchMembers();
    },
    methods: {
        handleSelectionChange (val) {
            this.selectedRow = val;
        },
        async fetchMembers () {
            const { data } = await MemberRepository.get();
            this.members = data;
        },
        editSubmit () {
            MemberRepository.edit(this.selectedMember)
                .then((response) => {
                    this.$refs['edit-member'].hide();
                });
        },
        deleteSubmit (id) {
            MemberRepository.delete(id);
        },
        confirmDelete () {
            this.$refs.confirm_delete.show();
        },
        multipleDelete () {
            var self = this;
            MemberRepository.deleteMultiple({
                data_del: self.selectedRow.map(row => row.id),
            })
                .then((response) => {
                    self.selectedRow.map(row => {
                        this.members.data.splice(this.members.data.indexOf(row), 1);
                    });
                });
        },
    },
};
</script>
 <style scoped>
.router-anim-enter-active {
  animation: coming .3s;
  animation-delay: .3s;
  opacity: 0;
}
.router-anim-leave-active {
  animation: going .3s;
}
@keyframes going {
  from {
    transform: translateX(0);
  }
  to {
    transform: translateX(-50px);
    opacity: 0;
  }
}
@keyframes coming {
  from {
    transform: translateX(-50px);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}
.hover {
  background-color: #bcc4cc;
}
.table-hover tr {
    cursor: pointer;
}
</style>
