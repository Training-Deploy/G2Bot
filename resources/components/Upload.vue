<template>
  <div>
    <el-upload
      class="upload-demo"
      drag
      :data="{ 'sheet' : sheet }"
      action="/members"
      :headers="{ 'X-CSRF-TOKEN': csrf }"
      :on-success="updateSuccess"
      :on-error="updateError"
      multiple
    >
      <i class="el-icon-upload" />
      <div class="el-upload__text">
        Drop file here or <em>click to upload</em>
      </div>
    </el-upload>
  </div>
</template>
<script>
import { mixin } from '@/mixin';
export default {
    mixins: [mixin],
    props: ['csrf'],
    data () {
        return {

        };
    },
    computed: {
        sheet: function () {
            return this.$parent.sheetName;
        },
    },
    methods: {
        updateSuccess (response) {
            this.msg(response.success, 'success');
            this.$parent.displayDataSuccess(response);
            this.$parent.$refs.members.fetchMembers();
        },
        updateError (err) {
            this.$parent.displayAlertError(err);
            this.msg(JSON.parse(err.message).message, 'error');
        },
    },
};
</script>
