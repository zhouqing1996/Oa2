<template>
  <div class="div1">
    <span class="span1">{{procname}}</span>
    <br>
    <br/>
    <div>
      <table >
        <tr>
          <td class="td1">申请人</td>
          <td><span v-if="Listform.userid==item.id" v-for="item in contactList">{{item.name}}</span></td>
          <td class="td1">申请部门</td>
          <td><span v-if="Listform.userid==item.id" v-for="item in contactList">{{item.department}}</span></td>
          <td class="td1">申请时间</td>
          <td>{{Listform.createtime}}</td>
        </tr>
        <tr>
          <td class="td1" colspan="2">审批内容</td>
          <td colspan="2">
          <span>{{Listform.filename}}</span>
          </td>
          <td colspan="2">
<!--            <button @click="down1()">下载1</button>-->
<!--            本地文件不能下载，谷歌Not allowed to load local resource-->
<!--            <a v-bind="{href:filedir,download:filename}"><button>下载</button></a>-->
<!--            <a v-bind="{href:filedir,download:filedir}"><button class="btn2" type="submit" v-on:click="download">下载</button></a>-->
            <a v-bind="{href:mhref,download:mname}"><button class="btn2" type="submit" v-on:click="download1">下载</button></a>
          </td>
        </tr>
        <tr>
          <td class="td1">审批人(一级审批)</td>
          <td colspan="2">
            <span v-if="Listform.stepid1==item.id" v-for="item in contactList">{{item.name}}({{item.zhiwei}})</span>
          </td>
          <td class="td1">审批意见</td>
          <td colspan="2">
            <span v-if="Listform.step1==0">未审批</span>
            <span v-if="Listform.step1==1">已审批</span>
            <span v-if="Listform.step1==2">已拒绝</span>
          </td>
        </tr>
        <tr>
          <td class="td1">审批人（二级审批)</td>
          <td colspan="2">
            <span v-if="Listform.stepid2==item.id" v-for="item in contactList">{{item.name}}({{item.zhiwei}})</span>
          </td>
          <td class="td1">审批意见</td>
          <td colspan="2">
            <span v-if="Listform.step2==0">未审批</span>
            <span v-if="Listform.step2==1">已审批</span>
            <span v-if="Listform.step2==2">已拒绝</span>
          </td>
        </tr>
      </table>
    </div>
    <br/>
    <span class="span2"> 你(<span style="color: red">{{user1}}</span>)查看{{procname}}</span>
  </div>
</template>

<script>
    import docxtemplater from 'docxtemplater';
    import PizZip from 'pizzip';
    import JSZipUtils from 'jszip-utils';
    import {saveAs} from 'file-saver';
    export default {
        name: "Looklist1",
        data(){
            return{
                mhref:'',
                mname:'',
                Listform:[],
                contactList:[],
                user1:this.$store.getters.getUsername,
                procname:'师范生教师专业能力训练、竞赛申请（推荐）表',
                filename:'',
                filedir:"http://127.0.0.1/OA/advanced/backend",
                file:'',
            }
        },
        methods:{
            // down1:function(){
            //    var userid=this.$route.query.userid;
            //    var procid=this.$route.query.procid
            //   console.log(userid,procid);
            //     this.$http.post('/document/file/downloadlist',{
            //         userid:this.$route.query.userid,
            //         procid:this.$route.query.procid
            //     }).then(res =>{
            //         console.log('http://127.0.0.1/OA/advanced/backend'+res.data.data);
            //         // window.open('http://127.0.0.1/OA/advanced/backend'+res.data.data);
            //     }).catch(function (err) {
            //         console.log(err)
            //     })
            // },
            getlooklistdata:function () {
                //获得列表1数据
                this.$http.post('/document/flow/looklistdata',{
                    responseType:'blob',
                    procname:this.procname,
                    userid:this.$route.query.userid,
                    procid:this.$route.query.procid
                }).then(res =>{
                    this.Listform = res.data.data[0];
                    console.log(res);
                }).catch(function (err) {
                    console.log(err)
                })
            },
            getContactData:function(){
                let that = this;
                this.$http.get('/document/contact/getdata?page=1').then(function (res) {
                    console.log(res.data.data)
                    that.contactList = res.data.data[0];
                }).catch(function (err) {
                    console.log(err);
                })
            },
            download1:function()
            {
                //后台下载
                this.$http.post('/document/file/downloadlist',{
                    userid:this.$route.query.userid,
                    procid:this.$route.query.procid,
                    procname:this.procname
                }).then(res =>{
                    console.log(res);
                    this.mhref='http://127.0.0.1/OA/advanced/backend' + res.data.data[0];
                    this.mname =res.data.data[1];
                    console.log(this.mhref);
                    console.log(this.mname);
                    // console.log('/downloads' + res.data.data);
                    // window.open('/downloads' + res.data.data);
                }).catch(function (err) {
                    console.log(err)
                })

            },
            // download:function () {
            //     this.$http.post('/document/file/downloadlist',{
            //         userid:this.$route.query.userid,
            //         procid:this.$route.query.procid,
            //         procname:this.procname
            //     }).then(res =>{
            //         console.log(res);
            //         this.filename = res.data.data[1];
            //         this.filedir = this.filedir+res.data.data[0];
            //         // this.file = res.data.data[2];
            //         console.log(this.filename);
            //         console.log(this.filedir);
            //         // // this.filedir = "E:/Net/xampp/htdocs/OA/advanced/backend/Uploads/20200115063803.gif";
            //         // const begin = this.filedir.indexOf("/OA");
            //         // const last = this.filedir.length;
            //         // this.filedir = this.filedir.substring(begin,last);
            //         // console.log(this.filedir);
            //     }).catch(function (err) {
            //         console.log(err)
            //     })
            // },
            downloadBtn:function()
            {
                //下载文件
                if(typeof(this.file) == 'string'){
                    var blob = new Blob([this.file],{type:"application/octet-stream"});
                    if(window.navigator.msSaveOrOpenBlob){
                        navigator.msSaveBlob(blob,this.filename);
                    }
                    else{
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = this.filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        window.URL.revokeObjectURL(link.href);
                    }
                }
            },
            btn:function(){
                //兼容性判断
                if(navigator.appVersion.toString().indexOf('.NET')>0){
                    window.navigator.msSaveBlob(this.file,this.filename);
                }
                else{
                    let url = window.URL.createObjectURL(this.file);
                    let link = document.createElement('a');
                    link.style.display='none';
                    link.href=url;
                    link.download=this.filename;
                    document.body.appendChild(link);
                    link.click();
                    window.URL.revokeObjectURL(link.href);
                }
            },
            back:function () {
                this.$router.go(-1);
            }
        },
        created() {
            this.getlooklistdata();
            this.getContactData();
            this.download();
        },
        watch:{
            '$route'(to,from){
                this.getlooklistdata();
            }
        }
    }
</script>

<style scoped>
  @import "../../../common/css/list.css";
</style>
