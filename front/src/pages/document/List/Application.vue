<template>
<!--    创建申请表-->
  <div class="div1">
    <el-col :span="1"></el-col>
    <el-col :span="4">
      <h4 class="Newh4">常见类型<i class="el-icon-postcard"></i></h4>
      <el-menu :unique-opened="true"
               style="background-color: white">
        <div><button class="Newbutton"><i class="el-icon-edit-outline"></i>填空类</button></div>
        <hr>
        <button class="Newbutton"><i class="el-icon-place"></i>单选类</button>
        <hr>
        <button class="Newbutton"><i class="el-icon-paperclip"></i>文件类</button>
        <hr>
        <button class="Newbutton"><i class="el-icon-help"></i>多选类</button>
      </el-menu>
    </el-col>
    <el-col :span="17">
      <router-view></router-view>
    </el-col>

  </div>
</template>

<script>
    export default {
        name: "Application",
        data(){
            return{
                Name:'',
                Time:new Date(),
                Type: '',
            }
        },
        methods:{
            handleSelect(path) {
                this.$router.push(path)
            },
            getSpName:function () {
                //得到审批名称
                this.Name = this.$route.params.spName;
                console.log(this.Name);
            },
            getSpTime:function () {
                //审批时间
                this.Time = this.$route.params.spTime;
                console.log(this.Time);
            },
            getSptype:function () {
                //审批类型
                this.Type = this.$route.params.spType;
                console.log(this.Type);
            }
        },
        created() {
            this.getSpName();
            this.getSpTime();
            this.getSptype();
        },
        watch:{
            '$route'(to,from){
                this.getSpName();
                this.getSpTime();
                this.getSptype();
            }
        },
    }
</script>

<style scoped>
  @import "../../../common/css/list.css";
</style>
