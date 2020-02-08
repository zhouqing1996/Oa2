<template>
  <div class="div1">
    <br/>
    <span class="spannew">创建申请表</span>
    <br>
    <br>
    <span class="spannewName" >申请表名称<input v-model="sName" ></input></span>
<!--    <span>{{sName}}</span>-->
    <br>
    <p>
        <span class="spannewName">申请类型
          <select v-model="sType" style="font-size: 15px;width: 180px">
            <option :value="item.typeid" v-for="item in slisttype" >{{item.typename}}</option>
          </select>
        </span>
      <br>
      <br>
      <!--        <span class="spantime" >申请时间<span>{{stime}}</span></span>-->
    </p>
    <br>
    <div style="margin: auto;text-align: center">
      <button class="btnNew" v-on:click="createS"  >开始创建</button>
      <button class="btnNew" v-on:click="stop"  >取消创建</button>
    </div>
    <br>
    <br><br><br>
    <hr>
    <span class="span2"> 你(<span style="color: red">{{pname}}</span>)正在创建申请表</span>
  </div>
</template>

<script>
    export default {
        name: "Listnew",
        data(){
            return{
                sName:'',//申请表名称
                sType:'',//申请类型
                stime:new Date(),//申请时间
                pid:this.$store.getters.getUserid,
                pname:this.$store.getters.getUsername,
                slisttype:[],//申请表类型
            }
        },
        methods:{
            Date:function(){
                var d = new Date();
                var year = d.getFullYear();
                var dateArr =[d.getMonth()+1,d.getDate(),d.getHours(),d.getMinutes(),d.getSeconds()];
                for(var i=0;i<dateArr.length;i++)
                {
                    if(dateArr[i]>=1&&dateArr[i]<=9){
                        dateArr[i]="0"+dateArr[i];
                    }
                }
                var strD = year+'-'+dateArr[0]+'-'+dateArr[1]+' '+dateArr[2]+':'+dateArr[3]+':'+dateArr[4];
                this.stime = strD;
                console.log(this.stime);
            },
            createS:function () {
                // 创建申请表
                let that = this;
                if (that.pid != ''&&that.sName!=''&&that.sType!=''){
                    this.$http.post('/document/newsp/createnew', {
                        pid: that.pid,
                        tid: that.sType,
                        stitle: that.sName,
                        stime: that.stime
                    }).then(res => {
                        console.log(res);
                        alert("开始创建申请表！");
                        this.$router.push({name:'application',params:{spName:that.sName,spTime:that.stime,spType:that.sType}});
                    }).catch(function (err) {
                        console.log(err);
                    });
                }
                else{
                    alert('请输入申请表的名称和类型！');
                }
            },
            stop:function () {
                this.$router.go(-1);
            },
            getListType:function () {
                //申请表类型
                let that = this;
                this.$http.get('/document/newsp/getlisttype').then(function (res) {
                    console.log(res.data.data)
                    that.slisttype = res.data.data;
                }).catch(function (error) {
                    console.log(error);
                })
            }
        },
        created() {
            this.Date();
            this.getListType();
        },
        computed:{
            getUserName(){
                return this.$store.getters.getUsername
            },
            getUserId() {
                return this.$store.getters.getUserid
            },
            getUserDpt() {
                return this.$store.getters.getUserdpt
            }
        }
    }
</script>

<style scoped>
@import "../../../common/css/list.css";
</style>
