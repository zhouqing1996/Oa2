<template>
<!--  师范生教师专业能力训练、竞赛申请（推荐）表-->
  <div class="div1">
    <br>
    <span class="span1">师范生教师专业能力训练、竞赛申请（推荐）表</span>
    <br/>
    <div>
      <table :model="Listform">
        <tr>
          <td class="td1">申请人</td>
          <td>{{Listform.user}}</td>
          <td class="td1">申请部门</td>
          <td>{{Listform.userDer}}</td>
          <td class="td1">申请时间</td>
          <td>{{Listform.createtime}}</td>
        </tr>
        <tr>
          <td class="td1">申请表</td>
          <td colspan="6">
            <el-upload
              action=""
              :before-upload="beforeUpload"
              :on-preview="handlePreview"
              :on-remove="handleRemove"
              :on-success="handleSuccess"
              multiple
              :limit="1"
              :file-list="fileList"
              :http-request="uploadfile"
              :on-change="onchange">
              <el-button size="small" type="primary" >上传</el-button>
              <div slot="tip" class="el-upload__tip">最多上传1个文件</div>
            </el-upload>
          </td>
        </tr>
        <tr>
          <td class="td1">审批人(一级审批)</td>
          <td colspan="2">
            <select v-model="Listform.p1" style="font-size: 15px;width: 180px">
              <option :value="item.id" v-for="item in contactList1" >{{item.name}}({{item.zhiwei}})</option>
            </select>
          </td>
          <td class="td1">审批人（二级审批)</td>
          <td colspan="2">
            <select v-model="Listform.p2" style="font-size: 15px;width: 180px">
              <option :value="item.id" v-for="item in contactList2">{{item.name}}({{item.zhiwei}})</option>
            </select>
          </td>
        </tr>
      </table>
      <div class="div2">
        <button class="btn1" type="submit" v-on:click="submit(Listform)">提交申请</button>
        <button class="btn1" v-on:click="stop">终止申请</button>
      </div>
    </div>
    <br/>
    <span class="span2"> 你(<span style="color: red">{{user1}}</span>)正在申请师范生教师专业能力训练、竞赛申请（推荐）表</span>
  </div>
</template>

