<template>
<!--    成功流程-->
  <div class="display1">
    <div class="display2">
      <table>
        <tr>
          <th>序号</th>
          <th>流程名称</th>
          <th>发起人</th>
          <th>发起时间</th>
          <th>流程状态</th>
          <th>操作</th>
        </tr>
        <tr v-for="(n,key) in List">
          <td>{{key+1}}</td>
          <td>{{n.procname}}</td>
          <td v-if="n.proc_userid==item.id" v-for="item in contactList">{{item.name}}
          <td>{{n.proc_createtime}}</td>
          <td v-if="n.proc_ok==1">完成</td>
          <td v-if="n.proc_ok==2">已被拒</td>
          <td>
            <button v-if="n.procname == '网络与新媒体审批备案申请'">
              <router-link :to="{name:'looklist10',query:{userid:n.proc_userid,procid:n.procid}}" >查看</router-link>
            </button>
            <button v-if="n.procname == '师范生教师专业能力训练、竞赛申请（推荐）表'">
              <router-link :to="{name:'looklist1',query:{userid:n.proc_userid,procid:n.procid}}" >查看</router-link>
            </button>
            <button v-if="n.procname == '优秀共青团员（干部）申请'">
              <router-link :to="{name:'looklist2',query:{userid:n.proc_userid,procid:n.procid}}" >查看</router-link>
            </button>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
    export default {
        name: "Flowok",
        data(){
            return{
                List:[],//流程列表
                userid:this.$store.getters.getUserid,
                contactList:[],
            }
        },
        methods:{
            getmyflowok:function () {
                // 我创建的流程中流转成功的
                console.log(this.userid);
                this.$http.post('/document/flow/myflowok', {
                    user:this.userid
                }).then(res => {
                    console.log(res.data);
                    this.List = res.data.data[0];
                }).catch(function (error) {
                    console.log(error)
                })
            },
            getData:function(){
                let that = this;
                this.$http.get('/document/contact/getdata?page=1').then(function (res) {
                    console.log(res.data.data)
                    that.contactList = res.data.data[0];
                }).catch(function (err) {
                    console.log(err);
                })
            },

        },
        created() {
            this.getData();
            this.getmyflowok();
        },
    }
</script>

<style scoped>
  @import "../../common/css/oa.css";
</style>
