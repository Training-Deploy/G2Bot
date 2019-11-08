<template>
  <div>
       
    <b-modal ref="edit-member" size="xl" centered hide-footer title="Edit Members">
        <form ref="form" @submit.stop.prevent="editSubmit">
            <div class="row">
                <div class="form-group col-md-4">
                    <b-form-group label="Full Name" plaintext label-for="name-input" invalid-feedback="Name is required">
                        <b-form-input
                            id="name-input"
                            required
                            v-model="selectedMember.full_name"
                            readonly
                        ></b-form-input>
                    </b-form-group>
                </div>
                <div class="form-group col-md-4">
                     <b-form-group label="Birthday" label-for="name-input" invalid-feedback="Name is required">
                        <date-picker v-model="selectedMember.birthday" :config="options"></date-picker>
                    </b-form-group>
                </div>
                <div class="form-group col-md-4">
                     <b-form-group label="Chatwork Account">
                        <b-form-input
                            id="chatwork-input"
                            v-model="selectedMember.chatwork_account"
                        ></b-form-input>
                    </b-form-group>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <b-form-group label="Company Email">
                        <b-form-input
                            id="company-input"
                            v-model="selectedMember.company_email"
                        ></b-form-input>
                    </b-form-group>
                </div>
                <div class="form-group col-md-4">
                     <b-form-group label="Github Account">
                        <b-form-input
                            id="github-input"
                            v-model="selectedMember.github_account"
                        ></b-form-input>
                    </b-form-group>
                </div>
                <div class="form-group col-md-4">
                     <b-form-group label="Gmail">
                        <b-form-input
                            id="gmail-input"
                            v-model="selectedMember.gmail"
                        ></b-form-input>
                    </b-form-group>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <b-form-group label="Phone">
                        <b-form-input
                            id="phone-input"
                            v-model="selectedMember.phone"
                        ></b-form-input>
                    </b-form-group>
                </div>
                <div class="form-group col-md-4">
                     <b-form-group label="SSH Key">
                        <b-form-input
                            id="ssh-input"
                            v-model="selectedMember.ssh_key"
                        ></b-form-input>
                    </b-form-group>
                </div>
                <div class="form-group col-md-4">
                     <b-form-group label="Viblo Link">
                        <b-form-input
                            id="viblo-input"
                            v-model="selectedMember.viblo_link"
                        ></b-form-input>
                    </b-form-group>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <b-button type="submit" variant="el-button el-button--primary">Save</b-button>
                </div>
            </div>
        </form>
    </b-modal>
     <b-modal id="confirm_delete" ref="confirm_delete" title="Delete Confirm" button-size="sm" @ok="multipleDelete">
        <p class="my-2">Are you want delete records ??</p>
     </b-modal>
    <div class="mx-auto container mb-12">
        <h2 class="text-purple-dark text-2xl mb-6">
            Members Manage
        </h2>
        <div class="bg-white rounded-lg p-6 md:flex lg:block box-shadow">
            <div style="margin-bottom: 10px">
                <el-row>
                    <el-col :span="4">
                        <transition name="router-anim">
                            <el-button type="danger" @click="confirmDelete" v-show="selectedRow.length > 0">Multiple Delete</el-button>
                        </transition>
                    </el-col>
                    <el-col :span="6">
                        <el-input placeholder="Search" v-model="filters[0].value"></el-input>
                    </el-col>
                </el-row>
            </div>
            <data-tables :data="members.data" :filters="filters" :action-col="actionCol" :pagination-props="{ pageSizes: [5, 10, 15, 20] }" @selection-change="handleSelectionChange">
            <el-table-column type="selection" width="55">
            </el-table-column>

            <el-table-column v-for="title in titles" :prop="title.prop" :label="title.label" :key="title.prop" sortable="custom">
            </el-table-column>
            </data-tables>
        </div>
    </div>
  </div>
</template>

 <script>
import { resolve, reject } from 'q';
import 'bootstrap/dist/css/bootstrap.css';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
import {mixin} from '@/mixin'

 export default {
    mixins:[mixin],
    data : function() {
        return {
                date: new Date(),
                options: {
                    format: 'YYYY-MM-DD',
                    useCurrent: false,
                },   
                members : [],
                selectedMember:[],
                titles : [
                    {
                        label : "Full Name",
                        prop : "full_name",
                    },
                    {
                        label: "Birth Day",
                        prop: "birthday",
                    },
                    {
                        label: "Company Email",
                        prop: "company_email",
                    }
                ],
                filters: [
                    {
                        prop: ['full_name','company_email'],
                        value: ''
                    },
                ],
                selectedRow: [],
                actionCol: {
                    props: {
                        label: 'Action',
                        align: 'center',
                     },
                    buttons: [
                        {
                            props: {
                                type: 'primary',
                                icon: 'el-icon-edit'
                            },
                            handler: row => {
                                this.$refs['edit-member'].show()
                                this.selectedMember = row
                            },
                            label: 'Edit',
                        }, 
                        {
                            props : {
                                type: 'danger',
                                icon: 'el-icon-delete'
                            },
                            handler: row => {
                                this.members.data.splice(this.members.data.indexOf(row), 1)
                                this.deleteSubmit(row.id)
                            },
                            label: 'Delete'
                        }
                    ]
            },
        }
      
   },
    created: function () {
        this.fetchMembers()
    },
    methods: {
        handleSelectionChange(val) {
            this.selectedRow = val
        },
        async fetchMembers() {
            var self = this
            var authOptions = {
                method: 'GET',
                url: '/members',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                json: true
            }
            var res = await axios(authOptions);
            self.members = res.data
        },
        editSubmit() {
            axios.patch('/members/'+this.selectedMember.id, this.selectedMember).
                then((response) => {
                this.msg('Edit successfully', 'success')
                this.$refs['edit-member'].hide()
                resolve(response.data)
            })
        },
        deleteSubmit(id) {
            axios.delete('/members/'+id)
            .then((response) => {
                this.msg('Delete successfully', 'success')
                resolve(response.data)
            })
        },
        confirmDelete() {
            this.$refs['confirm_delete'].show()
        },
        multipleDelete() {
            let self = this;
            let listIds = self.selectedRow.map(row => row.id)
            axios.post('/members/multipledelete', {data_del : listIds})
            .then((response) => {
                this.msg('Delete successfully', 'success')
                self.selectedRow.map(row => {
                    this.members.data.splice(this.members.data.indexOf(row), 1)
                })
                resolve(response.data)
            })
            .catch((error) => {
                this.msg('Error', 'error')
            })
        },
    }
 }
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