<script>
    export default {
        name: "List1",
        data(){
            return{
                fileList: [],
                filename:'',//文件
                filedir:'',
                user1:this.$store.getters.getUsername,
                Listform:{
                    procname:"师范生教师专业能力训练、竞赛申请（推荐）表",
                    user:this.$store.getters.getUsername,
                    userid:this.$store.getters.getUserid,
                    userDer:this.$store.getters.getUserdpt,
                    createtime:new Date(),
                    p1:'',//一级审批人
                    p2:'',//二级审批人
                    // filedir:''//上传文件路径
                },
                contactList1:[],
                contactList2:[],
            }
        },
        methods:{
            beforeUpload (file) {
                let fd = new FormData()
                fd.append('file', file)
                let that = this
                this.$http.post('/document/file/uploadfile', fd).then(function (res) {
                    console.log(res)
                    that.filename= res.data.data[1];
                    that.filedir = res.data.data[2];
                    console.log(that.filename);
                    console.log(that.filedir);
                })
            },
            // 点击移除文件按钮触发
            handleRemove (file, fileList) {
                console.log(file,fileList)
            },
            handlePreview (file) {
                console.log(file)
            },
            handleSuccess (response, file, fileList) {
                console.log(response,file,fileList)
            },
            // 覆盖默认的提交动作
            uploadfile () {},
            // 文件上传成功可触发
            onchange (file, fileList) {
                console.log(file,fileList)
            },
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
                this.Listform.createtime = strD;
                console.log(this.Listform.createtime);
            },
            getContactList1:function(){
                // 联系人列表
                let that = this;
                this.$http.post('/document/contact/getdata1',{
                    userdpt:this.$store.getters.getUserdpt,
                    user:this.$store.getters.getUserid,
                }).then(function (res) {
                    console.log(res.data.data)
                    that.contactList1 = res.data.data[0];
                })
            },
            getContactList2:function(){
                // 联系人列表
                let that = this;
                this.$http.post('/document/contact/getdata2',{
                    userdpt:this.$store.getters.getUserdpt,
                    user:this.$store.getters.getUserid,
                }).then(function (res) {
                    console.log(res.data.data)
                    that.contactList2 = res.data.data[0];
                })
            },
            submit:function(Listform) {
                // 提交申请
                console.log(Listform);
                console.log(this.filename);
                console.log(this.filedir);
                // this.Date();
                let that=this;
                if (that.Listform.procname != '' && that.Listform.userid!= ''  )
                    this.$http.post('/document/flow/newflow', {
                        procname: that.Listform.procname,
                        username: that.Listform.user,
                        userid: that.Listform.userid,
                        userDpt: that.Listform.name,
                        createtime:that.Listform.createtime,
                        stepid1: that.Listform.p1,
                        stepid2: that.Listform.p2,
                        filename:that.filename,
                        filedir:that.filedir
                    }).then(res =>{
                        console.log(res);
                        this.$router.go(-1);
                    }).catch(function (err) {
                        console.log(err);
                    })
                else{
                    alert('提交申请失败！');
                }
            },
            stop:function () {
                this.$router.go(-1);
            },
            getObjectUrl:function(file)
            {
                let url = null;
                if(window.createObjectURL != undefined)
                {
                    url=window.createObjectURL(file);
                }
                else if (window.webkitURL !=null){
                    url=window.webkitURL.createObjectURL(file);
                }else if(window.URL !=undefined)
                {
                    url = window.URL.createObjectURL(file);
                }
                return url;
            },

            // selectFile:function () {
            //     this.docList = event.target.files;
            //     console.log(this.docList);
            //     let formData = new FormData();
            //     formData.append("docName",this.docList[0].name);
            //     console.log(formData.get("docName"));
            //     this.docName=formData.get("docName");
            // },
            // BtnFile:function(){
            //     document.getElementById('file').click()
            // },
            // t1:function()
            // {
            //     let fileid=document.getElementById('file');
            //     console.log(fileid);
            //     let filename = document.getElementsByName('file');
            //     console.log(filename);
            //     let files = document.getElementById('file').files[0];
            //     this.doc = this.getObjectUrl(files);
            //     console.log(this.doc);
            //     let value = document.getElementById('file').value;
            //     console.log(value);
            //     var dd=$('.file').get(0).files[0];
            //     let formData = new FormData();
            //     formData.append("docid",fileid);
            //     formData.append("docname",filename);
            //     formData.append("docUrl",this.doc);
            //     formData.append("docValue",value);
            //     let formData1 = new FormData();
            //     formData1.append("dd",dd);
            //     $.ajax({
            //         url:'/document/flow/test1',
            //         data:formData1,
            //         type:'POST',
            //         dataType:'json',
            //         processData: false,
            //         contentType:false,
            //         success:function (response) {
            //             console.log(response)
            //         },
            //         error:function (response) {
            //             console.log(response)
            //         }
            //     })
            //
            // },
            // t:function()
            // {
            //     let fileid=document.getElementById('file');
            //     console.log(fileid);
            //     let filename = document.getElementsByName('file');
            //     console.log(filename);
            //     let files = document.getElementById('file').files[0];
            //     this.doc = this.getObjectUrl(files);
            //     console.log(this.doc);
            //     let value = document.getElementById('file').value;
            //     console.log(value);
            //     var dd=$('.file').get(0).files[0];
            //     console.log(dd);
            //     let formData = new FormData();
            //     formData.append("docid",fileid);
            //     formData.append("docname",filename);
            //     formData.append("docUrl",this.doc);
            //     formData.append("docValue",value);
            //     formData.append("dd",dd);
            //     console.log(formData.get("dd"));
            //     this.$http.post('/document/flow/test2',{
            //         headers:{
            //             'Content-Type':'multipart/form-data'
            //         },
            //         doc:formData.get("dd")
            //     }).then(res =>{
            //         console.log(res);
            //         alert("提交申请成功！");
            //         this.$router.go(-1);
            //     }).catch(function (err) {
            //         console.log(err);
            //     })
            // },
            // submit:function(Listform) {
            //     // 提交申请
            //     console.log(Listform);
            //     this.Date();
            //     let that = this;
            //     let formData = new FormData();
            //     // for(var i=0;i<this.file.length;i++)
            //     // {
            //     //     formData.append("doc",this.file[i]);
            //     // }
            //     formData.append("doc",this.doc);
            //     if (that.Listform.procname != '' && that.Listform.userid!= ''  )
            //         this.$http.post('/document/flow/newflow1', {
            //             headers:{
            //                 'Content-Type':'multipart/form-data'
            //             },
            //             procname: that.Listform.procname,
            //             username: that.Listform.user,
            //             userid: that.Listform.userid,
            //             userDpt: that.Listform.name,
            //             createtime:that.Listform.createtime,
            //             stepid1: that.Listform.p1,
            //             stepid2: that.Listform.p2,
            //             text:that.doc,
            //         }).then(res =>{
            //             console.log(res);
            //             if(res.data.messge="文件无法保存")
            //             {
            //                 alert("提交申请失败！");
            //             }
            //             else{
            //                 alert("提交申请成功！");
            //                 this.$router.go(-1);
            //             }
            //         }).catch(function (err) {
            //             console.log(err);
            //         })
            //     else{
            //         alert('提交申请失败！');
            //     }
            // },
        },
        created() {
            this.Date();
            this.getContactList2();
            this.getContactList1();
        }
    }
</script>

<style scoped>
@import "../../../common/css/list.css";
  /*@import "../../../common/js/list.js";*/
</style>
