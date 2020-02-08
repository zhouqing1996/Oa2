<template>
    <div style="margin: auto;text-align: center">
      <div>
        <button >
          <router-link :to="{name:'test'}">申请表下载</router-link>
        </button>
      </div>
      <br>
      <br>
      <hr>
      <div>
        <form enctype="multipart/form-data" id="upload" method="post">
          <input type="file" value="" id="file" name="upfile" @change="uploadFileMethod" style="margin: auto;text-align: center"/>
          <button v-on:click="t" style="margin: auto;text-align: center">提交</button>
        </form>
      </div>
      <br>
<!--      <button v-on:click="t" style="margin: auto;text-align: center">提交</button>-->
      <br>
      <br>
      <hr>
      <div>
        <el-upload
          action=""
          :before-upload="beforeUpload"
          :on-preview="handlePreview"
          :on-remove="handleRemove"
          :on-success="handleSuccess"
          multiple
          :limit="2"
          :file-list="fileList"
          :on-change="onchange">
          <el-button size="small" type="primary" >上传</el-button>
          <div slot="tip" class="el-upload__tip">提示</div>
        </el-upload>
      </div>
    </div>
</template>

<script>
  import axios from 'axios'
    export default {
        name: "Index",
        data(){
            return{
                fileList: [],
                docList:[],
                docName:'',
                doc:'',
                imageUrl:''
            }
        },
        methods: {
            beforeUpload (file) {
                let fd = new FormData()
                fd.append('file', file)
                let that = this
                this.$http.post('/document/file/uploadpic', fd).then(function (res) {
                    // that.pic.push(res.data)
                    // that.picList[that.uploadIndex] = that.pic
                    // that.$emit('getFilelist', {list: that.list, picList: that.picList})
                    console.log(res)
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
            selectFile:function (e) {
                console.log(e);
                console.log(e.target.value);
                this.file = e.target.files[0];
                // this.filename = e.target.files[0].name;
                this.filename = e.target.value;
                if(e.target.files[0].size>10*1024*1024)
                {
                    alert("请输入小于10M的文件");
                }
                else
                {
                    if(this.filename.indexOf("txt")!=-1)
                    {
                        alert("")
                    }
                }
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
            // let formData = new FormData(document.getElementById('file1'));
            // var xhr = new XMLHttpRequest();
            // xhr.open("POST",'/yii/document/file/fileupload');
            // xhr.send(formData);
            // xhr.onreadystatechange =function () {
            //     if(xhr.readyState ==4){
            //         if((xhr.status>=200&& xhr.status<300) ||xhr.status ==304){
            //             var data = eval("(" +xhr.responseText+")");
            //             console.log(data);
            //         }
            //     }
            // }
            // var file = $('#file')[0].files[0];
            // console.log(file);
            //
            // formData.append("file",file);
            // console.log(formData.get("file"));
            // console.log(formData.values());
            // console.log(formData.getAll("file"));
            t:function()
            {
                let formData = new FormData(document.getElementById('upload'));
                console.log(formData);
                var xhr = new XMLHttpRequest();
                xhr.open("POST",'http://127.0.0.1/OA/advanced/backend/web/index.php/document/file/upload');
                xhr.send(formData);
                xhr.onreadystatechange =function () {
                    if(xhr.readyState ==4){
                        if((xhr.status>=200 && xhr.status<300) ||xhr.status ==304){
                            var data = eval("(" +xhr.responseText+")");
                            console.log(data);
                        }
                    }
                }
            },
            uploadFileMethod(param){
                let formData = new FormData(document.getElementById('upload'));
                console.log(formData);
                // let formData = new FormData();
                // formData.append('file',param.target.files[0]);
                // let url = this.$store.state.path + "backend/uploads/";
                // let config ={
                //     headers:{'Content-Type':'multipart/form-data'}
                // };
                // // this.$axios.post(url,formData,config).then(function (response) {
                // //     console.log(response.data)
                // // })
                // // console.log(this.$store.state.path);
                // console.log(formData);
                // console.log(formData.getAll("file"));
                //
                // this.$http.post('/document/file/index',{
                //     url:formData
                // }).then(res =>{
                //     console.log(res);
                // }).catch(function (err) {
                //     console.log(err)
                // })
                // axios({
                //     url:"/document/file/index",
                //     method:"POST",
                //     data:formData,
                //     file:param.target.files[0],
                //     processData:false,
                //     contentType:false,
                //     success:(response) => {
                //         console.log("upload",response)
                //     }
                // })
            },
        }
    }
</script>

<style scoped>
  /*@import "../../common/css/list.css";*/
  .avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
</style>
